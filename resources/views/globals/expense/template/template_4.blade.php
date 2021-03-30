<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Expense Voucher</title>
    <style>
        table {
            border-collapse: collapse !important;
            color: #1d1d1d;
            font-size: 14px;
        }

        table.td-gray td {
            border: solid 1px #444444;
            font-size: 14px;
        }

        @page {
            footer: myFooter1;
            font-size: 14px;
        }
    </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; margin:0; padding:0; font-weight:normal;font-size: 14px;">
    <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" width="28%"
                                        style="border-top:solid 1px #444444;border-left:solid 1px #444444;line-height:40px; {{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">
                                        <h3 style="font-size: 20px !important;">&nbsp;&nbsp;Expense Voucher
                                        </h3>
                                    </td>
                                    <td align="center" width="44%" style="border-top:solid 1px #444444;line-height:40px; padding: 30px 0px 10px;">
                                        @if(isset($company->company_logo))
                                            <img src="{{url($company->company_logo)}}" alt="" width="auto" style="max-height:80px;" />
                                        @else
                                            &nbsp;&nbsp;
                                        @endif
                                    </td>
                                    <td width="28%"style="border-top:solid 1px #444444;border-right:solid 1px #444444;line-height:40px;">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border-left:solid 1px #444444;border-right:solid 1px #444444;line-height:25px; padding-bottom: 30px;"align="center">
                                        <strong style="{{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">{{$company->company_name}}</strong><br>
                                        {{$company['street']}}, {{$company['city']}}-{{$company['pincode']}}, {{$company['state']}}, India
                                        <div>
                                            <img src="{{url('assets/images/pdf_img/phone-icon.png')}}" alt="" width="15px" height="15px" />&nbsp;&nbsp;{{$company->company_phone}}&nbsp;&nbsp;
                                            <img src="{{url('assets/images/pdf_img/mail-icon.png')}}" alt="" width="15px" height="15px" />&nbsp;&nbsp;{{$company->company_email}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0" id="table-top">
                                <tr>
                                    <td align="left" width="50%"style="padding:5px 15px;border-left:solid 1px #444444;border-top:solid 1px #444444;">
                                        Ref No: <strong>{{$expense['ref_no']}}</strong>
                                    </td>
                                    <td align="left" width="50%" style="padding:5px 15px;border:solid 1px #444444;">
                                        <strong>Transport Mode: </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding:5px 15px;border-left:solid 1px #444444;border-top:solid 1px #444444;border-bottom:solid 1px #444444;">
                                        Payment Date: <strong>{{date('d-m-Y', strtotime($expense['expense_date']))}}</strong>
                                    </td>
                                    <td align="left" style="padding:5px 15px;border:solid 1px #444444;">
                                        <strong>Payment Method: </strong>{{$expense['PaymentMethod']['method_name']}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0" id="table-top2" width="100%">
                                <tr>
                                    <td align="center" colspan="2" style="border-left:solid 1px #444444; border-right:solid 1px #444444;padding:10px;line-height:30px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td @if($user['is_shipping']==0) colspan="2" @endif align="center" width="50%" style="border-left:solid 1px #444444;border-right:solid 1px #444444;border-top:solid 1px #444444; padding:0 5px;line-height:30px;">
                                        <strong style="color: #{{$company->color}}">Billing Information</strong>
                                    </td>
                                    @if($user['is_shipping']==1 && $print_type==1)
                                        <td align="center" width="50%" style="border-left:solid 1px #444444;border-top:solid 1px #444444; border-right:solid 1px #444444;padding:0 5px;line-height:30px;">
                                            <strong style="color: #{{$company->color}}">Shipping Information</strong>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td @if($user['is_shipping']==0) colspan="2" @endif align="left" style="border:solid 1px #444444;padding:0 5px;line-height:30px; font-weight: bold;">
                                        &nbsp;&nbsp;{{$user['billing_name']}}
                                    </td>
                                    @if($user['is_shipping']==1 && $print_type==1)
                                        <td align="left" style="border:solid 1px #444444;padding:0 5px;line-height:30px; font-weight: bold;">
                                            &nbsp;&nbsp;{{$user['shipping_name']}}
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td @if($user['is_shipping']==0) colspan="2" @endif align="left" valign="top" style="border:solid 1px #444444;padding:0 5px;line-height:30px;">
                                        &nbsp;&nbsp;{{$user['billing_street']}}, {{$user['billing_city']}}-{{$user['billing_pincode']}}, {{$user['state']}}, {{$user['billing_country']}}.
                                    </td>
                                    @if($user['is_shipping']==1 && $print_type==1)
                                        <td align="left" valign="top" style="border:solid 1px #444444;padding:0 5px;line-height:30px;">
                                            &nbsp;&nbsp;{{$user['shipping_street']}}, {{$user['shipping_city']}}-{{$user['shipping_pincode']}}, {{$user['shipping_state']}}, {{$user['shipping_country']}}.
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td @if($user['is_shipping']==0) colspan="2" @endif align="left" style="border:solid 1px #444444;border-bottom:0px; padding:0 5px;line-height:30px;">
                                        &nbsp;&nbsp;Phone:{{$user['billing_phone']}}
                                    </td>
                                    @if($user['is_shipping']==1 && $print_type==1)
                                        <td align="left"style="border:solid 1px #444444;border-bottom:0px; padding:0 5px;line-height:30px;">
                                            &nbsp;&nbsp;Phone:{{$user['shipping_phone']}}
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td align="center" colspan="2" style="border-top:solid 1px #444444;border-left:solid 1px #444444; border-right:solid 1px #444444;padding:10px;line-height:30px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="td-gray" border="1" cellspacing="0" cellpadding="0" bordercolor="#444444" width="100%">
                                <tr>
                                    <td width="38px" valign="middle" align="center" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">#</strong></td>
                                    <td width="240px" valign="middle" align="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">Expense Type</strong></td>
                                    <td width="100px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">Note</strong></td>
                                    <td width="120px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                    <td width="100px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                    @if($expense['tax_type'] != 3)
                                        <td width="40px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">GST <br> <span style="font-family: DejaVu Sans; sans-serif;">(%)</span></strong></td>
                                    @endif
                                    @if($expense['tax_type'] != 3)
                                        @if($company['state_code'] == $user['billing_state_code'])
                                            <td width="80px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                            <td width="80px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                        @else
                                            <td width="80px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">IGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                        @endif
                                        @if($expense['is_cess'] == 1)
                                            <td width="100px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
                                        @endif
                                    @endif
                                    <td width="100px" align="right" valign="middle" style="padding:5px 15px;">&nbsp;&nbsp;<strong style="color: #{{ $company->color }}">Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                </tr>
                                @if(!empty($expense['ExpenseItems']))
                                    @php
                                        $i=1;
                                        $maintotal = 0;
                                    @endphp
                                    @foreach($expense['ExpenseItems'] as $item)
                                        @php
                                            $main_tax = \App\Models\Globals\Taxes::where('id',$item['tax_id'])->first();
                                            if($expense['tax_type']==1){
                                                 $total_tax = $item['amount'] * $item['tax_rate'] / 100;
                                                 $cess_tax = $main_tax['is_cess'] == 1 ? $item['amount'] * $main_tax['cess'] / 100 : 0.00;
                                            }elseif ($expense['tax_type']==2){
                                                 $total_tax = $item['amount'] * $item['tax_rate'] / (100 + $item['tax_rate']);
                                                 $cess_tax = $main_tax['is_cess'] == 1 ? $item['amount'] * $main_tax['cess'] / (100 + $main_tax['cess']) : 0.00;
                                            }else{
                                                 $total_tax = 0;
                                                 $cess_tax = 0.00;
                                            }
                                            if($expense['discount_level']==1){
                                                 $total_discount = $item['discount_type']==2 ? $item['discount'] : $item['rate'] * $item['discount'] / 100 ;
                                            }else{
                                                 $total_discount = 0;
                                            }
                                        @endphp
                                        <tr>
                                            <td style="line-height:30px; " align="center" valign="top">{{$i}}</td>
                                            <td style="padding:0 5px;line-height:30px; " align="left" valign="top">
                                                @foreach($expense_types as $pro)
                                                    @if($pro['id'] == $item['expense_type_id']){{$pro['name']}}@endif
                                                @endforeach
                                            </td>
                                            <td style="line-height:30px; " align="center" valign="top"><span class="quantity-input">{{$item['note']}}</span></td>
                                            <td style="line-height:30px; " align="center" valign="top"><span class="rate-input">{{number_format($item['rate'], 2)}}</span></td>
                                            <td style="line-height:30px; " align="center" valign="top"><span class="taxable-input">{{number_format($item['amount'], 2)}}</span></td>
                                            @if($expense['tax_type'] != 3)
                                                <td style="line-height:30px; " align="center" valign="top">{{$item['tax_rate']}}</td>
                                            @endif
                                            @if($expense['tax_type'] != 3)
                                                @if($company['state_code'] == $user['billing_state_code'])
                                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                                                @else
                                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">{{number_format($total_tax ,2)}}</td>
                                                @endif
                                                @if($expense['is_cess'] == 1)
                                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">@if($cess_tax != 0.00) ({{ $main_tax['cess']}}) @endif {{number_format($cess_tax ,2)}} </td>
                                                @endif
                                            @endif
                                            <td style="line-height:30px; " align="right" valign="top">
                                                <span class="amount-input">
                                                    @if($expense['tax_type'] == 1)
                                                        {{number_format($item['amount'] + $total_tax + $cess_tax, 2)}} &nbsp;
                                                        @php $maintotal = $maintotal + $item['amount'] + $total_tax + $cess_tax @endphp
                                                    @elseif($expense['tax_type'] == 2)
                                                        {{number_format($item['amount'], 2)}} &nbsp;
                                                        @php $maintotal = $maintotal + $item['amount'] @endphp
                                                    @else
                                                        {{number_format($item['amount'], 2)}} &nbsp;
                                                        @php $maintotal = $maintotal + $item['amount'] @endphp
                                                    @endif
                                                </span>
                                            </td>
                                            <td style="display:none; ">
                                                <select id="taxes" class="tax-input">
                                                    @foreach($taxes as $tax)
                                                        @if($tax['is_cess'] == 0)
                                                            <option value="{{$tax['id']}}" @if(!empty($item['tax_id']) && $item['tax_id']==$tax['id'])) selected @endif>{{$tax['rate'].'% '.$tax['tax_name']}}</option>
                                                        @else
                                                            <option value="{{$tax['id']}}" @if(!empty($item['tax_id']) && $item['tax_id']==$tax['id'])) selected @endif>{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                @endif
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" align="left" valign="top"
                                        style="border-left:solid 1px #444444;border-right:solid 1px #444444; padding: 20px 0px;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td valign="top" style="padding: 10px;">
                                                    <strong>Terms and Conditions</strong><br />
                                                    <table style="margin-top: 5px;" cellpadding="0" cellspacing="0"
                                                           border="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                {{$company['terms_and_condition']}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td style="padding:10px;" valign="bottom">
                                                    <div style="font-weight: bold;">
                                                        {{ $expense_label['total_amount_in_word'] }}
                                                    </div>
                                                    <table width="560px" border="0" cellspacing="0" cellpadding="0"
                                                        align="left" style="margin-top: 5px;">
                                                        <tr>
                                                            <td>
                                                                Thirty Eight Dollars and Eighty Cents Only</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td valign="top" style="padding:10px;">
                                                    <strong>Thank you for your business</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="left" valign="top" width="40%" style="border-right:solid 1px #444444;border-bottom:solid 0px #444444;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;font-size: 14px;">
                                                    &nbsp;&nbsp;Total Amount before Tax</td>
                                                <td align="right" width="103.5" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    {{number_format($expense['amount_before_tax'],2)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;font-size: 14px;">
                                                    &nbsp;&nbsp;Total Tax Amount&nbsp;
                                                </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    {{number_format($expense['tax_amount'],2)}}
                                                </td>
                                            </tr>
                                            @foreach($all_tax_labels as $tax)
                                                @php
                                                    $arr = explode("_", $tax, 2);
                                                    $rate = $arr[0];
                                                    $tax_name = $arr[1];
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;">
                                                    &nbsp;&nbsp;Total Amount After Tax
                                                </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    {{number_format($expense['total'],2)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;">
                                                    &nbsp;&nbsp;Round Off
                                                </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    @php
                                                        $total_arr = explode('.',$expense['total']);
                                                        $j = '0.'.$total_arr[1];
                                                        $round = round($j);
                                                    @endphp

                                                    @if($round==1)
                                                        (+) {{1 - $j}}
                                                    @elseif($total_arr[1] == 00)
                                                        -
                                                    @else
                                                        (-) {{$j}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444; text-transform: uppercase; {{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">
                                                    &nbsp;&nbsp;<strong>Total</strong></td>
                                                <td align="right"
                                                    style="padding:5px;border-bottom:solid 1px #444444; {{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">
                                                    <strong>{{number_format(round($expense['total']),2)}}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <td align="left" style="border-top:solid 1px #444444;border-left:solid 1px #444444;border-bottom: solid 1px #444444;line-height:25px;">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @if(in_array($expense['status'],[1,2,4]))
                                            <img src="{{$expense['status_image']}}" alt="" width="150" height="70" />
                                        @endif
                                    </td>
                                    <td align="right"
                                        style="padding:30px 10px 20px;border-top:solid 1px #444444;border-bottom: solid 1px #444444;border-right:solid 1px #444444;line-height:25px;">
                                        <strong>For, {{$company->company_name}}</strong>&nbsp;&nbsp;<br />
                                        <img src="{{url($company['signature_image'])}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
                                        Authorize Signature&nbsp;&nbsp;
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>