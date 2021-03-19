<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\BillItems;
use App\Models\Globals\Bills;
use App\Models\Globals\CompanySettings;
use App\Models\Globals\Customers;
use App\Models\Globals\Employees;
use App\Models\Globals\Estimate;
use App\Models\Globals\EstimateItems;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('multiauth:web');
//        $this->middleware(['auth','verified']);
//        $this->middleware('UserAccessRight');
        $this->common_controller = new CommonController();
    }

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
            $expenses = Expense::whereBetween('expense_date',[$start_date, $end_date])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->pluck('id');

            if($expenses->count()>0){
                $expenseItem = ExpenseItems::whereIn('expense_id',$expenses)->get();
                foreach ($expenseItem as $list){
                    $all_taxes = $this->common_controller->AllTaxes(1,$list['expense_id'],$list['tax_id'], $list['amount']);
                    $cgst = $cgst + $all_taxes[0];
                    $sgst = $sgst + $all_taxes[1];
                    $igst = $igst + $all_taxes[2];
                    $cess = $cess + $all_taxes[3];
                }
                $total_amount = Expense::whereIn('id',$expenses)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('total');
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
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }
            return view('globals.report_builder.index',$data);
        }elseif(isset($request['export']) && !empty($request['export'])){
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }
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
                        $main_expense = Expense::where('id',$subarray['expense_id'])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->first();
                        $payment_method = PaymentMethod::where('id',$main_expense['payment_method'])->first();
                        $pay_user = $this->common_controller->PayUser($main_expense['payee_id']);
                        $company = CompanySettings::where('id',$this->Company())->first();

                        //Tax calculation
                        $tax1 = Taxes::where('id',$subarray['tax_id'])->first();
                        $amount_before_tax = $subarray['amount'] * $tax1['rate'] / (100 + $tax1['rate']);
                        $new_amount_before_tax = $subarray['amount'] - $amount_before_tax;

                        if(!empty($tax1)){
                            if(strtolower($tax1['tax_name']) == 'gst'){
                                $total_tax1 = $tax1['rate'] / 2;
                                $cgst1 = $main_expense['tax_type']==2 ? $amount_before_tax / 2 : ($main_expense['tax_type']==1 ? $subarray['amount'] * $total_tax1 / 100 : 0);
                                $sgst1 = $main_expense['tax_type']==2 ? $amount_before_tax / 2 : ($main_expense['tax_type']==1 ? $subarray['amount'] * $total_tax1 / 100 : 0);
                            }
                            if(strtolower($tax1['tax_name']) == 'igst'){
                                $igst1 = $main_expense['tax_type']==2 ? $amount_before_tax : ($main_expense['tax_type']==1 ? $subarray['amount'] * $tax1['rate'] / 100 : 0);
                            }
                            if($tax1['is_cess'] == 1){
                                $cess1 = $main_expense['tax_type']==2 ? $subarray['amount'] * $tax1['cess'] / (100 + $tax1['cess']) : ($main_expense['tax_type'] == 1 ?$subarray['amount'] * $tax1['cess'] / 100 : 0);
                            }
                        }
                        $main_tax = $sgst1 + $cgst1 + $igst1 + $cess1;
                        $total_sgst = $total_sgst + $sgst1;
                        $total_cgst = $total_cgst + $cgst1;
                        $total_igst = $total_igst + $igst1;
                        $total_cess = $total_cess + $cess1;
                        $total_main_tax = $total_main_tax + $main_tax;

                        $total_before_tax = $main_expense['tax_type']==2 ? $total_before_tax + $new_amount_before_tax : ($main_expense['tax_type'] == 1 ? $total_before_tax + $subarray['amount'] : $total_before_tax + $subarray['amount']);
                        $amount = $main_expense['tax_type']==2 ? $subarray['amount'] : ($main_expense['tax_type'] == 1 ? $subarray['amount'] + $main_tax : $subarray['amount']);
                        $total_after_tax = $total_after_tax + $amount;

                        $data = array_merge(array_flip($fields_key_array), array_filter(array(
                            'expense_date' => date('d-m-Y', strtotime($main_expense['expense_date'])),
                            'gstin' => $company['gstin'],
                            'payee_full_name' => $pay_user['first_name'].' '.$pay_user['last_name'],
                            'payee_phone' => $pay_user['mobile'],
                            'payee_address' => $pay_user['street'].', '.$pay_user['city'].'-'.$pay_user['pincode'].', '.$pay_user['state'].', '.$pay_user['country'],
                            'payee_gstin' => $pay_user['type'] != 2?$pay_user['gstin']:'-',
                            'expense_type' => $expense_type['name'],
                            'tax_type' => $main_expense['tax_type']==1 ? 'Exclusive' : ($main_expense['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                            'amount_before_tax' => $main_expense['tax_type']==2 ? number_format($new_amount_before_tax,2) : number_format($subarray['amount'],2),
                            'amount_after_tax' => $main_expense['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
                            'sgst_%' => in_array($main_expense['tax_type'], [1,2]) && strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
                            'cgst_%' => in_array($main_expense['tax_type'], [1,2]) && strtolower($tax1['tax_name']) == 'gst'?$tax1['rate'] / 2:0,
                            'igst_%' => in_array($main_expense['tax_type'], [1,2]) && strtolower($tax1['tax_name']) == 'igst'?$tax1['rate']:0,
                            'cess_%' => in_array($main_expense['tax_type'], [1,2]) && $tax1['is_cess'] == 1 ? $tax1['cess']:0,
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
                return Response::stream($callback, 200, $this->common_controller->Headers('expense'));
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
            $invoice = Invoice::whereBetween('invoice_date',[$start_date, $end_date])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->pluck('id');

            if($invoice->count()>0){
                $invoiceItem = InvoiceItems::whereIn('invoice_id',$invoice)->get();
                foreach ($invoiceItem as $list){
                    $main_type = Invoice::where('id',$list['invoice_id'])->first();
                    if($main_type['status'] != 3){
                        $all_taxes = $this->common_controller->AllTaxes(2,$list['invoice_id'],$list['tax_id'], $list['amount']);
                        $cgst = $cgst + $all_taxes[0];
                        $sgst = $sgst + $all_taxes[1];
                        $igst = $igst + $all_taxes[2];
                        $cess = $cess + $all_taxes[3];
                    }
                }
                $total_amount = Invoice::whereIn('id',$invoice)->where('status', '!=', 3)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('total');
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
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            return view('globals.report_builder.index',$data);
        }elseif(isset($request['export']) && !empty($request['export'])){
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            if(isset($invoice) && !empty($invoice)){
                $fields_key_array = array('invoice_number', 'credit_note_number', 'invoice_date', 'gstin', 'customer_full_name', 'customer_phone', 'customer_address', 'customer_gstin', 'product', 'hsn_code', 'quantity', 'rate', 'tax_type', 'amount_before_tax', 'amount_after_tax', 'sgst_%', 'cgst_%', 'igst_%', 'cess_%', 'sgst', 'cgst', 'igst', 'cess', 'total_tax', 'discount_level', 'discount_type', 'discount', 'payment_method', 'status', 'total_amount');
                $fields_value_array = array('Invoice_Number', 'Credit_Note_number', 'Invoice_Date', 'Gstin', 'Customer_Full_Name', 'Customer_Phone', 'Customer_Address', 'Customer_Gstin', 'Product', 'HSN_Code', 'Quantity', 'Rate', 'Tax_Type', 'Amount_Before_tax', 'Amount_After_Tax', 'SGST_%', 'CGST_%', 'IGST_%', 'CESS_%', 'SGST', 'CGST', 'IGST', 'CESS', 'Total_Tax', 'Discount_Level', 'Discount_Type', 'Discount', 'Payment_Method', 'Status', 'Total_Amount');
                $columns = $fields_value_array;
                $main_array = InvoiceItems::whereIn('invoice_id',$invoice)->get();
                $total_before_tax = 0;
                $total_after_tax = 0;
                $total_discount = 0;
                $total_sgst = 0;
                $total_cgst = 0;
                $total_igst = 0;
                $total_cess = 0;
                $total_main_tax = 0;

                $callback = function() use ($invoice, $main_array, $columns, $fields_key_array, $total_before_tax, $total_after_tax, $total_sgst, $total_cgst, $total_igst, $total_cess, $total_main_tax, $total_discount)
                {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);

                    $main_discount = Invoice::whereIn('id',$invoice)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->where('status','!=',3)->sum('discount');
                    $main_shipping_charge = Invoice::whereIn('id',$invoice)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->where('status','!=',3)->sum('shipping_charge_amount');

                    //All InvoiceItems List
                    foreach($main_array as $subarray) {
                        $product = Product::where('id',$subarray['product_id'])->first();
                        $main_invoice = Invoice::where('id',$subarray['invoice_id'])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->first();
                        $payment_method = PaymentMethod::where('id',$main_invoice['payment_method'])->first();
                        $pay_user = $this->common_controller->PayUser($main_invoice['customer_id']);
                        $company = CompanySettings::where('id',$this->Company())->first();

                        //Tax calculation
                        $tax_data = $this->common_controller->TaxCount($subarray['tax_id'],$subarray['amount'],$main_invoice['tax_type'],$main_invoice['status'],$total_sgst,$total_cgst, $total_igst,$total_cess,$total_main_tax,$total_before_tax,$total_after_tax);

                        $main_tax = $tax_data[0] + $tax_data[1] + $tax_data[2] + $tax_data[3];
                        $amount = $main_invoice['tax_type']==2 ? $subarray['amount'] : ($main_invoice['tax_type'] == 1 ? $subarray['amount'] + $main_tax : $subarray['amount']);
                        if($main_invoice['status'] != 3){
                            $total_sgst = $total_sgst + $tax_data[0];
                            $total_cgst = $total_cgst + $tax_data[1];
                            $total_igst = $total_igst + $tax_data[2];
                            $total_cess = $total_cess + $tax_data[3];
                            $total_main_tax = $total_main_tax + $main_tax;
                            $total_before_tax = $main_invoice['tax_type']==2 ? $total_before_tax + $tax_data[4] : ($main_invoice['tax_type'] == 1 ? $total_before_tax + $subarray['amount'] : $total_before_tax + $subarray['amount']);
                            $total_after_tax = $total_after_tax + $amount;
                        }

                        if($subarray['discount_type']==1){
                            $dis = !empty($subarray['discount']) ? $subarray['rate'] * $subarray['discount'] / 100 :0;
                        }else{
                            $dis = !empty($subarray['discount']) ? $subarray['discount'] : 0;
                        }
                        $total_discount = $total_discount + $dis;

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
                            'rate' => $subarray['rate'],
                            'tax_type' => $main_invoice['tax_type']==1 ? 'Exclusive' : ($main_invoice['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                            'amount_before_tax' => $main_invoice['tax_type']==2 ? number_format($tax_data[4],2) : number_format($subarray['amount'],2),
                            'amount_after_tax' => $main_invoice['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
                            'sgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'cgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'igst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'igst'?$tax_data[5]['rate']:0,
                            'cess_%' => in_array($main_invoice['tax_type'], [1,2]) && $tax_data[5]['is_cess'] == 1 ? $tax_data[5]['cess']:0,
                            'sgst' => number_format($tax_data[0],2),
                            'cgst' => number_format($tax_data[1],2),
                            'igst' => number_format($tax_data[2],2),
                            'cess' => number_format($tax_data[3],2),
                            'total_tax' => number_format($main_tax,2),
                            'discount_level' => $main_invoice['discount_level']==0 ? 'Transaction Level' : 'Item Level',
                            'discount_type' => $main_invoice['discount_level']==1 && $subarray['discount_type']==1  ? $subarray['discount'].' %' : ($main_invoice['discount_level']==1 && $subarray['discount_type']==2 ? 'Rs.' : ''),
                            'discount' => !empty($subarray['discount']) && $subarray['discount_type']==1 ? number_format($subarray['rate'] * $subarray['discount'] / 100 ,2) : (!empty($subarray['discount']) && $subarray['discount_type']==2 ? $subarray['discount'] : ''),
                            'payment_method' => $payment_method['method_name'],
                            'status' => $main_invoice['status']==1?'Pending':($main_invoice['status']==2?'Paid':'Voided'),
                            'total_amount' => number_format($subarray['amount'] + $main_tax,2),
                        ),
                        function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                        fputcsv($file, $data);

                        if($main_invoice['status']==3){
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
                                'rate' => $subarray['rate'],
                                'tax_type' => $main_invoice['tax_type']==1 ? 'Exclusive' : ($main_invoice['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                                'amount_before_tax' => $main_invoice['tax_type']==2 ? '-'.number_format($tax_data[4],2) : '-'.number_format($subarray['amount'],2),
                                'amount_after_tax' => $main_invoice['tax_type']==1 ? '-'.number_format($subarray['amount'] + $main_tax,2) : '-'.number_format($subarray['amount'],2),
                                'sgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                                'cgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                                'igst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'igst'?$tax_data[5]['rate']:0,
                                'cess_%' => in_array($main_invoice['tax_type'], [1,2]) && $tax_data[5]['is_cess'] == 1 ? $tax_data[5]['cess']:0,
                                'sgst' => '-'.number_format($tax_data[0],2),
                                'cgst' => '-'.number_format($tax_data[1],2),
                                'igst' => '-'.number_format($tax_data[2],2),
                                'cess' => '-'.number_format($tax_data[3],2),
                                'total_tax' => '-'.number_format($main_tax,2),
                                'discount_level' => $main_invoice['discount_level']==0 ? 'Transaction Level' : 'Item Level',
                                'discount_type' => $main_invoice['discount_level']==1 && $subarray['discount_type']==1  ? $subarray['discount'].' %' : ($main_invoice['discount_level']==1 && $subarray['discount_type']==2 ? 'Rs.' : ''),
                                'discount' => !empty($subarray['discount']) && $subarray['discount_type']==1 ? number_format($subarray['rate'] * $subarray['discount'] / 100 ,2) : (!empty($subarray['discount']) && $subarray['discount_type']==2 ? $subarray['discount'] : ''),
                                'payment_method' => $payment_method['method_name'],
                                'status' => $main_invoice['status']==1?'Pending':($main_invoice['status']==2?'Paid':'Voided'),
                                'total_amount' => '-'.number_format($subarray['amount'] + $main_tax,2),
                            ),
                            function ($key) use ($fields_key_array) {
                                return in_array($key, $fields_key_array);
                            }, ARRAY_FILTER_USE_KEY));
                            fputcsv($file, $data);
                        }
                    }

                    // All Totals
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
                        'rate' => '',
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
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => $total_discount>0 ? number_format($total_discount,2) :'',
                        'payment_method' => '',
                        'status' => '',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Blank Line
                    $data = [];
                    fputcsv($file, $data);

                    //Main Final Total Label
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
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => '',
                        'payment_method' => 'Transaction Level Discount',
                        'status' => 'Total Shipping Charge',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Main Final Total
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
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => '',
                        'payment_method' => $main_discount,
                        'status' => $main_shipping_charge,
                        'total_amount' => number_format($total_after_tax - $main_discount + $main_shipping_charge,2),
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    fclose($file);
                };

                return Response::stream($callback, 200, $this->common_controller->Headers('invoice'));
            }else{
                return view('globals.report_builder.index',$data);
            }
        }else{
            return view('globals.report_builder.index',$data);
        }
    }

    public function estimate_report(Request $request){
        $data['menu'] = 'Estimate Report';
        $data['sub_menu'] = 'ESTIMATE';
        $data['url'] = 'estimate-report';
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
            $estimate = Estimate::whereBetween('estimate_date',[$start_date, $end_date])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->pluck('id');

            if($estimate->count()>0){
                $estimateItem = EstimateItems::whereIn('estimate_id',$estimate)->get();
                foreach ($estimateItem as $list){
                    $all_taxes = $this->common_controller->AllTaxes(3,$list['estimate_id'],$list['tax_id'], $list['amount']);
                    $cgst = $cgst + $all_taxes[0];
                    $sgst = $sgst + $all_taxes[1];
                    $igst = $igst + $all_taxes[2];
                    $cess = $cess + $all_taxes[3];
                }
                $total_amount = Estimate::whereIn('id',$estimate)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('total');
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
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            return view('globals.report_builder.index',$data);
        }elseif(isset($request['export']) && !empty($request['export'])){
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            if(isset($estimate) && !empty($estimate)){
                $fields_key_array = array('estimate_number', 'estimate_date', 'gstin', 'customer_full_name', 'customer_phone', 'customer_address', 'customer_gstin', 'product', 'hsn_code', 'quantity', 'rate', 'tax_type', 'amount_before_tax', 'amount_after_tax', 'sgst_%', 'cgst_%', 'igst_%', 'cess_%', 'sgst', 'cgst', 'igst', 'cess', 'total_tax', 'discount_level', 'discount_type', 'discount', 'total_amount');
                $fields_value_array = array('Estimate_Number', 'Estimate_Date', 'Gstin', 'Customer_Full_Name', 'Customer_Phone', 'Customer_Address', 'Customer_Gstin', 'Product', 'HSN_Code', 'Quantity', 'Rate', 'Tax_Type', 'Amount_Before_tax', 'Amount_After_Tax', 'SGST_%', 'CGST_%', 'IGST_%', 'CESS_%', 'SGST', 'CGST', 'IGST', 'CESS', 'Total_Tax', 'Discount_Level', 'Discount_Type', 'Discount', 'Total_Amount');
                $columns = $fields_value_array;
                $main_array = EstimateItems::whereIn('estimate_id',$estimate)->get();
                $total_before_tax = 0;
                $total_after_tax = 0;
                $total_discount = 0;
                $total_sgst = 0;
                $total_cgst = 0;
                $total_igst = 0;
                $total_cess = 0;
                $total_main_tax = 0;

                $callback = function() use ($estimate, $main_array, $columns, $fields_key_array, $total_before_tax, $total_after_tax, $total_sgst, $total_cgst, $total_igst, $total_cess, $total_main_tax, $total_discount)
                {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);

                    $main_discount = Estimate::whereIn('id',$estimate)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('discount');
                    $main_shipping_charge = Estimate::whereIn('id',$estimate)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('shipping_charge_amount');

                    //All InvoiceItems List
                    foreach($main_array as $subarray) {
                        $sgst1 = 0;
                        $cgst1 = 0;
                        $igst1 = 0;
                        $cess1 = 0;
                        $product = Product::where('id',$subarray['product_id'])->first();
                        $main_estimate = Estimate::where('id',$subarray['estimate_id'])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->first();
                        $pay_user = $this->common_controller->PayUser($main_estimate['customer_id']);
                        $company = CompanySettings::where('id',$this->Company())->first();
                        //Tax calculation
                        $tax_data = $this->common_controller->TaxCount($subarray['tax_id'],$subarray['amount'],$main_estimate['tax_type'],$main_estimate['status'],$total_sgst,$total_cgst, $total_igst,$total_cess,$total_main_tax,$total_before_tax,$total_after_tax);

                        $main_tax = $tax_data[0] + $tax_data[1] + $tax_data[2] + $tax_data[3];
                        $amount = $main_estimate['tax_type']==2 ? $subarray['amount'] : ($main_estimate['tax_type'] == 1 ? $subarray['amount'] + $main_tax : $subarray['amount']);
                        $total_sgst = $total_sgst + $tax_data[0];
                        $total_cgst = $total_cgst + $tax_data[1];
                        $total_igst = $total_igst + $tax_data[2];
                        $total_cess = $total_cess + $tax_data[3];
                        $total_main_tax = $total_main_tax + $main_tax;
                        $total_before_tax = $main_estimate['tax_type']==2 ? $total_before_tax + $tax_data[4] : ($main_estimate['tax_type'] == 1 ? $total_before_tax + $subarray['amount'] : $total_before_tax + $subarray['amount']);
                        $total_after_tax = $total_after_tax + $amount;

                        if($subarray['discount_type']==1){
                            $dis = !empty($subarray['discount']) ? $subarray['rate'] * $subarray['discount'] / 100 :0;
                        }else{
                            $dis = !empty($subarray['discount']) ? $subarray['discount'] : 0;
                        }
                        $total_discount = $total_discount + $dis;

                        $data = array_merge(array_flip($fields_key_array), array_filter(array(
                            'estimate_number' => $main_estimate['estimate_number'],
                            'estimate_date' => date('d-m-Y', strtotime($main_estimate['estimate_date'])),
                            'gstin' => $company['gstin'],
                            'customer_full_name' => $pay_user['first_name'].' '.$pay_user['last_name'],
                            'customer_phone' => $pay_user['mobile'],
                            'customer_address' => $pay_user['billing_street'].', '.$pay_user['billing_city'].'-'.$pay_user['billing_pincode'].', '.$pay_user['state'].', '.$pay_user['billing_country'],
                            'customer_gstin' => $pay_user['gstin'],
                            'product' => $product['title'],
                            'hsn_code' => $subarray['hsn_code'],
                            'quantity' => $subarray['quantity'],
                            'rate' => $subarray['rate'],
                            'tax_type' => $main_estimate['tax_type']==1 ? 'Exclusive' : ($main_estimate['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                            'amount_before_tax' => $main_estimate['tax_type']==2 ? number_format($tax_data[4],2) : number_format($subarray['amount'],2),
                            'amount_after_tax' => $main_estimate['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
                            'sgst_%' => in_array($main_estimate['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'cgst_%' => in_array($main_estimate['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'igst_%' => in_array($main_estimate['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'igst'?$tax_data[5]['rate']:0,
                            'cess_%' => in_array($main_estimate['tax_type'], [1,2]) && $tax_data[5]['is_cess'] == 1 ? $tax_data[5]['cess']:0,
                            'sgst' => number_format($tax_data[0],2),
                            'cgst' => number_format($tax_data[1],2),
                            'igst' => number_format($tax_data[2],2),
                            'cess' => number_format($tax_data[3],2),
                            'total_tax' => number_format($main_tax,2),
                            'discount_level' => $main_estimate['discount_level']==0 ? 'Transaction Level' : 'Item Level',
                            'discount_type' => $main_estimate['discount_level']==1 && $subarray['discount_type']==1  ? $subarray['discount'].' %' : ($main_estimate['discount_level']==1 && $subarray['discount_type']==2 ? 'Rs.' : ''),
                            'discount' => !empty($subarray['discount']) && $subarray['discount_type']==1 ? number_format($subarray['rate'] * $subarray['discount'] / 100 ,2) : (!empty($subarray['discount']) && $subarray['discount_type']==2 ? $subarray['discount'] : ''),
                            'total_amount' => number_format($subarray['amount'] + $main_tax,2),
                        ),
                        function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                        fputcsv($file, $data);
                    }

                    // All Totals
                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'estimate_number' => '',
                        'estimate_date' => '',
                        'gstin' => '',
                        'customer_full_name' => '',
                        'customer_phone' => '',
                        'customer_address' => '',
                        'customer_gstin' => '',
                        'product' => '',
                        'hsn_code' => '',
                        'quantity' => '',
                        'rate' => '',
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
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => $total_discount>0 ? number_format($total_discount,2) :'',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Blank Line
                    $data = [];
                    fputcsv($file, $data);

                    //Main Final Total Label
                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'estimate_number' => '',
                        'estimate_date' => '',
                        'gstin' => '',
                        'customer_full_name' => '',
                        'customer_phone' => '',
                        'customer_address' => '',
                        'customer_gstin' => '',
                        'product' => '',
                        'hsn_code' => '',
                        'quantity' => '',
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => 'Transaction Level Discount',
                        'discount' => 'Total Shipping Charge',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Main Final Total
                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'estimate_number' => '',
                        'estimate_date' => '',
                        'gstin' => '',
                        'customer_full_name' => '',
                        'customer_phone' => '',
                        'customer_address' => '',
                        'customer_gstin' => '',
                        'product' => '',
                        'hsn_code' => '',
                        'quantity' => '',
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => $main_discount,
                        'discount' => $main_shipping_charge,
                        'total_amount' => number_format($total_after_tax - $main_discount + $main_shipping_charge,2),
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    fclose($file);
                };

                return Response::stream($callback, 200, $this->common_controller->Headers('estimate'));
            }else{
                return view('globals.report_builder.index',$data);
            }
        }else{
            return view('globals.report_builder.index',$data);
        }
    }

    public function credit_note_report(Request $request){
        $data['menu'] = 'Credit Note Report';
        $data['sub_menu'] = 'CREDIT NOTE';
        $data['url'] = 'credit-note-report';
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
            $invoice = Invoice::whereIn('status',[3,4])->whereBetween('void_date',[$start_date, $end_date])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->pluck('id');
            if($invoice->count()>0){
                $invoiceItem = InvoiceItems::whereIn('invoice_id',$invoice)->get();
                foreach ($invoiceItem as $list){
                    $all_taxes = $this->common_controller->AllTaxes(2,$list['invoice_id'],$list['tax_id'], $list['amount']);
                    $cgst = $cgst + $all_taxes[0];
                    $sgst = $sgst + $all_taxes[1];
                    $igst = $igst + $all_taxes[2];
                    $cess = $cess + $all_taxes[3];
                }
                $total_amount = Invoice::whereIn('id',$invoice)->whereIn('status',[3,4])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('total');
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
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            return view('globals.report_builder.index',$data);
        }elseif(isset($request['export']) && !empty($request['export'])){
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            if(isset($invoice) && !empty($invoice)){
                $fields_key_array = array('invoice_number', 'credit_note_number', 'invoice_date', 'gstin', 'customer_full_name', 'customer_phone', 'customer_address', 'customer_gstin', 'product', 'hsn_code', 'quantity', 'rate', 'tax_type', 'amount_before_tax', 'amount_after_tax', 'sgst_%', 'cgst_%', 'igst_%', 'cess_%', 'sgst', 'cgst', 'igst', 'cess', 'total_tax', 'discount_level', 'discount_type', 'discount', 'payment_method', 'status', 'total_amount');
                $fields_value_array = array('Invoice_Number', 'Credit_Note_number', 'Invoice_Date', 'Gstin', 'Customer_Full_Name', 'Customer_Phone', 'Customer_Address', 'Customer_Gstin', 'Product', 'HSN_Code', 'Quantity', 'Rate', 'Tax_Type', 'Amount_Before_tax', 'Amount_After_Tax', 'SGST_%', 'CGST_%', 'IGST_%', 'CESS_%', 'SGST', 'CGST', 'IGST', 'CESS', 'Total_Tax', 'Discount_Level', 'Discount_Type', 'Discount', 'Payment_Method', 'Status', 'Total_Amount');
                $columns = $fields_value_array;
                $main_array = InvoiceItems::whereIn('invoice_id',$invoice)->get();
                $total_before_tax = 0;
                $total_after_tax = 0;
                $total_discount = 0;
                $total_sgst = 0;
                $total_cgst = 0;
                $total_igst = 0;
                $total_cess = 0;
                $total_main_tax = 0;

                $callback = function() use ($invoice, $main_array, $columns, $fields_key_array, $total_before_tax, $total_after_tax, $total_sgst, $total_cgst, $total_igst, $total_cess, $total_main_tax, $total_discount)
                {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);

                    $main_discount = Invoice::whereIn('id',$invoice)->whereIn('status',[3,4])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('discount');
                    $main_shipping_charge = Invoice::whereIn('id',$invoice)->whereIn('status',[3,4])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('shipping_charge_amount');

                    //All InvoiceItems List
                    foreach($main_array as $subarray) {
                        $sgst1 = 0;
                        $cgst1 = 0;
                        $igst1 = 0;
                        $cess1 = 0;
                        $product = Product::where('id',$subarray['product_id'])->first();
                        $main_invoice = Invoice::where('id',$subarray['invoice_id'])->whereIn('status',[3,4])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->first();
                        $payment_method = PaymentMethod::where('id',$main_invoice['payment_method'])->first();
                        $pay_user = $this->common_controller->PayUser($main_invoice['customer_id']);
                        $company = CompanySettings::where('id',$this->Company())->first();

                        //Tax calculation
                        $tax_data = $this->common_controller->TaxCount($subarray['tax_id'],$subarray['amount'],$main_invoice['tax_type'],$main_invoice['status'],$total_sgst,$total_cgst, $total_igst,$total_cess,$total_main_tax,$total_before_tax,$total_after_tax);
                        $main_tax = $tax_data[0] + $tax_data[1] + $tax_data[2] + $tax_data[3];
                        $amount = $main_invoice['tax_type']==2 ? $subarray['amount'] : ($main_invoice['tax_type'] == 1 ? $subarray['amount'] + $main_tax : $subarray['amount']);
                        $total_sgst = $total_sgst + $tax_data[0];
                        $total_cgst = $total_cgst + $tax_data[1];
                        $total_igst = $total_igst + $tax_data[2];
                        $total_cess = $total_cess + $tax_data[3];
                        $total_main_tax = $total_main_tax + $main_tax;
                        $total_before_tax = $main_invoice['tax_type']==2 ? $total_before_tax + $tax_data[4] : ($main_invoice['tax_type'] == 1 ? $total_before_tax + $subarray['amount'] : $total_before_tax + $subarray['amount']);
                        $total_after_tax = $total_after_tax + $amount;

                        if($subarray['discount_type']==1){
                            $dis = !empty($subarray['discount']) ? $subarray['rate'] * $subarray['discount'] / 100 :0;
                        }else{
                            $dis = !empty($subarray['discount']) ? $subarray['discount'] : 0;
                        }
                        $total_discount = $total_discount + $dis;

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
                            'rate' => $subarray['rate'],
                            'tax_type' => $main_invoice['tax_type']==1 ? 'Exclusive' : ($main_invoice['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                            'amount_before_tax' => $main_invoice['tax_type']==2 ? number_format($tax_data[4],2) : number_format($subarray['amount'],2),
                            'amount_after_tax' => $main_invoice['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
                            'sgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'cgst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'igst_%' => in_array($main_invoice['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'igst'?$tax_data[5]['rate']:0,
                            'cess_%' => in_array($main_invoice['tax_type'], [1,2]) && $tax_data[5]['is_cess'] == 1 ? $tax_data[5]['cess']:0,
                            'sgst' => number_format($tax_data[0],2),
                            'cgst' => number_format($tax_data[1],2),
                            'igst' => number_format($tax_data[2],2),
                            'cess' => number_format($tax_data[3],2),
                            'total_tax' => number_format($main_tax,2),
                            'discount_level' => $main_invoice['discount_level']==0 ? 'Transaction Level' : 'Item Level',
                            'discount_type' => $main_invoice['discount_level']==1 && $subarray['discount_type']==1  ? $subarray['discount'].' %' : ($main_invoice['discount_level']==1 && $subarray['discount_type']==2 ? 'Rs.' : ''),
                            'discount' => !empty($subarray['discount']) && $subarray['discount_type']==1 ? number_format($subarray['rate'] * $subarray['discount'] / 100 ,2) : (!empty($subarray['discount']) && $subarray['discount_type']==2 ? $subarray['discount'] : ''),
                            'payment_method' => $payment_method['method_name'],
                            'status' => $main_invoice['status']==1?'Pending':($main_invoice['status']==2?'Paid':'Voided'),
                            'total_amount' => number_format($subarray['amount'] + $main_tax,2),
                        ),
                        function ($key) use ($fields_key_array) {
                                return in_array($key, $fields_key_array);
                            }, ARRAY_FILTER_USE_KEY));
                        fputcsv($file, $data);
                    }

                    // All Totals
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
                        'rate' => '',
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
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => $total_discount>0 ? number_format($total_discount,2) :'',
                        'payment_method' => '',
                        'status' => '',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Blank Line
                    $data = [];
                    fputcsv($file, $data);

                    //Main Final Total Label
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
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => '',
                        'payment_method' => 'Transaction Level Discount',
                        'status' => 'Total Shipping Charge',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Main Final Total
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
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => '',
                        'payment_method' => $main_discount,
                        'status' => $main_shipping_charge,
                        'total_amount' => number_format($total_after_tax - $main_discount + $main_shipping_charge,2),
                    ),
                    function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    fclose($file);
                };

                return Response::stream($callback, 200, $this->common_controller->Headers('credit_note'));
            }else{
                return view('globals.report_builder.index',$data);
            }
        }else{
            return view('globals.report_builder.index',$data);
        }
    }

    public function bill_report(Request $request){
        $data['menu'] = 'Bill Report';
        $data['sub_menu'] = 'BILL';
        $data['url'] = 'bill-report';
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
            $bill = Bills::whereBetween('bill_date',[$start_date, $end_date])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->pluck('id');

            if($bill->count()>0){
                $billItem = BillItems::whereIn('bill_id',$bill)->get();
                foreach ($billItem as $list){
                    $main_type = Bills::where('id',$list['bill_id'])->first();
                    if($main_type['status'] != 3){
                        $all_taxes = $this->common_controller->AllTaxes(4,$list['bill_id'],$list['tax_id'], $list['amount']);
                        $cgst = $cgst + $all_taxes[0];
                        $sgst = $sgst + $all_taxes[1];
                        $igst = $igst + $all_taxes[2];
                        $cess = $cess + $all_taxes[3];
                    }
                }
                $total_amount = Bills::whereIn('id',$bill)->where('status','!=',3)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('total');
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
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            return view('globals.report_builder.index',$data);
        }elseif(isset($request['export']) && !empty($request['export'])){
            if(isset($request['start_date']) && isset($request['end_date'])){
                if(empty($request['start_date']) && empty($request['end_date'])){
                    \Session::flash('error-message', 'Please select start date & end date');
                    return redirect()->back();
                }
            }

            if(isset($bill) && !empty($bill)){
                $fields_key_array = array('bill_no', 'bill_date', 'due_date', 'gstin', 'customer_full_name', 'customer_phone', 'customer_address', 'customer_gstin', 'product', 'hsn_code', 'quantity', 'rate', 'tax_type', 'amount_before_tax', 'amount_after_tax', 'sgst_%', 'cgst_%', 'igst_%', 'cess_%', 'sgst', 'cgst', 'igst', 'cess', 'total_tax', 'discount_level', 'discount_type', 'discount', 'payment_method', 'status', 'total_amount');
                $fields_value_array = array('Bill_Number', 'Bill_Date', 'Due_date', 'Gstin', 'Customer_Full_Name', 'Customer_Phone', 'Customer_Address', 'Customer_Gstin', 'Product', 'HSN_Code', 'Quantity', 'Rate', 'Tax_Type', 'Amount_Before_tax', 'Amount_After_Tax', 'SGST_%', 'CGST_%', 'IGST_%', 'CESS_%', 'SGST', 'CGST', 'IGST', 'CESS', 'Total_Tax', 'Discount_Level', 'Discount_Type', 'Discount', 'Payment_Method', 'Status', 'Total_Amount');
                $columns = $fields_value_array;
                $main_array = BillItems::whereIn('bill_id',$bill)->get();
                $total_before_tax = 0;
                $total_after_tax = 0;
                $total_discount = 0;
                $total_sgst = 0;
                $total_cgst = 0;
                $total_igst = 0;
                $total_cess = 0;
                $total_main_tax = 0;

                $callback = function() use ($bill, $main_array, $columns, $fields_key_array, $total_before_tax, $total_after_tax, $total_sgst, $total_cgst, $total_igst, $total_cess, $total_main_tax, $total_discount)
                {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);

                    $main_discount = Bills::whereIn('id',$bill)->where('status','!=',3)->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->sum('discount');

                    //All InvoiceItems List
                    foreach($main_array as $subarray) {
                        $sgst1 = 0;
                        $cgst1 = 0;
                        $igst1 = 0;
                        $cess1 = 0;
                        $product = Product::where('id',$subarray['product_id'])->first();
                        $main_bill = Bills::where('id',$subarray['bill_id'])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->first();
                        $payment_method = PaymentMethod::where('id',$main_bill['payment_method'])->first();
                        $pay_user = $this->common_controller->PayUser($main_bill['payee_id']);
                        $company = CompanySettings::where('id',$this->Company())->first();

                        //Tax calculation
                        $tax_data = $this->common_controller->TaxCount($subarray['tax_id'],$subarray['amount'],$main_bill['tax_type'],$main_bill['status'],$total_sgst,$total_cgst, $total_igst,$total_cess,$total_main_tax,$total_before_tax,$total_after_tax);

                        $main_tax = $tax_data[0] + $tax_data[1] + $tax_data[2] + $tax_data[3];
                        $amount = $main_bill['tax_type']==2 ? $subarray['amount'] : ($main_bill['tax_type'] == 1 ? $subarray['amount'] + $main_tax : $subarray['amount']);
                        if($main_bill['status'] != 3){
                            $total_sgst = $total_sgst + $tax_data[0];
                            $total_cgst = $total_cgst + $tax_data[1];
                            $total_igst = $total_igst + $tax_data[2];
                            $total_cess = $total_cess + $tax_data[3];
                            $total_main_tax = $total_main_tax + $main_tax;
                            $total_before_tax = $main_bill['tax_type']==2 ? $total_before_tax + $tax_data[4] : ($main_bill['tax_type'] == 1 ? $total_before_tax + $subarray['amount'] : $total_before_tax + $subarray['amount']);
                            $total_after_tax = $total_after_tax + $amount;
                        }

                        if($subarray['discount_type']==1){
                            $dis = !empty($subarray['discount']) ? $subarray['rate'] * $subarray['discount'] / 100 :0;
                        }else{
                            $dis = !empty($subarray['discount']) ? $subarray['discount'] : 0;
                        }
                        $total_discount = $total_discount + $dis;

                        $data = array_merge(array_flip($fields_key_array), array_filter(array(
                            'bill_no' => $main_bill['bill_no'],
                            'bill_date' => date('d-m-Y', strtotime($main_bill['bill_date'])),
                            'due_date' => date('d-m-Y', strtotime($main_bill['due_date'])),
                            'gstin' => $company['gstin'],
                            'customer_full_name' => $pay_user['first_name'].' '.$pay_user['last_name'],
                            'customer_phone' => $pay_user['mobile'],
                            'customer_address' => $pay_user['billing_street'].', '.$pay_user['billing_city'].'-'.$pay_user['billing_pincode'].', '.$pay_user['state'].', '.$pay_user['billing_country'],
                            'customer_gstin' => $pay_user['gstin'],
                            'product' => $product['title'],
                            'hsn_code' => $subarray['hsn_code'],
                            'quantity' => $subarray['quantity'],
                            'rate' => $subarray['rate'],
                            'tax_type' => $main_bill['tax_type']==1 ? 'Exclusive' : ($main_bill['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                            'amount_before_tax' => $main_bill['tax_type']==2 ? number_format($tax_data[4],2) : number_format($subarray['amount'],2),
                            'amount_after_tax' => $main_bill['tax_type']==1 ? number_format($subarray['amount'] + $main_tax,2) : number_format($subarray['amount'],2),
                            'sgst_%' => in_array($main_bill['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'cgst_%' => in_array($main_bill['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                            'igst_%' => in_array($main_bill['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'igst'?$tax_data[5]['rate']:0,
                            'cess_%' => in_array($main_bill['tax_type'], [1,2]) && $tax_data[5]['is_cess'] == 1 ? $tax_data[5]['cess']:0,
                            'sgst' => number_format($tax_data[0],2),
                            'cgst' => number_format($tax_data[1],2),
                            'igst' => number_format($tax_data[2],2),
                            'cess' => number_format($tax_data[3],2),
                            'total_tax' => number_format($main_tax,2),
                            'discount_level' => $main_bill['discount_level']==0 ? 'Transaction Level' : 'Item Level',
                            'discount_type' => $main_bill['discount_level']==1 && $subarray['discount_type']==1  ? $subarray['discount'].' %' : ($main_bill['discount_level']==1 && $subarray['discount_type']==2 ? 'Rs.' : ''),
                            'discount' => !empty($subarray['discount']) && $subarray['discount_type']==1 ? number_format($subarray['rate'] * $subarray['discount'] / 100 ,2) : (!empty($subarray['discount']) && $subarray['discount_type']==2 ? $subarray['discount'] : ''),
                            'payment_method' => $payment_method['method_name'],
                            'status' => $main_bill['status']==1?'Open':($main_bill['status']==2?'Paid': ($main_bill['status']==3?'Void':'Overdue')),
                            'total_amount' => number_format($subarray['amount'] + $main_tax,2),
                        ),
                        function ($key) use ($fields_key_array) {
                            return in_array($key, $fields_key_array);
                        }, ARRAY_FILTER_USE_KEY));
                        fputcsv($file, $data);

                        if($main_bill['status'] == 3){
                            $data = array_merge(array_flip($fields_key_array), array_filter(array(
                                'bill_no' => $main_bill['bill_no'],
                                'bill_date' => date('d-m-Y', strtotime($main_bill['bill_date'])),
                                'due_date' => date('d-m-Y', strtotime($main_bill['due_date'])),
                                'gstin' => $company['gstin'],
                                'customer_full_name' => $pay_user['first_name'].' '.$pay_user['last_name'],
                                'customer_phone' => $pay_user['mobile'],
                                'customer_address' => $pay_user['billing_street'].', '.$pay_user['billing_city'].'-'.$pay_user['billing_pincode'].', '.$pay_user['state'].', '.$pay_user['billing_country'],
                                'customer_gstin' => $pay_user['gstin'],
                                'product' => $product['title'],
                                'hsn_code' => $subarray['hsn_code'],
                                'quantity' => $subarray['quantity'],
                                'rate' => $subarray['rate'],
                                'tax_type' => $main_bill['tax_type']==1 ? 'Exclusive' : ($main_bill['tax_type']==2 ? 'Inclusive' : 'Out of scope'),
                                'amount_before_tax' => $main_bill['tax_type']==2 ? '-'.number_format($tax_data[4],2) : '-'.number_format($subarray['amount'],2),
                                'amount_after_tax' => $main_bill['tax_type']==1 ? '-'.number_format($subarray['amount'] + $main_tax,2) : '-'.number_format($subarray['amount'],2),
                                'sgst_%' => in_array($main_bill['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                                'cgst_%' => in_array($main_bill['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'gst'?$tax_data[5]['rate'] / 2:0,
                                'igst_%' => in_array($main_bill['tax_type'], [1,2]) && strtolower($tax_data[5]['tax_name']) == 'igst'?$tax_data[5]['rate']:0,
                                'cess_%' => in_array($main_bill['tax_type'], [1,2]) && $tax_data[5]['is_cess'] == 1 ? $tax_data[5]['cess']:0,
                                    'sgst' => '-'.number_format($tax_data[0],2),
                                'cgst' => '-'.number_format($tax_data[1],2),
                                'igst' => '-'.number_format($tax_data[2],2),
                                'cess' => '-'.number_format($tax_data[3],2),
                                'total_tax' => '-'.number_format($main_tax,2),
                                'discount_level' => $main_bill['discount_level']==0 ? 'Transaction Level' : 'Item Level',
                                'discount_type' => $main_bill['discount_level']==1 && $subarray['discount_type']==1  ? $subarray['discount'].' %' : ($main_bill['discount_level']==1 && $subarray['discount_type']==2 ? 'Rs.' : ''),
                                'discount' => !empty($subarray['discount']) && $subarray['discount_type']==1 ? number_format($subarray['rate'] * $subarray['discount'] / 100 ,2) : (!empty($subarray['discount']) && $subarray['discount_type']==2 ? $subarray['discount'] : ''),
                                'payment_method' => $payment_method['method_name'],
                                'status' => $main_bill['status']==1?'Open':($main_bill['status']==2?'Paid': ($main_bill['status']==3?'Void':'Overdue')),
                                'total_amount' => '-'.number_format($subarray['amount'] + $main_tax,2),
                            ),
                            function ($key) use ($fields_key_array) {
                                    return in_array($key, $fields_key_array);
                                }, ARRAY_FILTER_USE_KEY));
                            fputcsv($file, $data);
                        }
                    }

                    // All Totals
                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'bill_no' => '',
                        'bill_date' => '',
                        'due_date' => '',
                        'gstin' => '',
                        'customer_full_name' => '',
                        'customer_phone' => '',
                        'customer_address' => '',
                        'customer_gstin' => '',
                        'product' => '',
                        'hsn_code' => '',
                        'quantity' => '',
                        'rate' => '',
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
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => $total_discount>0 ? number_format($total_discount,2) :'',
                        'payment_method' => '',
                        'status' => '',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Blank Line
                    $data = [];
                    fputcsv($file, $data);

                    //Main Final Total Label
                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'bill_no' => '',
                        'bill_date' => '',
                        'due_date' => '',
                        'gstin' => '',
                        'customer_full_name' => '',
                        'customer_phone' => '',
                        'customer_address' => '',
                        'customer_gstin' => '',
                        'product' => '',
                        'hsn_code' => '',
                        'quantity' => '',
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => '',
                        'payment_method' => 'Transaction Level Discount',
                        'status' => '',
                        'total_amount' => '',
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);

                    // Main Final Total
                    $data = array_merge(array_flip($fields_key_array), array_filter(array(
                        'bill_no' => '',
                        'bill_date' => '',
                        'due_date' => '',
                        'gstin' => '',
                        'customer_full_name' => '',
                        'customer_phone' => '',
                        'customer_address' => '',
                        'customer_gstin' => '',
                        'product' => '',
                        'hsn_code' => '',
                        'quantity' => '',
                        'rate' => '',
                        'tax_type' => '',
                        'amount_before_tax' => '',
                        'amount_after_tax' => '',
                        'sgst_%' => '',
                        'cgst_%' => '',
                        'igst_%' => '',
                        'cess_%' => '',
                        'sgst' => '',
                        'cgst' => '',
                        'igst' => '',
                        'cess' => '',
                        'total_tax' => '',
                        'discount_level' => '',
                        'discount_type' => '',
                        'discount' => '',
                        'payment_method' => $main_discount,
                        'status' => '',
                        'total_amount' => number_format($total_after_tax - $main_discount,2),
                    ),
                    function ($key) use ($fields_key_array) {
                        return in_array($key, $fields_key_array);
                    }, ARRAY_FILTER_USE_KEY));
                    fputcsv($file, $data);
                    fclose($file);
                };
                return Response::stream($callback, 200, $this->common_controller->Headers('bill'));
            }else{
                return view('globals.report_builder.index',$data);
            }
        }else{
            return view('globals.report_builder.index',$data);
        }
    }
}