<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Customers;
use App\Models\Globals\DebitNote;
use App\Models\Globals\Payees;
use App\Models\Globals\PdfZips;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\Taxes;
use App\Models\Globals\Invoice;
use Illuminate\Support\Facades\Log;
use WKPDF;
use App\Http\Controllers\Globals\CommonController;

class GenerateBulkDebitNote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $checkboxes;
    protected $company_id;
    protected $user;
    protected $download_type;
    protected $common_controller;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $company_id, $checkboxes, $download_type)
    {
        $this->user = $user;
        $this->company_id = $company_id;
        $this->checkboxes = $checkboxes;
        $this->download_type = $download_type;
        $this->common_controller = new CommonController();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files = [];
        if($this->download_type == 1) {
            $files = $this->createSignleDebitNotePDF();
        } else if($this->download_type == 2) {
            $files = $this->createMultiDebitNotePDF();
        }
        if(!empty($files)) {
            foreach ($files as $file) {
                if(file_exists($file)){
                    unlink($file);
                }
            }
        }
    }
    
    public function createMultiDebitNotePDF() {
        $data = [];
        $company = CompanySettings::where('id',$this->company_id)->first();
        $company->job_id = $this->job->getJobId();
        $company->save();
        $data['company'] = $company;
        $state = States::where('id',$data['company']['state'])->first();
        $data['company']['state'] = $state['state_name'];
        $data['company']['state_code'] = $state['state_number'];
        $company_address_arr = [
            $data['company']['street'],
            $data['company']['city'],
            $data['company']['state'],
            $data['company']['pincode'],
            $data['company']['country'],
        ];

        $data['company']['address'] = implode(', ', $company_address_arr);
        foreach($this->checkboxes as $id){

            $data['debit_note'] = DebitNote::with('DebitNoteItems')->where('id',$id)->first();
            $data['taxes'] = Taxes::where('status', 1)->get();

            if(!empty($data['debit_note']['DebitNoteItems'])){
                foreach($data['debit_note']['DebitNoteItems'] as $exp){
                    $tax = Taxes::where('id',$exp['tax_id'])->first();
                    if($tax['is_cess'] == 0) {
                        $exp['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                    } else {
                        $exp['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                    }
                }
            }
            $data['debit_note']['total_in_word'] = $this->common_controller->convert_digit_to_words($data['debit_note']['total']);

            $payee = Payees::where('id',$data['debit_note']['customer_id'])->first();

            $data['user'] = Customers::where('id',$payee['type_id'])->first();
            $state = States::where('id',$data['user']['billing_state'])->first();
            $shipping_state = States::where('id',$data['user']['shipping_state'])->first();
            $data['user']['state'] = $state['state_name'];
            $data['user']['billing_state'] = $state['state_name'];
            $data['user']['shipping_state'] = $shipping_state['state_name'];
            $data['user']['billing_state_code'] = $state['state_number'];
            $data['user']['shipping_state_code'] = $shipping_state['state_number'];
            $data['user']['is_shipping'] = true;
            $billing_address_arr = [
                $data['user']['billing_street'],
                $data['user']['billing_city'],
                $data['user']['billing_state'],
                $data['user']['billing_pincode'],
                $data['user']['billing_country']
            ];
            $data['user']['billing_address'] = implode(', ', $billing_address_arr);
            $shipping_address_arr = [
                $data['user']['shipping_street'],
                $data['user']['shipping_city'],
                $data['user']['shipping_state'],
                $data['user']['shipping_pincode'],
                $data['user']['shipping_country']
            ];
            $data['user']['shipping_address'] = implode(', ', $shipping_address_arr);

            $taxes_without_cess = Taxes::where('is_cess', 0)->where('status', 1)->get();
            $taxes_with_cess = Taxes::where('is_cess', 1)->where('status', 1)->get();
            $taxes_without_cess_arr = [];
            $taxes_with_cess_arr = [];

            $a=0;
            foreach($taxes_without_cess as $tax) {
                $taxes_without_cess_arr[$a] = $tax['rate'].'_'.$tax['tax_name'];
                $a++;
            }
            $i=0;
            foreach($taxes_with_cess as $tax) {
                $taxes_with_cess_arr[$i] = $tax['rate'].'_'.$tax['tax_name'];
                $taxes_with_cess_arr[$i+1] = $tax['cess'].'_CESS';
                $i = $i+2;
            }
            $data['all_tax_labels'] = array_unique(array_merge($taxes_without_cess_arr ,$taxes_with_cess_arr));
            $data['products'] = Product::where('user_id',$this->user->id)->where('company_id',$this->company_id)->where('status',1)->get();
            $company = CompanySettings::select('company_name')->where('id',$this->company_id)->first();
            $data['company_name'] = $company['company_name'];
            $data['debit_note']['status_image'] = '';

            /*if($data['debit_note']['status'] == 1) {
                $data['debit_note']['status_image'] = url('assets/images/pdf_img/pending_img.png');
            }elseif($data['debit_note']['status'] == 2) {
                $data['debit_note']['status_image'] = url('assets/images/pdf_img/paid_imag.png');
            }elseif($data['debit_note']['status'] == 3) {
                $data['debit_note']['status_image'] = url('assets/images/pdf_img/voided_imag.png');
            }*/
            $data['invoice'] = Invoice::select('invoice_number')->where('id',$data['debit_note']['Invoice']['id'])->first();
            $data['name'] = 'Debit Note';
            $data['content'] = 'This is test pdf.';
            $pdf = new WKPDF($this->common_controller->globalPdfOption());
            //return $data;
            $pdf->addPage(view('globals.debit-note.pdf_debit_note',$data));
            $path = $this->user->id.'/debit_note/';
            $root = base_path() . '/public/upload/' . $path;
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            if(!$pdf->saveAs(public_path().'/upload/'.$path.'debit_note_'.$id.'.pdf')){
                $error = $pdf->getError();
                Log::error($error);
            } else {
                $files[] = public_path().'/upload/'.$path.'debit_note_'.$id.'.pdf';
            }
        }
        $zip_name = 'debit_note_multiple_pdf_'.time().'.zip';
        $zip_path = public_path() .'/upload/'.$this->user->id.'/debit_note/'.$zip_name;
        $zip = new \ZipArchive;
        $zip->open($zip_path, \ZipArchive::CREATE);
        foreach ($files as $file) {
            $file_name = explode('/', $file);
            $zip->addFile($file, end($file_name));
        }
        $zip->close();
        if(file_exists($zip_path)) {
            $pdfZip = new PdfZips();
            $pdfZip->user_id = $this->user->id;
            $pdfZip->company_id = $this->company_id;
            $pdfZip->zip_name = $zip_name;
            $pdfZip->zip_type = 6;
            $pdfZip->status = 0;
            $pdfZip->save();
        }
        return $files;
    }
    
    public function createSignleDebitNotePDF() {
        $path = $this->user->id.'/debit_note/';
        $root = base_path() . '/public/upload/' . $path;
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $company = CompanySettings::where('id',$this->company_id)->first();
        $company->job_id = $this->job->getJobId();
        $company->save();
        $state = States::where('id',$company['state'])->first();
        $company['state'] = $state['state_name'];
        $company['state_code'] = $state['state_number'];
        $company_address_arr = [
            $company['street'],
            $company['city'],
            $company['state'],
            $company['pincode'],
            $company['country'],
        ];

        $company['address'] = implode(', ', $company_address_arr);
        $pdf = new WKPDF($this->common_controller->globalPdfOption());

        foreach($this->checkboxes as $id){

            $debit_note = DebitNote::with('DebitNoteItems')->where('id',$id)->first();
            $taxes = Taxes::where('status', 1)->get();

            if(!empty($debit_note['DebitNoteItems'])){
                $ct = 0;
                foreach($debit_note['DebitNoteItems'] as $exp){
                    $tax = Taxes::where('id',$exp['tax_id'])->first();
                    if($tax['is_cess'] == 0) {
                        $debit_note['DebitNoteItems'][$ct]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                    } else {
                        $debit_note['DebitNoteItems'][$ct]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                    }
                    $ct++;
                }
            }
            $debit_note['total_in_word'] = $this->common_controller->convert_digit_to_words($debit_note['total']);

            $payee = Payees::where('id',$debit_note['customer_id'])->first();
            $user = Customers::where('id',$payee['type_id'])->first();
            $state = States::where('id',$user['billing_state'])->first();
            $shipping_state = States::where('id',$user['shipping_state'])->first();
            $user['state'] = $state['state_name'];
            $user['billing_state'] = $state['state_name'];
            $user['shipping_state'] = $shipping_state['state_name'];
            $user['billing_state_code'] = $state['state_number'];
            $user['shipping_state_code'] = $shipping_state['state_number'];
            $user['is_shipping'] = true;
            $billing_address_arr = [
                $user['billing_street'],
                $user['billing_city'],
                $user['billing_state'],
                $user['billing_pincode'],
                $user['billing_country']
            ];
            $user['billing_address'] = implode(', ', $billing_address_arr);
            $shipping_address_arr = [
                $user['shipping_street'],
                $user['shipping_city'],
                $user['shipping_state'],
                $user['shipping_pincode'],
                $user['shipping_country']
            ];
            $user['shipping_address'] = implode(', ', $shipping_address_arr);

            $taxes_without_cess = Taxes::where('is_cess', 0)->where('status', 1)->get();
            $taxes_with_cess = Taxes::where('is_cess', 1)->where('status', 1)->get();
            $taxes_without_cess_arr = [];
            $taxes_with_cess_arr = [];

            $a=0;
            foreach($taxes_without_cess as $tax) {
                $taxes_without_cess_arr[$a] = $tax['rate'].'_'.$tax['tax_name'];
                $a++;
            }
            $i=0;
            foreach($taxes_with_cess as $tax) {
                $taxes_with_cess_arr[$i] = $tax['rate'].'_'.$tax['tax_name'];
                $taxes_with_cess_arr[$i+1] = $tax['cess'].'_CESS';
                $i = $i+2;
            }
            $all_tax_labels = array_unique(array_merge($taxes_without_cess_arr ,$taxes_with_cess_arr));
            $products = Product::where('user_id',$this->user->id)->where('company_id',$this->company_id)->where('status',1)->get();
            $company_obj = CompanySettings::select('company_name')->where('id',$this->company_id)->first();
            $company_name = $company_obj['company_name'];

            $debit_note['status_image'] = '';

            /*if($debit_note['status'] == 1) {
                $debit_note['status_image'] = url('assets/images/pdf_img/pending_img.png');
            } else if($debit_note['status'] == 2) {
                $debit_note['status_image'] = url('assets/images/pdf_img/paid_imag.png');
            } else if($debit_note['status'] == 3) {
                $debit_note['status_image'] = url('assets/images/pdf_img/voided_imag.png');
            }*/
            $invoice = Invoice::select('invoice_number')->where('id',$debit_note['Invoice']['id'])->first();
            $name = 'Debit Note';
            $content = 'This is test pdf.';

            $pdf->addPage(view('globals.debit-note.pdf_debit_note',[
                'debit_note' => $debit_note,
                'taxes' => $taxes,
                'user' => $user,
                'all_tax_labels' => $all_tax_labels,
                'products' => $products,
                'company_name' => $company_name,
                'name' => $name,
                'content' => $content,
                'company' => $company,
                'invoice' => $invoice
            ]));
        }
        $file_name = 'debit_note.pdf';
        if(!$pdf->saveAs(public_path().'/upload/'.$path.$file_name)){
            $error = $pdf->getError();
            Log::error($error);
        } else {
            $files[] = public_path().'/upload/'.$path.$file_name;
        }

        $zip_name = 'debit_note_single_pdf_'.time().'.zip';
        $zip_path = public_path() .'/upload/'.$this->user->id.'/debit_note/'.$zip_name;
        $zip = new \ZipArchive;
        $zip->open($zip_path, \ZipArchive::CREATE);
        foreach ($files as $file) {
            $file_name = explode('/', $file);
            $zip->addFile($file, end($file_name));
        }
        $zip->close();
        if(file_exists($zip_path)) {
            $pdfZip = new PdfZips();
            $pdfZip->user_id = $this->user->id;
            $pdfZip->company_id = $this->company_id;
            $pdfZip->zip_name = $zip_name;
            $pdfZip->zip_type = 6;
            $pdfZip->status = 0;
            $pdfZip->save();
        }
        return $files;
    }
}
