<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$menu}}</title>
    <style>
        table {
            border-collapse: collapse;
            border-color: #000;
        }
        @page {
            footer: myFooter1;
        }
    </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:16px; margin:0; padding:0; font-weight:normal; line-height:16px;">
@if($invoice['tax_type'] == 1)
    <input type="hidden" id="amounts_are" value="exclusive" />
@elseif($invoice['tax_type'] == 2)
    <input type="hidden" id="amounts_are" value="inclusive" />
@elseif($invoice['tax_type'] == 3)
    <input type="hidden" id="amounts_are" value="out_of_scope" />
@endif
<table width="1182" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom: 10px;">
    <tr>
        <td align="right"><img src="{{url($company['company_logo'])}}" alt="" width="90" /></td>
    </tr>
</table>
<table width="1182" border="0" cellspacing="0" cellpadding="0" align="center" >
    <tr>
        <td style="border:solid 2px #000;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" style="padding:0; line-height: 25px;" align="center">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" width="33%" style="font-size:18px; padding-top:5px; @if($menu == 'Credit Note') padding-bottom: 24px; @else padding-bottom: 6px; @endif padding-left:10px;">
                                    <strong>@if($menu != 'Credit Note') {{$invoice_type}}&nbsp;@endif</strong>
                                    @if($company['iec_code'] != '')
                                        <div><strong style="font-size:16px;">{{($company['iec_code'] != '') ? 'IEC CODE : '.$company['iec_code'] : '' }}</strong></div>
                                    @endif
                                    @if($company['cin_number'] != '')
                                        <div><strong style="font-size:16px;"> {{($company['cin_number'] != '') ? 'CIN : '.$company['cin_number'] : '' }}</strong></div>
                                    @endif
                                </td>
                                <td align="center"  style="font-size:20px; padding-top:5px;padding-bottom: 6px;padding-left:30px;">
                                    <strong>{{$company['company_name']}}</strong>
                                </td>
                                <td align="right" width="33%" style="font-size:17px; @if($menu == 'Credit Note') padding-top:5px; @else padding-top:0px; @endif padding-bottom: 25px; padding-right:10px;">
                                    <strong>GSTIN: {{$company['gstin']}}</strong>
                                    @if($company['fssai_lic_number'] != '')
                                        <div><strong> {{($company['fssai_lic_number'] != '') ? 'FSSAI LIC NO. : '.$company['fssai_lic_number'] : '' }}</strong></div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" width="15%" style="font-size:18px; padding-bottom: 3px;"></td>
                                <td align="center"   style="font-size:20px; padding-bottom: 3px;">
                                    {{$company['street']}}, {{$company['city']}}-{{$company['pincode']}}, {{$company['state']}}, India
                                </td>
                                <td align="right" width="15%" ></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right" style="padding-right:10px;"></td>
                            </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td  style="padding-top:5px;" width="33%" align="left">
                                    &nbsp;<img src="https://gst.webplanex.biz/images/mail-icon.png" alt="" width="12px" height="12px" />&nbsp;<strong >{{$company['company_email']}}</strong>
                                </td>
                                <td  align="center" style="padding-top:5px;padding-left:30px;">
                                    &nbsp;<img src="https://gst.webplanex.biz/images/web-icon.png" alt="" width="10px" height="12px"  />&nbsp;<strong>{{$company['website']}}</strong>
                                </td>
                                <td  style="padding-top:5px;" width="33%" align="right">
                                    &nbsp;<img src="https://gst.webplanex.biz/images/phone-icon.png" alt="" width="12px" height="12px"  />&nbsp;<strong>{{$company['company_phone']}}</strong>&nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td >
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 10px;">
                            <tr>
                                <td></td>
                            </tr>
                        </table>

                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" height="40" bgcolor="#bcd6ee" style="border-bottom: solid 2px #000;border-top: solid 2px #000;padding:0 5px; font-size:20px;"><strong>{{$menu}}</strong><br></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-top">
                            <tr>
                                <td width="295.5px" height="25" style="padding:0 5px;border-bottom: solid 1px #000;border-right: solid 1px #000;" >
                                    Invoice No. : <strong>{{$invoice['invoice_number']}}</strong>
                                </td>
                                <td width="285.5px" style="padding:0 5px;border-bottom: solid 1px #000;border-right: solid 1px #000;">Invoice Date :<strong> {{date('d-m-Y', strtotime($invoice['invoice_date']))}}</strong></td>
                                <td width="295.5px" style="padding:0 5px;border-bottom: solid 1px #000;border-right: solid 1px #000;">Transport Mode :<strong> -</strong></td>
                                <td width="305.5px" style="padding:0 5px;border-bottom: solid 1px #000;">Place of Supply :
                                    <strong>{{$company['city']}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td width="295.5px" height="25" style="padding:0 5px;border-bottom: solid 1px #000;border-right: solid 1px #000;">Order No : <strong>{{$invoice['order_number']}}</strong></td>
                                <td width="285.5px" style="padding:0 5px;border-bottom: solid 1px #000;border-right: solid 1px #000;">Order Date : <strong>{{date('d-m-Y', strtotime($invoice['invoice_date']))}}</strong></td>

                                <td width="295.5px" style="padding:0 5px;border-bottom: solid 1px #000;border-right: solid 1px #000;">Date of Supply : <strong>{{date('d-m-Y', strtotime($invoice['due_date']))}}</strong></td>
                                <td width="305.5px" style="padding:0 5px;border-bottom: solid 1px #000;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="68%" height="25" >State : <strong>{{$company['state']}}</strong></td>
                                            <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                                            <td width="16%" style="border-left: solid 1px #000;" align="center"><strong>{{$company['state_code']}}</strong></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="border-bottom:solid 2px #000; border-top:solid 1px #000;" height="40"></td></tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-top2">
                            <tr>
                                <td @if($print_type==2) colspan="2" @elseif($user['is_shipping']==0) colspan="2" @endif width="581px" bgcolor="#bcd6ee" height="25" align="center" style="padding:0 5px;border-bottom:solid 1px #000;border-right:solid 1px #000;" ><strong>BILL TO PARTY</strong></td>
                                @if($user['is_shipping']==1 && $print_type==1)
                                    <td width="601px"  bgcolor="#bcd6ee" align="center" style="padding:0 5px;border-bottom:solid 1px #000;"><strong>SHIP TO PARTY / DELIVERY ADDRESS</strong></td>
                                @endif
                            </tr>
                            <tr>
                                <td @if($print_type==2) colspan="2" @elseif($user['is_shipping']==0) colspan="2" @endif width="581px" height="25" style="padding:0 5px;border-bottom:solid 1px #000;border-right:solid 1px #000;;" ><strong>{{$user['billing_name']}}</strong></td>
                                @if($user['is_shipping']==1 && $print_type==1)
                                    <td width="601px" style="padding:0 5px;border-bottom:solid 1px #000;"><strong>{{$user['shipping_name']}}</strong></td>
                                @endif
                            </tr>
                            <tr>
                                <td @if($print_type==2) colspan="2" @elseif($user['is_shipping']==0) colspan="2" @endif width="581px" height="35" valign="middle" style="padding:0 5px;border-bottom:solid 1px #000;border-right:solid 1px #000;">{{$user['billing_street']}}, {{$user['billing_city']}}-{{$user['billing_pincode']}}, {{$user['state']}}, {{$user['billing_country']}}.</td>
                                @if($user['is_shipping']==1 && $print_type==1)
                                    <td width="601px" valign="middle"  style="padding:0 5px;border-bottom:solid 1px #000;">{{$user['shipping_street']}}, {{$user['shipping_city']}}-{{$user['shipping_pincode']}}, {{$user['shipping_state']}}, {{$user['shipping_country']}}.</td>
                                @endif
                            </tr>
                            <tr>
                                <td @if($print_type==2) colspan="2" @elseif($user['is_shipping']==0) colspan="2" @endif width="581px" height="25" style="padding:0 5px;border-bottom:solid 1px #000;border-right:solid 1px #000;"><strong>Phone No:</strong> {{$user['billing_phone']}}</td>
                                @if($user['is_shipping']==1 && $print_type==1)
                                    <td width="601px" style="padding:0 5px;border-bottom:solid 1px #000;"><strong>Phone No:</strong> {{$user['shipping_phone']}}</td>
                                @endif
                            </tr>
{{--                            <tr>--}}
{{--                                <td @if($print_type==2) colspan="2" @elseif($user['is_shipping']==0) colspan="2" @endif width="581px" height="25" style="padding:0 5px;border-bottom:solid 1px #000;border-right:solid 1px #000;"><strong>GSTIN:</strong> AUN1324656875538546</td>--}}
{{--                                @if($user['is_shipping']==1 && $print_type==1)--}}
{{--                                    <td width="581px" height="25" style="padding:0 5px;border-bottom:solid 1px #000;border-right:solid 1px #000;"><strong>GSTIN:</strong> AUN1324656875538546</td>--}}
{{--                                @endif--}}
{{--                            </tr>--}}
                            <tr>
                                <td @if($print_type==2) colspan="2" @elseif($user['is_shipping']==0) colspan="2" @endif width="581px" height="25" style="border-right: solid 1px #000;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="47%" height="25" style="padding:0 5px;"><strong>State:</strong> {{$user['state']}} </td>
                                            <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                                            <td width="12%" style="border-left: solid 1px #000;" align="center">{{$user['billing_state_code']}}</td>
                                            <td width="25%" style="border-left: solid 1px #000;padding:0 5px;" align="left"><strong>Country:</strong> {{$user['billing_country']}}</td>
                                        </tr>
                                    </table>
                                </td>
                                @if($user['is_shipping']==1 && $print_type==1)
                                    <td width="601px">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="47%" height="25" style="padding:0 5px;"><strong>State:</strong> {{$user['shipping_state']}} </td>
                                                <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                                                <td width="12%" style="border-left: solid 1px #000;" align="center">{{$user['shipping_state_code']}}</td>
                                                <td width="25%" style="border-left: solid 1px #000;padding:0 5px;" align="left"><strong>Country:</strong> {{$user['shipping_country']}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="border-top:solid 2px #000; border-bottom:solid 1px #000;" height="40"></td></tr>
            </table>
        </td>
    </tr>
</table>
@php $total_quanity = 0; @endphp
<table width="1182" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr align="center" bgcolor="#bcd6ee" style="padding:0;">
        <td width="38px" align="center"  rowspan="2" style="border-bottom: solid 1px #000;border-left: solid 2px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>S. No.</strong></td>
        <td width="312px" align="center" rowspan="2" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>Product Description - SKU </strong></td>
        <td width="40px" rowspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>HSN/SAC</strong></td>
        <td width="40px" rowspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>Qty</strong></td>
        <td width="100px" rowspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>Rate <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        @if($invoice['discount_level']==1)
            <td width="118px" rowspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>Discount <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        @endif
        <td width="100px" rowspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>Taxable Value <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
{{--        @if($invoice['tax_type'] != 3)--}}
{{--            <td width="80px" colspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000;border-bottom:solid 1px #000; padding: 0px 5px;"><strong>GST</strong></td>--}}
{{--        @endif--}}
        @if($invoice['tax_type'] != 3)
            @if($company['state_code'] == $user['billing_state_code'])
                <td width="100px" colspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>CGST</strong></td>
                <td width="100px" colspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>SGST</strong></td>
            @else
                <td width="100px" colspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>IGST</strong></td>
            @endif
            @if($invoice['is_cess'] == 1)
                <td width="130px" align="center" rowspan="2"  style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px;"><strong>CESS <br/>(%)</strong></td>
            @endif
        @endif
        <td width="120px" rowspan="2" align="center" style="border-bottom: solid 1px #000;border-right: solid 2px #000; padding: 0px 5px;"><strong>Total <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
    </tr>
    <tr align="center" bgcolor="#bcd6ee" style="padding:0;">
{{--        @if($invoice['tax_type'] != 3)--}}
{{--            <td width="40px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Rate</strong></td>--}}
{{--            <td width="40px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Amount</strong></td>--}}
{{--        @endif--}}
        @if($invoice['tax_type'] != 3)
            @if($company['state_code'] == $user['billing_state_code'])
                <td width="100px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Rate (%)</strong></td>
                <td width="120px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Amount <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                <td width="100px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Rate (%)</strong></td>
                <td width="120px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Amount <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @else
                <td width="100px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Rate (%)</strong></td>
                <td width="120px" align="center" style="border-bottom: solid 1px #000;border-right: solid 1px #000; padding: 0px 5px; background-color:#bcd6ee;"><strong>Amount <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @endif
        @endif
    </tr>
    @if(!empty($invoice['InvoiceItems']))
        @php
            $i=1;
            $maintotal = 0;
        @endphp
        @foreach($invoice['InvoiceItems'] as $item)
            @php
                $total_quanity = $total_quanity + $item['quantity'];
                $main_tax = \App\Models\Globals\Taxes::where('id',$item['tax_id'])->first();
                if($invoice['tax_type']==1){
                     $total_tax = $item['amount'] * $item['tax_rate'] / 100;
                     $cess_tax = $main_tax['is_cess'] == 1 ? $item['amount'] * $main_tax['cess'] / 100 : 0.00;
                }elseif ($invoice['tax_type']==2){
                     $total_tax = $item['amount'] * $item['tax_rate'] / (100 + $item['tax_rate']);
                     $cess_tax = $main_tax['is_cess'] == 1 ? $item['amount'] * $main_tax['cess'] / (100 + $main_tax['cess']) : 0.00;
                }else{
                     $total_tax = 0;
                     $cess_tax = 0.00;
                }
                if($invoice['discount_level']==1){
                     $total_discount = $item['discount_type']==2 ? $item['discount'] : $item['rate'] * $item['discount'] / 100 ;
                }else{
                     $total_discount = 0;
                }
            @endphp
            <tr align="center" style="padding:8px 0px; border-top: 1px solid #000;">
                <td width="38px" align="right" style="border-left: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;">{{$i}}</td>
                <td width="312px" align="left" style="border-right: solid 1px #000; padding: 5px 5px;">{{$item['Product']['title']}} @if(!empty($item['Product']['sku'])) - {{$item['Product']['sku']}} @endif</td>
                <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{$item['hsn_code']}}</td>
                <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{$item['quantity']}}</td>
                <td width="100px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{number_format($item['rate'], 2)}}</td>
                @if($invoice['discount_level']==1)
                    <td style="border-right: solid 1px #000; padding: 5px 5px;" align="right" valign="top">
                        @if($item['discount_type']==2)
                            {{$item['discount']}}
                        @else
                            {{number_format($total_discount * $item['quantity'] ,2)}}
                        @endif
                    </td>
                @endif
                <td width="100px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">
                    @if($invoice['tax_type'] == 1)
                        {{number_format($item['amount'], 2)}}
                    @elseif($invoice['tax_type'] == 2)
                        {{number_format($item['amount'], 2)}}
                    @else
                        {{number_format($item['amount'], 2)}}
                    @endif
                </td>
                @if($invoice['tax_type'] != 3)
                    @if($company['state_code'] == $user['billing_state_code'])
                        @php $tax_rate = $item['tax_rate']/2; @endphp
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{$tax_rate}}</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{number_format($total_tax/2,2)}}</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{$tax_rate}}</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{number_format($total_tax/2,2)}}</td>
                    @else
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{$item['tax_rate']}}</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">{{number_format($total_tax ,2)}}</td>
                    @endif
                    @if($invoice['is_cess'] == 1)
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">@if($cess_tax != 0.00) ({{ $main_tax['cess']}}) @endif {{number_format($cess_tax ,2)}} </td>
                    @endif
                @endif
                <td width="120px" align="right" style="border-right: solid 2px #000; padding: 0px 5px;">
                    @if($invoice['tax_type'] == 1)
                        {{number_format($item['amount'] + $total_tax + $cess_tax, 2)}}/-
                        @php $maintotal = $maintotal + $item['amount'] + $total_tax + $cess_tax @endphp
                    @elseif($invoice['tax_type'] == 2)
                        {{number_format($item['amount'], 2)}}/-
                        @php $maintotal = $maintotal + $item['amount'] @endphp
                    @else
                        {{number_format($item['amount'], 2)}}/-
                        @php $maintotal = $maintotal + $item['amount'] @endphp
                    @endif
                </td>
            </tr>
            @php $i++; @endphp
        @endforeach
        @for($i=1; $i<=($invoice['InvoiceItems']->count()>0?10-$invoice['InvoiceItems']->count():10); $i++)
            <tr>
                <td width="38px" align="right" style="border-left: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                <td width="322px" align="left" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                <td width="100px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                @if($invoice['discount_level']==1)
                    <td style="border-right: solid 1px #000; padding: 5px 5px;" align="right" valign="top"><span class="discount-input">&nbsp;</span></td>
                @endif
                <td width="100px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                @if($invoice['tax_type'] != 3)
                    @if($company['state_code'] == $user['billing_state_code'])
                        @php $tax_rate = $item['tax_rate']/2; @endphp
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                    @else
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                    @endif
                    @if($invoice['is_cess'] == 1)
                        <td width="40px" align="right" style="border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                    @endif
                @endif
                <td width="120px" align="right" style="border-right: solid 2px #000; padding: 0px 5px;">&nbsp;</td>
            </tr>
        @endfor
    @endif
    <tr align="center" style="padding:8px 0px;">
        <td width="38px" align="center" style="border-left: solid 2px #000;border-top: solid 2px #000;padding: 5px 5px;background-color:#bcd6ee;"></td>
        <td width="320px" align="center" style="border-top: solid 2px #000;padding: 5px 5px;background-color:#bcd6ee;"><strong>Total</strong></td>
        <td width="40px" align="center" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;background-color:#bcd6ee;"></td>
        <td width="40px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>{{$total_quanity}}</strong></td>
        <td width="120px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>&nbsp;</strong></td>
        @if($invoice['discount_level']==1)
            <td width="118px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>&nbsp;</strong></td>
        @endif
        <td width="140px"  align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>&nbsp;</strong></td>
        @if($invoice['tax_type'] != 3)
            @if($company['state_code'] == $user['billing_state_code'])
                <td width="40px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                <td width="40px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>&nbsp;</strong></td>
                <td width="40px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                <td width="40px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>&nbsp;</strong></td>
            @else
                <td width="40px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;">&nbsp;</td>
                <td width="40px"  align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>&nbsp;</strong></td>
            @endif
            @if($invoice['is_cess'] == 1)
                <td width="78px" align="right" style="border-top: solid 2px #000;border-right: solid 1px #000; padding: 5px 5px;"><strong>&nbsp;</strong></td>
            @endif
        @endif
        <td width="120px" align="right" style="border-top: solid 2px #000;border-right: solid 2px #000;padding: 5px 5px;"><strong>{{number_format($maintotal, 2)}}/-</strong></td>
    </tr>
</table>
<table align="center" width="1182"  border="0" cellspacing="0" cellpadding="0" style="border: solid 2px #000;">
    <tr>
        <td align="left" width="579px" valign="top" style="border-right: solid 1px #000;">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="40" align="center" style="border-bottom: solid 1px #000; padding: 5px 5px; background-color:#bcd6ee;"><strong>Total Invoice amount in words</strong></td>
                </tr>
                <tr>
                    <td height="107" align="center">{{ucwords($invoice['total_in_word'])}} Rupees Only</td>
                </tr>
                <tr>
                    <td align="left" style="border-top: solid 1px #000; padding:5px;"><strong>Payment Mode : </strong>{{$invoice['payment_method']}}</td>
                </tr>
                <tr>
                    <td align="left" style="border-top: solid 1px #000; padding:5px;"><strong>Terms &amp; Conditions</strong><br />
                        {{$company['terms_and_condition']}}
                    </td>
                </tr>
            </table>
        </td>

        <td width="599px" align="left" valign="top" >
            <table width="100%" border="0" cellspacing="0" cellpadding="2" style="margin-right: -1px; margin-bottom: -0.5px;">
                <tr>
                    <td  width="299.5px" align="left" height="35"  style="border-right:solid 1px #000;border-bottom:solid 1px #000;padding: 5px 5px;line-height:30px;"><strong>Total Amount before Tax <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                    <td  width="299.5px" align="right" height="35"  style="border-right:0px;border-bottom:solid 1px #000;padding: 5px 5px;line-height:30px;">{{number_format($invoice['amount_before_tax'],2)}}/-</td>
                </tr>
                <tr>
                    <td width="299.5px" align="left"  height="15"  style="border-right:solid 1px #000;border-bottom:solid 1px #000;padding:5px 5px;line-height:15px;"><strong>Total Tax Amount <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                    <td width="299.5px" align="right"  height="35"  style="border-right:0px;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;">{{number_format($invoice['tax_amount'],2)}}/-</td>
                </tr>
                @foreach($all_tax_labels as $tax)
                    @php
                        $arr = explode("_", $tax, 2);
                        $rate = $arr[0];
                        $tax_name = $arr[1];
                    @endphp
                @endforeach
                <tr>
                    <td width="299.5px" style="border-right:solid 1px #000;border-bottom:solid 1px #000;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; margin-top:-2px; margin-bottom: -2px;">
                            <tr>
                                <td align="left" width="60%" style="padding:5px 5px;line-height:30px;">
                                    <strong>Discount %</strong>
                                </td>
                                <td align="right" style="padding:5px 5px;line-height:30px;border-left:solid 1px #000;">@if($invoice['discount_type']==1) {{$invoice['discount']}} % @else - @endif</td>
                            </tr>
                        </table>
                    </td>
                    <td width="299.5px" style="border-bottom:solid 1px #000;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; margin-top:-2px; margin-bottom: -2px;">
                            <tr>
                                <td align="left" width="50%" style="padding:5px 5px;line-height:30px;">
                                    <strong>Discount <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong>
                                </td>
                                <td align="right"  style="width:100px;padding:5px 5px;line-height:30px;border-left:solid 1px #000;">@if(!empty($invoice['discount_price']) && $invoice['discount_price']>0) {{$invoice['discount_price']}}/- @endif</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="299.5px" align="left"  height="35"  style="border-right:solid 1px #000;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;">
                        <strong>Shipping Amount <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong>
                    </td>

                    <td width="299.5px" align="right"  style="border-right:0px;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;">
                        {{$invoice['shipping_charge']==1 ? number_format($invoice['shipping_charge_amount'],2).'/-' : '-' }}&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td width="299.5px" align="left"  height="35"  style="border-right:solid 1px #000;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;"><strong>Total Amount After Tax <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                    <td width="299.5px" align="right"  style="border-right:0px;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;">{{number_format($invoice['total'],2)}}/-</td>
                </tr>
                <tr>
                    <td width="299.5px" align="left"  height="35"  style="border-right:solid 1px #000;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;"><strong>Round Off</strong></td>
                    <td width="299.5px" align="right"  style="border-right:0px;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;">
                        @php
                            $total_arr = explode('.',$invoice['total']);
                            $j = '0.'.$total_arr[1];
                            $round = round($j);
                        @endphp

                        @if($round==1)
                            (+) {{1 - $j}}/-
                        @elseif($total_arr[1] == 00)
                            -
                        @else
                            (-) {{$j}}/-
                        @endif

                    </td>
                </tr>
                <tr>
                    <td width="299.5px" align="left"  height="35"  style="border-right:solid 1px #000;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px; text-transform: uppercase;"><strong>Total <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                    <td width="299.5px" align="right"  style="border-right:0px;border-bottom:solid 1px #000;padding:5px 5px;line-height:30px;"><strong>{{number_format(round($invoice['total']),2)}}/-</strong></td>
                </tr>
                <tr>
                    <td  align="left" style="padding: 3px 5px;border-top: solid 1px #000;">E. & O.E</td>
                    <td colspan="2" align="right" style="padding:3px 5px 5px;line-height:30px;">
                        <strong>For, {{$company['company_name']}}</strong>&nbsp;&nbsp;<br/>
                    </td>
                </tr>
                <tr>
                    <td width="199.5px" align="left" style=";line-height:30px;">
                        @if(in_array($invoice['status'],[1,2,4]))
                            <img src="{{url('assets/images/pdf_img/'.$invoice['status_image'])}}" alt="" width="150" height="70" />
                        @endif
                    </td>
                    <td width="399.5px" align="right" style="padding:0 5px 5px;line-height:30px;">
                        <img src="{{url($company['signature_image'])}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right" style="padding:0 5px 5px;line-height:30px;">
                        <strong>
                            Authorised Signature&nbsp;&nbsp;
                        </strong><br>
                        <!-- This is computer generated invoice and does not require a signature&nbsp;&nbsp; -->
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>