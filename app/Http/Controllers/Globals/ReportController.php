<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Expense;
use App\Models\Globals\ExpenseItems;
use App\Models\Globals\ExpenseType;
use App\Models\Globals\Invoice;
use App\Models\Globals\InvoiceItems;
use App\Models\Globals\Payees;
use App\Models\Globals\PaymentMethod;
use App\Models\Globals\Product;
use App\Models\Globals\States;
use App\Models\Globals\Suppliers;
use App\Models\Globals\Taxes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class ReportController extends Controller
{
    public function expense_report(Request $request){
        $data['menu'] = 'Expense Report';
        $data['sub_menu'] = 'EXPENSE';
        $data['url'] = 'expense-report';
        $data['start_date'] = '';
        $data['end_date'] = '';
        $cgst = 0;
        $sgst = 0;
        $igst = 0;
        $cess = 0;
        $total_amount = 0;
        $start_date = date('Y-m-d', strtotime($request['start_date']));
        $end_date = date('Y-m-d', strtotime($request['end_date']));

        if(isset($request['start_date']) && isset($request['end_date']) && !empty($request['start_date']) && !empty($request['end_date'])){
            $expenses = Expense::whereBetween('expense_date',[$start_date, $end_date])->pluck('id');

            if($expenses->count()>0){
                $expenseItem = ExpenseItems::whereIn('expense_id',$expenses)->get();
                foreach ($expenseItem as $list){
                    $tax = Taxes::where('id',$list['tax_id'])->first();
                    if(!empty($tax)){
                        if(strtolower($tax['tax_name']) == 'gst'){
                            $total_tax = $tax['rate'] / 2;
                            $cgst = $cgst + ($list['amount'] * $total_tax / 100);
                            $sgst = $sgst + ($list['amount'] * $total_tax / 100);
                        }

                        if(strtolower($tax['tax_name']) == 'igst'){
                            $igst = $igst + ($list['amount'] * $tax['rate'] / 100);
                        }

                        if($tax['is_cess'] == 1){
                            $cess = $cess + ($list['amount'] * $tax['cess'] / 100);
                        }
                    }
                }
                $total_amount = Expense::whereIn('id',$expenses)->sum('total');
            }
        }
        $data['cgst'] = $cgst>0?number_format($cgst,2):'-';
        $data['sgst'] = $sgst>0?number_format($sgst,2):'-';
        $data['igst'] = $igst>0?number_format($igst,2):'-';
        $data['cess'] = $cess>0?number_format($cess,2):'-';
        $data['total_amount'] = $total_amount>0?number_format($total_amount,2):'-';
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];

        if(isset($request['submit']) && !empty($request['submit'])){
            return view('globals.report_builder.index',$data);
        }elseif(isset($request['export']) && !empty($request['export'])){
            if(isset($expenses) && !empty($expenses)){
                $fields_key_array = array('expense_date', 'gstin', 'payee_full_name', 'payee_phone', 'payee_address', 'payee_gstin', 'expense_type', 'tax_type', 'amount_before_tax', 'amount_after_tax', 'sgst_%', 'cgst_%', 'igst_%', 'cess_%', 'sgst', 'cgst', 'igst', 'cess', 'total_tax', 'payment_method', 'status', 'total_amount');
                $fields_value_array = array('Expense_Date', 'Gstin', 'Payee_Full_Name', 'Payee_Phone', 'Payee_Address', 'Payee_Gstin', 'Expense_Type', 'Tax_Type', 'Amount_Before_tax', 'Amount_After_Tax', 'SGST_%', 'CGST_%', 'IGST_%', 'CESS_%', 'SGST', 'CGST', 'IGST', 'CESS', 'Total_Tax', 'Payment_Method', 'Status', 'Total_Amount');
                $columns = $fields_value_array;
                $main_array = ExpenseItems::whereIn('expense_id',$expenses)->get();
                $total_before_tax = 0;
                $total_after_tax = 0;
                $total_sgst = 0;
                $total_cgst = 0;
                $total_igst = 0;
                $total_cess = 0;
                $total_main_tax = 0;

                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=expense_report.csv",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );

                $callback = function() use ($main_array, $columns, $fields_key_array, $total_before_tax, $total_after_tax, $total_sgst, $total_cgst, $total_igst, $total_cess, $total_main_tax)
                {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);
                    foreach($main_array as $subarray) {
                        $sgst1 = 0;
                        $cgst1 = 0;
                        $igst1 = 0;
                        $cess1 = 0;
                        $expense_type = ExpenseType::where('id',$subarray['expense_type_id'])->first();
                        $main_expense = Expense::where('id',$subarray['expense_id'])->first();
                        $payment_method = PaymentMethod::where('id',$main_expense['payment_method'])->first();
                        $payee = Payees::where('id',$main_expense['payee_id'])->first();
                        if(!empty($payee)){
                            if($payee['type']==1){
                                $pay_user = Suppliers::where('id',$payee['type_id'])->first();
                            }elseif ($payee['type']==2){
                                $pay_user = Employees::where('id',$payee['type_id'])->first();
                            }else{
                                $pay_user = Customers::where('id',$payee['type_id'])->first();
                                $pay_user['street'] = $pay_user['billing_street'];
                                $pay_user['city'] = $pay_user['billing_city'];
                                $pay_user['pincode'] = $pay_user['billing_pincode'];
                                $pay_user['country'] = $pay_user['billing_country'];
                                $pay_user['state'] = $pay_user['billing_state'];
                            }
                            $state = States::where('id',$pay_user['state'])->first();
                            $pay_user['state'] = $state['state_name'];
                        }
                        $company = CompanySettings::where('id',$this->Company())->first();
                        //Tax calculation
                        $tax1 = Taxes::where('id',$subarray['tax_id'])->first();

                        $amount_before_tax = $subarray['amount'] * $tax1['rate'] / (100 + $tax1['rate']);
                        $new_amount_before_tax = $subarray['amount'] - $amount_before_tax;

                        if(!empty($tax1)){
                            if(strtolower($tax1['tax_name']) == 'gst'){
                                $total_tax1 = $tax1['rate'] / 2;
                                $cgst1 = $main_expense['tax_type']==2 ? $amount_before_tax / 2 : $subarray['amount'] * $total_tax1 / 100;
                                $sgst1 = $main_expense['tax_type']==2 ? $amount_before_tax / 2 : $subarray['amount'] * $total_tax1 / 100;
                            }
                            if(strtolower($tax1['tax_name']) == 'igst'){
                                $igst1 = $main_expense['tax_type']==2 ? $amount_before_tax : $subarray['amount'] * $tax1['rate'] / 100;
                            }
                            if($tax1['is_cess'] == 1){
                                $cess1 = $main_expense['tax_type']==2 ? $subarray['amount'] * $tax1['cess'] / (100 + $tax1['cess']) : $subarray['amount'] * $tax1['cess'] / 100;
                            }
                        }
                        $main_tax = $sgst1 + $cgst1 + $igst1 + $cess1;
                        $total_sgst = $total_sgst + $sgst1;
                        $total_cgst = $total_cgst + $cgst1;
                        $total_igst = $total_igst + $igst1;
                        $total_cess = $total_cess + $cess1;
                        $total_main_tax = $total_main_tax + $main_tax;

                        $total_before_tax = $main_expense['tax_type']==2 ? $total_before_tax + $new_amount_before_tax : $total_before_tax + $subarray['amount'];
                        $total_after_tax = $total_after_tax + $subarray['amount'] + $main_tax;

                        $data = array_merge(array_flip($fields_key_array), array_filter(array(
                            'expense_date' => date('d-m-Y', strtotime($main_expense['expense_date'])),
                            'gstin' => $company['gstin'],
                            'payee_full_name' => $pay_user['first_name'].' '.$pay_user['last_name'],
                            'payee_phone' => $pay_user['mobile'],
                            'payee_address' => $pay_user['street'].', '.$pay_user['city'].'-'.$pay_user['pincode'].', '.$pay_user['state'].', '.$pay_user['country'],
                            'payee_gstin' => $payee['type'] != 2?$pay_user['gstin']:'-',
                            'expense_type' => $expense_type['name'],
                            'tax_type' => $main_expense['tax_type']==1 ? 'Exclusive' : ($main_expense['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                            'amount_before_tax' => $main_expense['tax_type']==2 ? number_format($new_amount_before_tax,2) : number_format($subarray['amount'],2),
                            'amount_after_tax' => $main_expense['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
                            'sgst_%' => strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
                            'cgst_%' => strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
                            'igst_%' => strtolower($tax1['tax_name']) == 'igst'?$tax1['rate']:0,
                            'cess_%' => $tax1['is_cess'] == 1?$tax1['cess']:0,
                            'sgst' => number_format($sgst1,2),
                            'cgst' => number_format($cgst1,2),
                            'igst' => number_format($igst1,2),
                            'cess' => number_format($cess1,2),
                            'total_tax' => number_format($main_tax,2),
                            'payment_method' => $payment_method['method_name'],
                            'status' => $main_expense['status']==1?'Pending':($main_expense['status']==2?'Paid':'Voided'),
                            'total_amount' => number_format($subarray['amount'] + $main_tax,2),
                        ),
                            function ($key) use ($fields_key_array) {
                                return in_array($key, $fields_key_array);
                            }, ARRAY_FILTER_USE_KEY));
                        fputcsv($file, $data);
                    }

                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'expense_date' => '',
                        'gstin' => '',
                        'payee_full_name' => '',
                        'payee_phone' => '',
                        'payee_address' => '',
                        'payee_gstin' => '',
                        'expense_type' => '',
                        'tax_type' => '',
                        'amount_before_tax' => number_format($total_before_tax,2),
                        'amount_after_tax' => number_format($total_after_tax,2),
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => number_format($total_sgst,2),
                        'cgst' => number_format($total_cgst,2),
                        'igst' => number_format($total_igst,2),
                        'cess' => number_format($total_cess,2),
                        'total_tax' => number_format($total_main_tax,2),
                        'payment_method' => '',
                        'status' => '',
                        'total_amount' => number_format($total_after_tax,2),
                    ),
                    function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);
                    fclose($file);
                };
                return Response::stream($callback, 200, $headers);
            }else{
                return view('globals.report_builder.index',$data);
            }
        }else{
            return view('globals.report_builder.index',$data);
        }
    }

    public function invoice_report(Request $request){
        $data['menu'] = 'Invoice Report';
        $data['sub_menu'] = 'INVOICE';
        $data['url'] = 'invoice-report';
        $data['start_date'] = '';
        $data['end_date'] = '';
        $cgst = 0;
        $sgst = 0;
        $igst = 0;
        $cess = 0;
        $total_amount = 0;
        $start_date = date('Y-m-d', strtotime($request['start_date']));
        $end_date = date('Y-m-d', strtotime($request['end_date']));

        if(isset($request['start_date']) && isset($request['end_date']) && !empty($request['start_date']) && !empty($request['end_date'])){
            $invoice = Invoice::whereBetween('invoice_date',[$start_date, $end_date])->pluck('id');

            if($invoice->count()>0){
                $invoiceItem = InvoiceItems::whereIn('invoice_id',$invoice)->get();
                foreach ($invoiceItem as $list){
                    $tax = Taxes::where('id',$list['tax_id'])->first();
                    if(!empty($tax)){
                        if(strtolower($tax['tax_name']) == 'gst'){
                            $total_tax = $tax['rate'] / 2;
                            $cgst = $cgst + ($list['amount'] * $total_tax / 100);
                            $sgst = $sgst + ($list['amount'] * $total_tax / 100);
                        }

                        if(strtolower($tax['tax_name']) == 'igst'){
                            $igst = $igst + ($list['amount'] * $tax['rate'] / 100);
                        }

                        if($tax['is_cess'] == 1){
                            $cess = $cess + ($list['amount'] * $tax['cess'] / 100);
                        }
                    }
                }
                $total_amount = Invoice::whereIn('id',$invoice)->sum('total');
            }
        }
        $data['cgst'] = $cgst>0?number_format($cgst,2):'-';
        $data['sgst'] = $sgst>0?number_format($sgst,2):'-';
        $data['igst'] = $igst>0?number_format($igst,2):'-';
        $data['cess'] = $cess>0?number_format($cess,2):'-';
        $data['total_amount'] = $total_amount>0?number_format($total_amount,2):'-';
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];

        if(isset($request['submit']) && !empty($request['submit'])){
            return view('globals.report_builder.index',$data);
        }elseif(isset($request['export']) && !empty($request['export'])){
            if(isset($invoice) && !empty($invoice)){
                $fields_key_array = array('invoice_number', 'credit_note_number', 'invoice_date', 'gstin', 'customer_full_name', 'customer_phone', 'customer_address', 'customer_gstin', 'product', 'hsn_code', 'quantity', 'tax_type', 'amount_before_tax', 'amount_after_tax', 'sgst_%', 'cgst_%', 'igst_%', 'cess_%', 'sgst', 'cgst', 'igst', 'cess', 'total_tax', 'payment_method', 'status', 'total_amount');
                $fields_value_array = array('Invoice_Number', 'Credit_Note_number', 'Invoice_Date', 'Gstin', 'Customer_Full_Name', 'Customer_Phone', 'Customer_Address', 'Customer_Gstin', 'Product', 'HSN_Code', 'Quantity', 'Tax_Type', 'Amount_Before_tax', 'Amount_After_Tax', 'SGST_%', 'CGST_%', 'IGST_%', 'CESS_%', 'SGST', 'CGST', 'IGST', 'CESS', 'Total_Tax', 'Payment_Method', 'Status', 'Total_Amount');
                $columns = $fields_value_array;
                $main_array = InvoiceItems::whereIn('invoice_id',$invoice)->get();
                $total_before_tax = 0;
                $total_after_tax = 0;
                $total_sgst = 0;
                $total_cgst = 0;
                $total_igst = 0;
                $total_cess = 0;
                $total_main_tax = 0;

                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=invoice_report.csv",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );

                $callback = function() use ($main_array, $columns, $fields_key_array, $total_before_tax, $total_after_tax, $total_sgst, $total_cgst, $total_igst, $total_cess, $total_main_tax)
                {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);
                    foreach($main_array as $subarray) {
                        $sgst1 = 0;
                        $cgst1 = 0;
                        $igst1 = 0;
                        $cess1 = 0;
                        $product = Product::where('id',$subarray['product_id'])->first();
                        $main_invoice = Invoice::where('id',$subarray['invoice_id'])->first();
                        $payment_method = PaymentMethod::where('id',$main_invoice['payment_method'])->first();
                        $payee = Payees::where('id',$main_invoice['customer_id'])->first();
                        if(!empty($payee)){
                            $pay_user = Customers::where('id',$payee['type_id'])->first();
                            $state = States::where('id',$pay_user['billing_state'])->first();
                            $pay_user['state'] = $state['state_name'];
                        }
                        $company = CompanySettings::where('id',$this->Company())->first();
                        //Tax calculation
                        $tax1 = Taxes::where('id',$subarray['tax_id'])->first();

                        $amount_before_tax = $subarray['amount'] * $tax1['rate'] / (100 + $tax1['rate']);
                        $new_amount_before_tax = $subarray['amount'] - $amount_before_tax;

                        if(!empty($tax1)){
                            if(strtolower($tax1['tax_name']) == 'gst'){
                                $total_tax1 = $tax1['rate'] / 2;
                                $cgst1 = $main_invoice['tax_type']==2 ? $amount_before_tax / 2 : $subarray['amount'] * $total_tax1 / 100;
                                $sgst1 = $main_invoice['tax_type']==2 ? $amount_before_tax / 2 : $subarray['amount'] * $total_tax1 / 100;
                            }
                            if(strtolower($tax1['tax_name']) == 'igst'){
                                $igst1 = $main_invoice['tax_type']==2 ? $amount_before_tax : $subarray['amount'] * $tax1['rate'] / 100;
                            }
                            if($tax1['is_cess'] == 1){
                                $cess1 = $main_invoice['tax_type']==2 ? $subarray['amount'] * $tax1['cess'] / (100 + $tax1['cess']) : $subarray['amount'] * $tax1['cess'] / 100;
                            }
                        }
                        $main_tax = $sgst1 + $cgst1 + $igst1 + $cess1;
                        $total_sgst = $total_sgst + $sgst1;
                        $total_cgst = $total_cgst + $cgst1;
                        $total_igst = $total_igst + $igst1;
                        $total_cess = $total_cess + $cess1;
                        $total_main_tax = $total_main_tax + $main_tax;

                        $total_before_tax = $main_invoice['tax_type']==2 ? $total_before_tax + $new_amount_before_tax : $total_before_tax + $subarray['amount'];
                        $total_after_tax = $total_after_tax + $subarray['amount'] + $main_tax;

                        $data = array_merge(array_flip($fields_key_array), array_filter(array(
                            'invoice_number' => $main_invoice['invoice_number'],
                            'credit_note_number' => $main_invoice['credit_note_number'],
                            'invoice_date' => date('d-m-Y', strtotime($main_invoice['invoice_date'])),
                            'gstin' => $company['gstin'],
                            'customer_full_name' => $pay_user['first_name'].' '.$pay_user['last_name'],
                            'customer_phone' => $pay_user['mobile'],
                            'customer_address' => $pay_user['billing_street'].', '.$pay_user['billing_city'].'-'.$pay_user['billing_pincode'].', '.$pay_user['state'].', '.$pay_user['billing_country'],
                            'customer_gstin' => $pay_user['gstin'],
                            'product' => $product['title'],
                            'hsn_code' => $subarray['hsn_code'],
                            'quantity' => $subarray['quantity'],
                            'tax_type' => $main_invoice['tax_type']==1 ? 'Exclusive' : ($main_invoice['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                            'amount_before_tax' => $main_invoice['tax_type']==2 ? number_format($new_amount_before_tax,2) : number_format($subarray['amount'],2),
                            'amount_after_tax' => $main_invoice['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
                            'sgst_%' => strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
                            'cgst_%' => strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
                            'igst_%' => strtolower($tax1['tax_name']) == 'igst'?$tax1['rate']:0,
                            'cess_%' => $tax1['is_cess'] == 1 ? $tax1['cess']:0,
                            'sgst' => number_format($sgst1,2),
                            'cgst' => number_format($cgst1,2),
                            'igst' => number_format($igst1,2),
                            'cess' => number_format($cess1,2),
                            'total_tax' => number_format($main_tax,2),
                            'payment_method' => $payment_method['method_name'],
                            'status' => $main_invoice['status']==1?'Pending':($main_invoice['status']==2?'Paid':'Voided'),
                            'total_amount' => number_format($subarray['amount'] + $main_tax,2),
                        ),
                            function ($key) use ($fields_key_array) {
                                return in_array($key, $fields_key_array);
                            }, ARRAY_FILTER_USE_KEY));
                        fputcsv($file, $data);
                    }

                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'invoice_number' => '',
                        'credit_note_number' => '',
                        'invoice_date' => '',
                        'gstin' => '',
                        'customer_full_name' => '',
                        'customer_phone' => '',
                        'customer_address' => '',
                        'customer_gstin' => '',
                        'product' => '',
                        'hsn_code' => '',
                        'quantity' => '',
                        'tax_type' => '',
                        'amount_before_tax' => number_format($total_before_tax,2),
                        'amount_after_tax' => number_format($total_after_tax,2),
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => number_format($total_sgst,2),
                        'cgst' => number_format($total_cgst,2),
                        'igst' => number_format($total_igst,2),
                        'cess' => number_format($total_cess,2),
                        'total_tax' => number_format($total_main_tax,2),
                        'payment_method' => '',
                        'status' => '',
                        'total_amount' => number_format($total_after_tax,2),
                    ),
                    function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);
                    fclose($file);
                };
                return Response::stream($callback, 200, $headers);
            }else{
                return view('globals.report_builder.index',$data);
            }
        }else{
            return view('globals.report_builder.index',$data);
        }
    }
}