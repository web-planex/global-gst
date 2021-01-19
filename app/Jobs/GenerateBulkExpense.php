<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Expense;
use App\Models\Globals\Payees;
use App\Models\Globals\States;
use App\Models\Globals\Suppliers;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Taxes;
use App\Models\Globals\Product;
use App\Models\Globals\PdfZips;
use WKPDF;
use Illuminate\Support\Facades\Log;
use App\Models\Globals\ExpenseType;
use App\Http\Controllers\Controller;

class GenerateBulkExpense implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $checkboxes;
    protected $company_id;
    protected $user;
    protected $download_type;
    protected $controller;
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
        $this->controller = new Controller;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle() {
        $files = [];
        if($this->download_type == 1) {
            $files = $this->createSignleExpensePDF();
        } else if($this->download_type == 2) {
            $files = $this->createMultiExpensePDF();
        }
        if(!empty($files)) {
            foreach ($files as $file) {
                if(file_exists($file)){
                    unlink($file);
                }
            }
        }
    }

    public function createMultiExpensePDF() {
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

            $data['expense'] = Expense::with('ExpenseItems')->where('id',$id)->first();
            $data['taxes'] = Taxes::where('status', 1)->get();

            if(!empty($data['expense']['ExpenseItems'])){
                foreach($data['expense']['ExpenseItems'] as $exp){
                    $tax = Taxes::where('id',$exp['tax_id'])->first();
                    if($tax['is_cess'] == 0) {
                        $exp['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                    } else {
                        $exp['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                    }
                }
            }
            $data['expense']['total_in_word'] = $this->controller->convert_digit_to_words($data['expense']['total']);

            $payee = Payees::where('id',$data['expense']['payee_id'])->first();
            if(!empty($payee)){
                if($payee['type']==1){
                    $data['user'] = Suppliers::where('id',$payee['type_id'])->first();
                    $state = States::where('id',$data['user']['state'])->first();
                    $data['user']['state'] = $state['state_name'];
                    $data['user']['state_code'] = $state['state_number'];
                    $data['user']['billing_state'] = $state['state_name'];
                    $data['user']['billing_state_code'] = $state['state_number'];
                    $data['user']['is_shipping'] = false;
                    $address_arr = [
                        $data['user']['street'],
                        $data['user']['city'],
                        $data['user']['state'],
                        $data['user']['pincode'],
                        $data['user']['country']
                    ];
                    $data['user']['address'] = implode(', ', $address_arr);
                }elseif($payee['type']==2){
                    $data['user'] = Employees::where('id',$payee['type_id'])->first();
                    $state = States::where('id',$data['user']['state'])->first();
                    $data['user']['state'] = $state['state_name'];
                    $data['user']['billing_state'] = $state['state_name'];
                    $data['user']['billing_state_code'] = $state['state_number'];
                    $data['user']['state_code'] = $state['state_number'];
                    $data['user']['is_shipping'] = false;
                    $address_arr = [
                        $data['user']['street'],
                        $data['user']['city'],
                        $data['user']['state'],
                        $data['user']['pincode'],
                        $data['user']['country']
                    ];
                    $data['user']['address'] = implode(', ', $address_arr);
                }else{
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
                }
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
            $data['all_tax_labels'] = array_unique(array_merge($taxes_without_cess_arr ,$taxes_with_cess_arr));
            $data['products'] = Product::where('user_id',$this->user->id)->where('company_id',$this->company_id)->where('status',1)->get();
            $company = CompanySettings::select('company_name')->where('id',$this->company_id)->first();
            $data['company_name'] = $company['company_name'];
            $data['expense_types'] = ExpenseType::where('user_id',$this->user->id)->where('company_id',$this->company_id)->get();
            $data['expense']['status_image'] = '';

            if($data['expense']['status'] == 1) {
                $data['expense']['status_image'] = url('assets/images/pdf_img/pending_img.png');
            }elseif($data['expense']['status'] == 2) {
                $data['expense']['status_image'] = url('assets/images/pdf_img/paid_imag.png');
            }elseif($data['expense']['status'] == 3) {
                $data['expense']['status_image'] = url('assets/images/pdf_img/voided_imag.png');
            }

            $data['name'] = 'Expense Voucher';
            $data['content'] = 'This is test pdf.';
            $pdf = new WKPDF($this->controller->globalPdfOption());
            //return $data;
            $pdf->addPage(view('globals.expense.pdf_expense',$data));
            $path = $this->user->id.'/expense_voucher/';
            $root = base_path() . '/public/upload/' . $path;
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            if(!$pdf->saveAs(public_path().'/upload/'.$path.'expense_voucher_'.$id.'.pdf')){
                $error = $pdf->getError();
                Log::error($error);
            } else {
                $files[] = public_path().'/upload/'.$path.'expense_voucher_'.$id.'.pdf';
            }
        }
        $zip_name = 'expense_voucher_multiple_pdf_'.time().'.zip';
        $zip_path = public_path() .'/upload/'.$this->user->id.'/expense_voucher/'.$zip_name;
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
            $pdfZip->zip_type = 1;
            $pdfZip->status = 0;
            $pdfZip->save();
        }
        return $files;
    }

    public function createSignleExpensePDF() {

        $path = $this->user->id.'/expense_voucher/';
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
        $pdf = new WKPDF($this->controller->globalPdfOption());

        foreach($this->checkboxes as $id){

            $expense = Expense::with('ExpenseItems')->where('id',$id)->first();
            $taxes = Taxes::where('status', 1)->get();

            if(!empty($expense['ExpenseItems'])){
                $ct = 0;
                foreach($expense['ExpenseItems'] as $exp){
                    $tax = Taxes::where('id',$exp['tax_id'])->first();
                    if($tax['is_cess'] == 0) {
                        $expense['ExpenseItems'][$ct]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'];
                    } else {
                        $expense['ExpenseItems'][$ct]['tax_name'] = $tax['rate'].'%'.' '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS';
                    }
                    $ct++;
                }
            }
            $expense['total_in_word'] = $this->controller->convert_digit_to_words($expense['total']);

            $payee = Payees::where('id',$expense['payee_id'])->first();
            if(!empty($payee)){
                if($payee['type'] == 1){
                    $user = Suppliers::where('id',$payee['type_id'])->first();
                    $state = States::where('id',$user['state'])->first();
                    $user['state'] = $state['state_name'];
                    $user['state_code'] = $state['state_number'];
                    $user['billing_state'] = $state['state_name'];
                    $user['billing_state_code'] = $state['state_number'];
                    $user['is_shipping'] = false;
                    $address_arr = [
                        $user['street'],
                        $user['city'],
                        $user['state'],
                        $user['pincode'],
                        $user['country']
                    ];
                    $user['address'] = implode(', ', $address_arr);
                }elseif($payee['type']==2){
                    $user = Employees::where('id',$payee['type_id'])->first();
                    $state = States::where('id',$user['state'])->first();
                    $user['state'] = $state['state_name'];
                    $user['billing_state'] = $state['state_name'];
                    $user['billing_state_code'] = $state['state_number'];
                    $user['state_code'] = $state['state_number'];
                    $user['is_shipping'] = false;
                    $address_arr = [
                        $user['street'],
                        $user['city'],
                        $user['state'],
                        $user['pincode'],
                        $user['country']
                    ];
                    $user['address'] = implode(', ', $address_arr);
                }else{
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
                }
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

            $expense['status_image'] = '';

            if($expense['status'] == 1) {
                $expense['status_image'] = url('assets/images/pdf_img/pending_img.png');
            } else if($expense['status'] == 2) {
                $expense['status_image'] = url('assets/images/pdf_img/paid_imag.png');
            } else if($expense['status'] == 3) {
                $expense['status_image'] = url('assets/images/pdf_img/voided_imag.png');
            }

            $name = 'Expense Voucher';
            $content = 'This is test pdf.';

            $pdf->addPage(view('globals.expense.pdf_expense',[
                'expense' => $expense,
                'taxes' => $taxes,
                'user' => $user,
                'all_tax_labels' => $all_tax_labels,
                'products' => $products,
                'company_name' => $company_name,
                'name' => $name,
                'content' => $content,
                'company' => $company
            ]));
        }
        $file_name = 'expense_voucher.pdf';
        if(!$pdf->saveAs(public_path().'/upload/'.$path.$file_name)){
            $error = $pdf->getError();
            Log::error($error);
        } else {
            $files[] = public_path().'/upload/'.$path.$file_name;
        }

        $zip_name = 'expense_voucher_single_pdf_'.time().'.zip';
        $zip_path = public_path() .'/upload/'.$this->user->id.'/expense_voucher/'.$zip_name;
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
            $pdfZip->zip_type = 1;
            $pdfZip->status = 0;
            $pdfZip->save();
        }
        return $files;
    }
}
