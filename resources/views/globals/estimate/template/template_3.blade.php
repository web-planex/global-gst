<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Estimate</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }
        div.page-layout {
            height: 295.5mm;
            width: 209mm;
        }
        table {
            border-collapse: collapse;
            border-color: #000;
        }
        tr.even {
            background-color: #f1f1f1;
        }

        tr.odd {
            background-color: #e8e8e8;
        }
    </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; margin:0; padding:0; font-weight:normal; line-height:20px;">
<div style="background-color:#{{$company->color}};padding-top: 50px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0px; background-color:#{{$company->color}};">
        <tr>
            <td width="5%"></td>
            <td width="90%">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" style="padding:0px 0px 20px 0px; background-color:#{{$company->color}}; ">
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                            <tr>
                                                <td align="left">
                                                    @if(isset($company->company_logo))
                                                        <img src="{{url($company->company_logo)}}" width="auto" height="80" alt="{{$company->company_name}}" style="vertical-align:top; margin-bottom: 10px;" />
                                                        <br />
                                                    @endif
                                                    <strong style="font-size: 12px; color:#ffffff;">{{$company->company_name}}</strong>
                                                </td>
                                                <td align="left" width="23%"
                                                    style="padding:0 15px; vertical-align: top;">
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td>
                                                                <img src="{{url('assets/images/pdf_img/phone-receiver-white.png')}}" style="margin:0px;" alt="" width="16" height="16" />&nbsp;&nbsp;
                                                            </td>
                                                            <td style="margin:0; font-size:13px; color:#ffffff;">
                                                                {{$company->company_phone}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align="left" width="23%"
                                                    style=" vertical-align: top;">
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td><img src="{{url('assets/images/pdf_img/envelope-white.png')}}" style="margin:0px;" alt="" width="16" height="16" />&nbsp;&nbsp;</td>
                                                            <td style="margin:0; font-size:13px; color:#ffffff;">
                                                                {{$company->company_email}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align="left" width="24%"
                                                    style="padding:0 15px; vertical-align: top;">
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td valign="top">
                                                                <img src="{{url('assets/images/pdf_img/maps-white.png')}}" style="margin:0px;" alt="" width="16" height="16" />&nbsp;&nbsp;
                                                            </td>
                                                            <td align="left" style="margin:0; font-size:13px; color:#ffffff;">
                                                                {{$company['street']}}, {{$company['city']}}-{{$company['pincode']}}, {{$company['state']}}, India
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="36%">
                                                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                                                        <tr>
                                                            <td colspan="2" align="left" valign="middle" style="font-size:12px; padding-bottom:5px; color:#fff;">
                                                                Billing Information
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-size:15px; font-weight:bold; padding-bottom:5px; color:#fff;">
                                                                {{$user['billing_name']}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="left" valign="top" style="padding-bottom: 5px; color:#fff;">
                                                                {{$user['billing_street']}}, {{$user['billing_city']}}-{{$user['billing_pincode']}}, {{$user['state']}}, {{$user['billing_country']}}.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px; color:#fff;">
                                                                <strong>Phone:</strong> {{$user['billing_phone']}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="34%">
                                                    @if($user['is_shipping']==1 && $print_type==1)
                                                        <table cellpadding="0" cellspacing="0" style="width: 100%">
                                                            <tr>
                                                                <td colspan="2" align="left" valign="middle" style="font-size:12px; padding-bottom:5px; color:#fff;">
                                                                    Shipping Information
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-size:15px; font-weight:bold; padding-bottom:5px; color:#fff;">
                                                                    {{$user['shipping_name']}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" align="left" valign="top" style="padding-bottom: 5px; color:#fff;">
                                                                    {{$user['shipping_street']}}, {{$user['shipping_city']}}-{{$user['shipping_pincode']}}, {{$user['shipping_state']}}, {{$user['shipping_country']}}.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-bottom: 5px; color:#fff;">
                                                                    <strong>Phone:</strong> {{$user['shipping_phone']}}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </td>
                                                <td width="30%" align="right" style="vertical-align: top;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="right" valign="top" style="font-size:20px; text-transform: uppercase; padding:15px 0 15px 0; color:#ffffff;">
                                                                <strong>Debit note</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="padding-bottom:6px; color:#fff; vertical-align:top;">
                                                                <strong>Estimate Date:</strong>{{date('d-m-Y', strtotime($estimate['estimate_date']))}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="padding-bottom:6px; color:#fff; vertical-align:top;">
                                                                <strong>Estimate No:</strong> {{$estimate['estimate_number']}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="color:#fff; padding-bottom:6px; vertical-align:top;">
{{--                                                                <strong>Payment Method:</strong>{{$payment_method['method_name']}}--}}
                                                            </td>
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
                </table>
            </td>
            <td width="5%"></td>
        </tr>
    </table>
</div>
@php $total_quanity = 0; @endphp
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr style="background-color: #313131">
        <td style="width: 5%">&nbsp;</td>
        <td width="38px" valign="middle" align="center" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>#</strong></td>
        <td width="240px" valign="middle" align="left" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>ITEM - SKU</strong></td>
        <td width="50px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>Qty</strong></td>
        <td width="100px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        @if($estimate['discount_level']==1)
            <td width="100px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>DISCOUNT ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        @endif
        <td width="100px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="50px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>HSN</strong></td>
        @if($estimate['tax_type'] != 3)
            <td width="40px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>GST <br> <span style="font-family: DejaVu Sans; sans-serif;">(%)</span></strong></td>
        @endif
        @if($estimate['tax_type'] != 3)
            @if($company['state_code'] == $user['billing_state_code'])
                <td width="80px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                <td width="80px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @else
                <td width="80px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>IGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @endif
            @if($estimate['is_cess'] == 1)
                <td width="100px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
            @endif
        @endif
        <td width="100px" align="right" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td style="width: 5%">&nbsp;</td>
    </tr>
    @if(!empty($estimate['EstimateItems']))
        @php
            $i=1;
            $maintotal = 0;
        @endphp
        @foreach($estimate['EstimateItems'] as $item)
            @php
                $total_quanity = $total_quanity + $item['quantity'];
                $main_tax = \App\Models\Globals\Taxes::where('id',$item['tax_id'])->first();
                if($estimate['tax_type']==1){
                     $total_tax = $item['amount'] * $item['tax_rate'] / 100;
                     $cess_tax = $main_tax['is_cess'] == 1 ? $item['amount'] * $main_tax['cess'] / 100 : 0.00;
                }elseif ($estimate['tax_type']==2){
                     $total_tax = $item['amount'] * $item['tax_rate'] / (100 + $item['tax_rate']);
                     $cess_tax = $main_tax['is_cess'] == 1 ? $item['amount'] * $main_tax['cess'] / (100 + $main_tax['cess']) : 0.00;
                }else{
                     $total_tax = 0;
                     $cess_tax = 0.00;
                }
                if($estimate['discount_level']==1){
                     $total_discount = $item['discount_type']==2 ? $item['discount'] : $item['rate'] * $item['discount'] / 100 ;
                }else{
                     $total_discount = 0;
                }
            @endphp
            <tr style="background-color: @if($i%2 == 0) #f1f1f1 @else #e8e8e8 @endif">
                <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
                <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">{{$i}}</td>
                <td style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff;" align="left" valign="top">{{$item['Product']['title']}} @if(!empty($item['Product']['sku'])) - {{$item['Product']['sku']}} @endif</td>
                <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">{{$item['quantity']}}</span></td>
                <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="rate-input">{{number_format($item['rate'], 2)}}</span></td>
                @if($estimate['discount_level']==1)
                    <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">
                        <span class="discount-input">
                            @if($item['discount_type']==2)
                                {{$item['discount']}}
                            @else
                                {{number_format($total_discount * $item['quantity'] ,2)}}
                            @endif
                        </span>
                    </td>
                @endif
                <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">
                    <span class="taxable-input">
                        @if($estimate['tax_type'] == 1)
                            {{number_format($item['amount'], 2)}}
                        @elseif($estimate['tax_type'] == 2)
                            {{number_format($item['amount'], 2)}}
                        @else
                            {{number_format($item['amount'], 2)}}
                        @endif
                    </span>
                </td>
                <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">{{$item['hsn_code']}}</td>
                @if($estimate['tax_type'] != 3)
                    <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">{{$item['tax_rate']}}</td>
                @endif
                @if($estimate['tax_type'] != 3)
                    @if($company['state_code'] == $user['billing_state_code'])
                        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                    @else
                        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">{{number_format($total_tax ,2)}}</td>
                    @endif
                    @if($estimate['is_cess'] == 1)
                        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">@if($cess_tax != 0.00) ({{ $main_tax['cess']}}) @endif {{number_format($cess_tax ,2)}} </td>
                    @endif
                @endif
                <td style="line-height:30px; border-bottom: solid 2px #fff;" align="right" valign="top">
                    <span class="amount-input">
                        @if($estimate['tax_type'] == 1)
                            {{number_format($item['amount'] + $total_tax + $cess_tax, 2)}} &nbsp;
                            @php $maintotal = $maintotal + $item['amount'] + $total_tax + $cess_tax @endphp
                        @elseif($estimate['tax_type'] == 2)
                            {{number_format($item['amount'], 2)}} &nbsp;
                            @php $maintotal = $maintotal + $item['amount'] @endphp
                        @else
                            {{number_format($item['amount'], 2)}} &nbsp;
                            @php $maintotal = $maintotal + $item['amount'] @endphp
                        @endif
                    </span>
                </td>
                <td style="display:none; border-bottom: solid 2px #fff;">
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
                <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            </tr>
            @php $i++; @endphp
        @endforeach
    @endif
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="padding:0 0 15px 0; margin:0px; background-color:#fff;">
    <tr>
        <td width="5%"></td>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
                <tr>
                    <td align="left" valign="top" style="padding-right: 30px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td valign="top" style="padding-top: 25px;">
                                    <div style="font-weight:bold; font-size:11px; color:#313131; text-transform: uppercase;">
                                        Terms and Conditions
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0px 20px 0px;">
                                    <div style="font-size:11px; line-height:16px;">
                                        {{$company['terms_and_condition']}}
                                    </div>
                                </td>
                            </tr>

                            {{-- <tr>
                                <td valign="top"
                                    style="font-size:11px; color:#313131; margin:0; text-transform: uppercase;">
                                    <strong>{{ $estimate_label['total_amount_in_word'] }}</strong></td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0px 20px 0;">
                                    <div style="font-size:11px;">One Hundred Thirty Eight Dollars and Eighty
                                        Cents Only</div>
                                </td>
                            </tr> --}}
{{--                            <tr>--}}
{{--                                <td align="left" valign="top" style="padding:8px 0; font-size:11px; color:#{{$company->color}};">--}}
{{--                                    @if(in_array($estimate['status'],[1,2,4]))--}}
{{--                                        <img src="{{$estimate['status_image']}}" alt="" width="150" height="70" />--}}
{{--                                    @endif--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                            </tbody>
                        </table>
                    </td>
                    <td width="40%" align="left" valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                                <tr class="odd">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Total Amount before Tax
                                    </td>
                                    <td height="35" width="110" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        {{number_format($estimate['amount_before_tax'],2)}}
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Total Tax Amount
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        {{number_format($estimate['tax_amount'],2)}}
                                    </td>
                                </tr>
                                @foreach($all_tax_labels as $tax)
                                    @php
                                        $arr = explode("_", $tax, 2);
                                        $rate = $arr[0];
                                        $tax_name = $arr[1];
                                    @endphp
                                @endforeach

                                <tr class="odd">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Discount &nbsp;&nbsp;
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        @if(!empty($estimate['discount_price'])){{$estimate['discount_price']}} @else - @endif
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Shipping Charge
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        {{$estimate['shipping_charge']==1 ? number_format($estimate['shipping_charge_amount'],2).'' : '-' }}
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Total Amount After Tax
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        {{number_format($estimate['total'],2)}}
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Round Off
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        @php
                                            $total_arr = explode('.',$estimate['total']);
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
                                <tr bgcolor="#{{$company->color}}">
                                    <td height="38" align="right" style="font-size: 18px; color: #fff; padding-right:10px; border-bottom: solid 2px #fff;">
                                        <strong>Total</strong>
                                    </td>
                                    <td height="38" align="right" style="padding:6px 10px; font-size: 18px; color: #fff; border-bottom: solid 2px #fff;">
                                        <strong>{{number_format(round($estimate['total']),2)}}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td width="5%"></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td style="padding-top: 50px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td width="43%" align="right" heigh="40" valign="top" style="padding-bottom: 5px;">
                        <strong>For, {{$company->company_name}}</strong></td>
                </tr>
                <tr>
                    <td align="right">
                        <img src="{{url($company['signature_image'])}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
                    </td>
                </tr>
                <tr>
                    <td align="right">Authorize Signature</td>
                </tr>
                </tbody>
            </table>
        </td>
        <td width="5%"></td>
    </tr>
</table>
</body>

</html>