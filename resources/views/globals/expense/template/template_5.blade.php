<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Expense Voucher</title>
    <style>
        @font-face {
            font-weight: normal;
            font-style: normal;
        }
        table {
            border-collapse: collapse;
            border-color: #000;
        }
        .company-info td {
            border-top: solid 0px #{{$company->color}};
            border-bottom: solid 5px #{{$company->color}};
        }
        .company-info td td {
            border: 0px;
            padding: 0px;
        }
        @page {
            footer: myFooter1;
        }
    </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:10px; margin:30px 0; padding:0; font-weight:normal; line-height:16px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#fff; color:#212121; ">
    <tr>
        <td style="padding:10px 0px">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" style="padding:10px 0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        @if(isset($company->company_logo))
                                            <tr>
                                                <td align="left" style="padding-top:15px;">
                                                    <img src="{{url($company->company_logo)}}" alt="{{$company->company_name}}" width="auto" height="100" style="vertical-align:top;">
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td style="padding: 5px 0px;">
                                                <strong style="font-size: 12px; color:#{{$company->color}};">{{$company->company_name}}</strong>
                                            </td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                    </table>
                                </td>
                                <td width="436" align="right" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="30" align="right" valign="top" style="font-size:36px; text-transform: uppercase; color:#373b46; padding-top:15px;">
                                                Expense Voucher
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">
                                                <table cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="left" style="background-color:#{{$company->color}};">
                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td align="center" style="font-size:14px; padding:12px; color:#fff;">
                                                                        <strong>Payment Date&nbsp;&nbsp;</strong>{{date('d-m-Y', strtotime($expense['expense_date']))}}</td>
                                                                    <td align="center" style="font-size:18px; padding:12px 2px; color:#fff;">|</td>
                                                                    <td align="center" style="font-size:14px; padding:12px; color:#fff;">
                                                                        <strong>Ref No&nbsp;&nbsp;</strong>{{$expense['ref_no']}}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="padding:15px 0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0"
                               style="border-collapse:separate; background-color:#f2f2f2; padding:15px;">
                            <tbody>
                            <tr>
                                <td width="50%" align="right" valign="top" style="padding-right: 50px;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td align="left" valign="middle"
                                                style="font-size:18px; padding-right:20px; vertical-align: middle;">
                                                <strong>Billing Information</strong></td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                                    <tr>
                                                        <td align="right" style="font-size:13px; font-weight:bold; padding-bottom: 5px;">
                                                            {{$user['billing_name']}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" style="font-size:12px; padding-bottom: 5px;">
                                                            {{$user['billing_street']}}, {{$user['billing_city']}}-{{$user['billing_pincode']}}, {{$user['state']}}, {{$user['billing_country']}}.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" style="font-size:12px; padding-bottom: 5px;">Phone:
                                                            {{$user['billing_phone']}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="50%" align="right" valign="top">
                                    @if($user['is_shipping']==1 )
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="left" valign="middle"
                                                    style="font-size:18px; padding-right:20px; vertical-align: middle;">
                                                    <strong>Shipping Information</strong></td>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                                        <tr>
                                                            <td align="right" style="font-size:13px; font-weight:bold; padding-bottom: 5px;">
                                                                {{$user['shipping_name']}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="font-size:12px; padding-bottom: 5px;">
                                                                {{$user['shipping_street']}}, {{$user['shipping_city']}}-{{$user['shipping_pincode']}}, {{$user['shipping_state']}}, {{$user['shipping_country']}}.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="font-size:12px; padding-bottom: 5px;">Phone:
                                                                {{$user['shipping_phone']}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:15px 0px; font-size:13px;" valign="middle" align="left">
                        <strong>Payment Method: </strong>
                        {{$expense['PaymentMethod']['method_name']}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 15px; background-color:#f2f2f2;">
    <tr>
        <td width="38px" valign="middle" align="center" style="background-color:#{{$company->color}}; color: #fff; font-size:13px; font-weight:400; padding:12px 10px; border-left: solid 1px #b7b7b7;"><strong>#</strong></td>
        <td width="240px" valign="middle" align="center" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>Expense Type</strong></td>
        <td width="100px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>Note</strong></td>
        <td width="120px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="100px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        @if($expense['tax_type'] != 3)
            <td width="40px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>GST <br> <span style="font-family: DejaVu Sans; sans-serif;">(%)</span></strong></td>
        @endif
        @if($expense['tax_type'] != 3)
            @if($company['state_code'] == $user['billing_state_code'])
                <td width="80px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                <td width="80px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @else
                <td width="80px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>IGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @endif
            @if($expense['is_cess'] == 1)
                <td width="100px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
            @endif
        @endif
        <td width="100px" align="right" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px; border-right:1px solid #b7b7b7;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
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
                <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">{{$i}}</td>
                <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="left" valign="top">
                    @foreach($expense_types as $pro)
                        @if($pro['id'] == $item['expense_type_id']){{$pro['name']}}@endif
                    @endforeach
                </td>
                <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="quantity-input">{{$item['note']}}</span></td>
                <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="rate-input">{{number_format($item['rate'], 2)}}</span></td>
                <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="taxable-input">{{number_format($item['amount'], 2)}}</span></td>
                @if($expense['tax_type'] != 3)
                    <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">{{$item['tax_rate']}}</td>
                @endif
                @if($expense['tax_type'] != 3)
                    @if($company['state_code'] == $user['billing_state_code'])
                        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">{{number_format($total_tax/2,2)}}</td>
                        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">{{number_format($total_tax/2,2)}}</td>
                    @else
                        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">{{number_format($total_tax ,2)}}</td>
                    @endif
                    @if($expense['is_cess'] == 1)
                        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">@if($cess_tax != 0.00) ({{ $main_tax['cess']}}) @endif {{number_format($cess_tax ,2)}} </td>
                    @endif
                @endif
                <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="right" valign="top">
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
                <td style="display: none">
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

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#fff; color:#212121; margin-bottom: 15px;">
    <tr>
        <td align="left">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            {{-- <tr>
                              <td valign="top" height="20"
                                style="padding:8px 0; color: #b7b7b7; font-size:11px; color:#{{$company->color}}; margin:0;">
                                <strong>{{ $expense_label['total_amount_in_word'] }}</strong></td>
                            </tr>
                            <tr>
                              <td style="padding: 0px 0px 10px 0px; font-size:12px;">
                                One Hundred Thirty Eight Dollars and Eighty Cents Only
                              </td>
                            </tr> --}}
                            <tr>
                                <td align="left" valign="top" style="padding:8px 0; font-size:11px; color:#{{$company->color}};">
                                    <strong>Thank you for your business</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td align="right" valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Total Amount before Tax</strong>
                                </td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>{{number_format($expense['amount_before_tax'],2)}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Total Tax Amount </strong>
                                </td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>{{number_format($expense['tax_amount'],2)}}</strong>
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
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Total Amount After Tax</strong>
                                </td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>{{number_format($expense['total'],2)}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Round Off</strong></td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>
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
                                    </strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table align="center" width="100%" border="0" cellpadding="12" cellspacing="0">
    <tr bgcolor="#{{$company->color}}">
        <td height="30" align="right" style="font-size: 13px; color: #fff; padding-right:100px;">
            <strong>Total</strong>
        </td>
        <td width="100" height="30" align="right" style="font-size: 13px; color: #fff; padding-right: 10px; ">
            <strong>{{number_format(round($expense['total']),2)}}</strong>
        </td>
    </tr>
</table>

<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
    <tr>
        <td valign="top" height="28" style="font-weight:bold; font-size:11px;padding-top:8px;">
            Terms and Conditions
        </td>
    </tr>
    <tr>
        <td style="padding: 0px 0px 10px 0px; font-size:12px;">
            {{$company['terms_and_condition']}}
        </td>
    </tr>
</table>

<table class="company-info" align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff; margin: 10px 0px 20px;">
    <tbody>
    <tr>
        <td align="left" width="33%" style="padding:15px;" valign="middle">
            <table width="100%">
                <tr>
                    <td width="50" align="left">
                        <img src="{{url('assets/images/pdf_img/phone-icon-footer.png')}}" alt="" style="vertical-align: top; height:20px;" />
                    </td>
                    <td align="left" style="margin:0; font-size:13px; font-weight: 600; padding-top:5px; vertical-align: top;">
                        {{$company->company_phone}}
                    </td>
                </tr>
            </table>
        </td>
        <td align="left" width="33%" style="padding:15px;" valign="middle">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td width="25" align="left">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="background-color: #{{$company->color}};">
                                    <img src="{{url('assets/images/pdf_img/email-icon-footer.png')}}" width="20" height="20" alt="">
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td align="left" style="margin:0; font-size:13px; font-weight: 600; padding-top:0; vertical-align: top;">
                        {{$company->company_email}}
                    </td>
                </tr>
            </table>
        </td>
        <td align="left" width="33%" style="padding:15px;" valign="middle">
            <table width="100%">
                <tr>
                    <td width="25" align="left" valign="top">
                        <img src="{{url('assets/images/pdf_img/location-icon-footer.png')}}"alt="" style="vertical-align: top; height:20px; float:left" />
                    </td>
                    <td align="left" style="margin:0; font-size:13px; font-weight:600;  vertical-align: top;">
                        {{$company['street']}}, {{$company['city']}}-{{$company['pincode']}}, {{$company['state']}}, India
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #fff;">
    <tr>
        <td align="left">
            @if(in_array($expense['status'],[1,2,3,4]))
                <img src="{{$expense['status_image']}}" alt="" width="150" height="70" />
            @endif
        </td>
        <td height="72" valign="middle" align="right" valign="top" style="padding:10px 0; margin:0 10px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td width="43%" align="right" valign="top" style="padding-bottom: 10px;">
                        <strong>For, {{$company->company_name}}</strong>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        @if(isset($company->signature_image))
                            <img src="{{url($company['signature_image'])}}" alt="" width="auto" height="40"style="max-height:40px;" />&nbsp;&nbsp;&nbsp;
                        @else
                            <br>
                        @endif
                    </td>
                </tr>
                <tr><td style="text-align: right">Authorize Signature</td></tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>

</body>

</html>