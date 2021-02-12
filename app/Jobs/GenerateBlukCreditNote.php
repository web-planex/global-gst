<?php

namespace App\Jobs;

use App\Models\Globals\CompanySettings;
use App\Models\Globals\Customers;
use App\Models\Globals\Invoice;
use App\Models\Globals\Payees;
use App\Models\Globals\PdfZips;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\Taxes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use WKPDF;
use App\Http\Controllers\Globals\CommonController;

class GenerateBlukCreditNote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $checkboxes;
    protected $company_id;
    protected $user;
    protected $download_type;
    protected $invoice_type;
    protected $common_controller;

    public function __construct($user, $company_id, $checkboxes, $download_type, $invoice_type)
    {
        $this->user = $user;
        $this->company_id = $company_id;
        $this->checkboxes = $checkboxes;
        $this->download_type = $download_type;
        $this->invoice_type = $invoice_type;
        $this->common_controller = new CommonController();
    }

    public function handle()
    {
        $files = [];
        if($this->download_type == 1) {
            $files = $this->createSignleInvoicePDF();
        } else if($this->download_type == 2) {
            $files = $this->createMultiInvoicePDF();
        }
        if(!empty($files)) {
            foreach ($files as $file) {
                if(file_exists($file)){
                    unlink($file);
                }
            }
        }
    }

    public function createMultiInvoicePDF() {
        $data = [];
        $company = CompanySettings::where('id',$this->company_id)->first();
        $company->job_id = $this->job->getJobId();
        $company->save();
        $data['company'] = $company;
        $data['menu'] = 'Credit Note';
        $data['invoice_type'] = ucfirst($this->invoice_type);
        $data['print_type'] = 2;
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

        foreach($this->checkboxes as $in_id){
            $data['invoice'] = Invoice::with('InvoiceItems')->where('id',$in_id)->first();
            $data['invoice']['status_image'] = $data['invoice']['status']==1?"pending_img.png":($data['invoice']['status']==2?"paid_imag.png":"voided_imag.png");
            $data['invoice']['payment_method'] = $data['invoice']['payment_method']==1?"Cash":($data['invoice']['payment_method']==2?"Cheque":"Credit Card");

            /*Count Discount Price*/
            if($data['invoice']['discount_type']==1){
                $main_total = $data['invoice']['amount_before_tax'] + $data['invoice']['tax_amount'];
                $discount = ($main_total / 100) * $data['invoice']['discount'];
                $data['invoice']['discount_price'] = number_format($discount,2);
            }else{
                $data['invoice']['discount_price'] = $data['invoice']['discount'];
            }
            $data['taxes'] = Taxes::where('status', 1)->get();
            $tax_count = 5;
            foreach($data['taxes'] as $tax) {
                $tax['tax_name'] == 'GST' ? $tax_count += 2 : $tax_count += 1;
            }
            $data['tax_count'] = $tax_count;

            if(!empty($data['invoice']['InvoiceItems'])){
                foreach($data['invoice']['InvoiceItems'] as $item){
                    $tax = Taxes::where('id',$item['tax_id'])->first();
                    if($tax['is_cess'] == 0) {
                        $item['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                    } else {
                        $item['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                    }
                }
            }

            $data['invoice']['total_in_word'] = $this->common_controller->convert_digit_to_words($data['invoice']['total']);

            $payee = Payees::where('id',$data['invoice']['customer_id'])->first();
            if(!empty($payee)){
                $data['user'] = Customers::where('id',$payee['type_id'])->first();
                $state = States::where('id',$data['user']['billing_state'])->first();
                $shipping_state = States::where('id',$data['user']['shipping_state'])->first();
                $data['user']['state'] = $state['state_name'];
                $data['user']['state_code'] = $state['state_number'];
                $data['user']['shipping_state'] = $shipping_state['state_name'];
                $data['user']['shipping_state_code'] = $shipping_state['state_number'];
            }

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

            Log::info($data['user']);

            $data['all_tax_labels'] = array_unique(array_merge($taxes_without_cess_arr ,$taxes_with_cess_arr));
            $company = CompanySettings::select('company_name')->where('id',$this->company_id)->first();
            $data['company_name'] = $company['company_name'];
            $data['name'] = 'Credit Note';
            $data['content'] = 'This is credit note pdf.';
            $pdf = new WKPDF($this->common_controller->globalPdfOption());
            //return $data;
            $pdf->addPage(view('globals.invoice.pdf_invoice',$data));
            $path = $this->user->id.'/credit_note/';
            $root = base_path() . '/public/upload/' . $path;
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            if(!$pdf->saveAs(public_path().'/upload/'.$path.'credit_note_'.$in_id.'.pdf')){
                $error = $pdf->getError();
                Log::error($error);
            } else {
                $files[] = public_path().'/upload/'.$path.'credit_note_'.$in_id.'.pdf';
            }
        }

        $zip_name = 'credit_note_multiple_pdf_'.time().'.zip';
        $zip_path = public_path() .'/upload/'.$this->user->id.'/credit_note/'.$zip_name;
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
            $pdfZip->zip_type = 3;
            $pdfZip->status = 0;
            $pdfZip->save();
        }
        return $files;
    }

    public function createSignleInvoicePDF() {
        $path = $this->user->id.'/credit_note/';
        $root = base_path() . '/public/upload/' . $path;
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $user = [];
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
            $invoice = Invoice::with('InvoiceItems')->where('id',$id)->first();
            $taxes = Taxes::where('status', 1)->get();
            if(!empty($invoice['InvoiceItems'])){
                $ct = 0;
                foreach($invoice['InvoiceItems'] as $exp){
                    $tax = Taxes::where('id',$exp['tax_id'])->first();
                    if($tax['is_cess'] == 0) {
                        $invoice['InvoiceItems'][$ct]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                    } else {
                        $invoice['InvoiceItems'][$ct]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                    }
                    $ct++;
                }
            }
            $invoice['total_in_word'] = $this->common_controller->convert_digit_to_words($invoice['total']);

            $payee = Payees::where('id',$invoice['customer_id'])->first();
            if(!empty($payee)){
                $user = Customers::where('id',$payee['type_id'])->first();
                $state = States::where('id',$user['billing_state'])->first();
                $shipping_state = States::where('id',$user['shipping_state'])->first();
                $user['state'] = $state['state_name'];
                $user['state_code'] = $state['state_number'];
                $user['shipping_state'] = $shipping_state['state_name'];
                $user['shipping_state_code'] = $shipping_state['state_number'];
            }

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

            $invoice['status_image'] = '';
            $invoice['status_image'] = $invoice['status']==1?"pending_img.png":($invoice['status']==2?"paid_imag.png":"voided_imag.png");

            $name = 'Sales Invoice';
            $content = 'This is sales invoice pdf.';
            $pdf->addPage(view('globals.invoice.pdf_invoice',[
                'invoice' => $invoice,
                'taxes' => $taxes,
                'user' => $user,
                'all_tax_labels' => $all_tax_labels,
                'products' => $products,
                'company_name' => $company_name,
                'name' => $name,
                'content' => $content,
                'company' => $company,
                'menu' => 'Credit Note',
                'invoice_type' => ucfirst($this->invoice_type),
                'print_type' => 2
            ]));
        }
        $file_name = 'credit_note.pdf';
        if(!$pdf->saveAs(public_path().'/upload/'.$path.$file_name)){
            $error = $pdf->getError();
            Log::error($error);
        } else {
            $files[] = public_path().'/upload/'.$path.$file_name;
        }

        $zip_name = 'credit_note_single_pdf_'.time().'.zip';
        $zip_path = public_path() .'/upload/'.$this->user->id.'/credit_note/'.$zip_name;
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
            $pdfZip->zip_type = 3;
            $pdfZip->status = 0;
            $pdfZip->save();
        }
        return $files;
    }
}
