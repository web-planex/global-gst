<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Expense Voucher</title>
    <style>
        table {
            border-collapse: collapse;
            border-color: #000;
        }
    </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:16px; margin:0; padding:0; font-weight:normal;">
    <div style="text-align: right; border-top:solid 18px #{{$company->color}};"></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#fff; color:#212121;">
    <tr>
        <td width="5%"></td>
        <td style="padding:30px 0px 20px 0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" style="padding:0px 10px 10px 10px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="40%" align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left" style="padding-top:0px;">
                                                @if(isset($company->company_logo))
                                                    <img src="{{url($company->company_logo)}}" alt="" width="auto"
                                                         height="auto" style="max-height:50px; margin-bottom: 10px;" />
                                                    <br />
                                                @endif
                                                <strong style="font-size: 12px; color:#{{$company->color}};">{{$company->company_name}}</strong>
                                            </td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr>
                                            <td align="left">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="48%" align="left" valign="top">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td colspan="2" align="left" valign="middle" style="font-size:10px; padding-bottom:5px;">Billing Information</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" style="font-size:13px; font-weight:bold; padding-bottom: 5px;">
                                                                        {{$user['billing_name']}}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="50" align="left" valign="top" style="padding-bottom: 5px; font-size:10px;"><strong>Address: </strong></td>
                                                                    <td style="font-size:10px; padding-bottom: 5px;">
                                                                        {{$user['billing_street']}}, {{$user['billing_city']}}-{{$user['billing_pincode']}}, {{$user['state']}}, {{$user['billing_country']}}.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-bottom: 5px; font-size:10px;"><strong>Phone:</strong></td>
                                                                    <td style="font-size:10px; padding-bottom: 5px;">{{$user['billing_phone']}}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="20%"></td>
                                <td width="40%" align="right" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="70" align="right" valign="top" style="font-size:18px; text-transform: uppercase; color:#4a4a4a; padding-top:0px;">
                                                <strong>Expense Voucher</strong>
                                                <table style="width:45px; margin:8px 0 0 0;">
                                                    <tr><td style="border-top:solid 3px #{{$company->color}};"></td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="50%" align="left" style="background-color:#{{$company->color}}; border: solid 1px #{{$company->color}};">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td style="font-size:14px; padding:10px 10px 0 10px; color:#fff;">Payment Date</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" style="font-size:14px; font-weight: normal; text-transform: uppercase; color:#383838; padding:5px 10px 10px 10px; color:#fff;">
                                                                        <strong>{{date('d-m-Y', strtotime($expense['expense_date']))}}</strong>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="50%" style="border: solid 1px #{{$company->color}};">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td align="left" style="font-size:14px; padding:10px 10px 0 10px;">Ref No.</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" style="font-size:14px; font-weight:normal; text-transform: uppercase; color:#383838; padding:5px 10px 10px 10px;">
                                                                        <strong>{{$expense['ref_no']}}</strong>
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
                </tr>
                <tr>
                    <td style="padding:10px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-top" style="border-collapse:separate;">
                            <tbody>
                                <tr>
                                    @if($user['is_shipping']==1 )
                                        <td width="40%" align="right" valign="top">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                <tr>
                                                    <td colspan="2" align="left" valign="middle" style="font-size:10px; padding-bottom:5px;">
                                                        Shipping Information
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="left" style="font-size:14px; font-weight:bold; padding-bottom: 5px;">
                                                        {{$user['shipping_name']}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" style="font-size:10px;padding-bottom: 5px;">
                                                        <strong>Address:</strong></td>
                                                    <td align="left" style="font-size:10px; padding-bottom: 5px;">
                                                        {{$user['shipping_street']}}, {{$user['shipping_city']}}-{{$user['shipping_pincode']}}, {{$user['shipping_state']}}, {{$user['shipping_country']}}.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-size:10px; padding-bottom: 5px;"><strong>Phone:</strong></td>
                                                    <td align="left" style="font-size:10px; padding-bottom: 5px;">{{$user['shipping_phone']}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="20%"></td>
                                    @endif
                                    <td width="40%" align="right" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
    {{--                                        <tr>--}}
    {{--                                            <td colspan="2" align="left" valign="middle" style="font-size:12px; font-weight:bold; padding-bottom: 5px;">{{ $expense_label["shipping_method"] }}</td>--}}
    {{--                                        </tr>--}}
    {{--                                        <tr>--}}
    {{--                                            <td colspan="2" align="left" style="font-size:11px; padding-bottom: 5px;">--}}
    {{--                                                First Class Package--}}
    {{--                                            </td>--}}
    {{--                                        </tr>--}}
                                            <tr>
                                                <td colspan="2" align="left" valign="middle" style="font-size:12px; font-weight:bold; padding-bottom: 5px;">Payment Method</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" style="font-size:11px; padding-bottom: 5px;">
                                                    {{$expense['PaymentMethod']['method_name']}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
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
</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="5%"></td>
            <td width="38px" valign="top" align="center" bgcolor="#{{$company->color}}" style="color: #ffffff; padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;"><strong>#</strong></td>
            <td width="240px" valign="top" align="center" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Expense Type</strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Note</strong></td>
            <td width="105px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @if($expense['tax_type'] != 3)
                <td width="40px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>GST <br> (%)</strong></td>
            @endif
            @if($expense['tax_type'] != 3)
                @if($company['state_code'] == $user['billing_state_code'])
                    <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                    <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                @else
                    <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>IGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                @endif
                @if($expense['is_cess'] == 1)
                    <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
                @endif
            @endif
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="5%"></td>
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
                    <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; background-color:#f1f1f1;" align="center" valign="top">{{$i}}</td>
                    <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; " align="left" valign="top">
                        @foreach($expense_types as $pro)
                            @if($pro['id'] == $item['expense_type_id']){{$pro['name']}}@endif
                        @endforeach
                    </td>
                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; background-color:#f1f1f1;" align="center" valign="top"><span class="quantity-input">{{$item['note']}}</span></td>
                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="rate-input">{{number_format($item['rate'], 2)}}</span></td>
                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; background-color:#f1f1f1; " align="center" valign="top"><span class="taxable-input">{{number_format($item['amount'], 2)}}</span></td>
                    @if($expense['tax_type'] != 3)
                        <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; background-color:#f1f1f1; " align="center" valign="top">{{$item['tax_rate']}}</td>
                    @endif
                    @if($expense['tax_type'] != 3)
                        @if($company['state_code'] == $user['billing_state_code'])
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;  text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; background-color:#f1f1f1; text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                        @else
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;  text-transform: uppercase;">{{number_format($total_tax ,2)}}</td>
                        @endif
                        @if($expense['is_cess'] == 1)
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; @if($company['state_code'] != $user['billing_state_code']) background-color:#f1f1f1; @endif text-transform: uppercase;">@if($cess_tax != 0.00) ({{ $main_tax['cess']}}) @endif {{number_format($cess_tax ,2)}} </td>
                        @endif
                    @endif
                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; @if($company['state_code'] == $user['billing_state_code']) background-color:#f1f1f1; @endif " align="right" valign="top">
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
                    <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
                </tr>
                @php $i++; @endphp
            @endforeach

{{--            @for($j=1; $j<=($expense['ExpenseItems']->count()>0?10-$expense['ExpenseItems']->count():10); $j++)--}}
{{--                <tr>--}}
{{--                    <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>--}}
{{--                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"> &nbsp; </td>--}}
{{--                    <td style="padding:0 5px;  line-height:30px; border-bottom: solid 1px #b7b7b7;" align="left" valign="top"> &nbsp; </td>--}}
{{--                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"> &nbsp; </td>--}}
{{--                    @if($expense['tax_type'] != 3)--}}
{{--                        <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"> &nbsp; </td>--}}
{{--                    @endif--}}
{{--                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="quantity-input"> &nbsp; </span></td>--}}
{{--                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="rate-input"> &nbsp; </span></td>--}}
{{--                    @if($expense['discount_level']==1)--}}
{{--                        <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="discount-input"> &nbsp; </span></td>--}}
{{--                    @endif--}}
{{--                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>--}}
{{--                    @if($expense['tax_type'] != 3)--}}
{{--                        @if($company['state_code'] == $user['billing_state_code'])--}}
{{--                            <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>--}}
{{--                            <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>--}}
{{--                        @else--}}
{{--                            <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>--}}
{{--                        @endif--}}
{{--                        @if($expense['is_cess'] == 1)--}}
{{--                            <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>--}}
{{--                        @endif--}}
{{--                    @endif--}}
{{--                    <td style="line-height:30px; border-bottom: solid 1px #b7b7b7; " align="right" valign="top"><span class="amount-input"> &nbsp; </span></td>--}}
{{--                    <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>--}}
{{--                </tr>--}}
{{--            @endfor--}}
        @endif
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#fff; color:#212121; ">
        <tr>
            <td width="5%"></td>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding:0 10px;">
                            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td align="left" valign="top" style="padding: 20px 0px 0px;">
                                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>

                                                <tr>
                                                    <td valign="top" height="28" style="padding-top: 8px;">
                                                        <p style="font-weight:bold; font-size:11px; color:#{{$company->color}};">
                                                            Terms and Conditions
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0px 0px 10px 0px;">
                                                        <p style="font-size:11px;">
                                                            {{$company['terms_and_condition']}}
                                                        </p>
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                  <td valign="top" height="20"
                                                    style="padding:8px 0;font-size:11px; color:#{{$company->color}}; margin:0;">
                                                    <strong>{{ $expense_label['total_amount_in_word'] }}</strong></td>
                                                </tr>
                                                <tr>
                                                  <td style="padding: 0px 0px 10px 0px;">
                                                    <p style="font-size:11px;">One Hundred Thirty Eight Dollars and Eighty Cents Only</p>
                                                  </td>
                                                </tr> --}}
                                                <tr>
                                                    <td align="left" valign="top" style="padding:8px 0; font-size:11px; color:#{{$company->color}};">
                                                        <strong>Thank you for your business</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="top" style="padding:8px 0; font-size:11px; color:#{{$company->color}};">
                                                        @if(in_array($expense['status'],[1,2,3,4]))
                                                            <img src="{{$expense['status_image']}}" alt="" width="150" height="70" />
                                                        @endif
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="35%" align="left" valign="top">
                                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px; padding-right:10px;">
                                                        <strong>Total Amount before Tax</strong>
                                                    </td>
                                                    <td height="24" width="110" align="right" style="font-size:12px;padding:0 0px;">
                                                        <strong>{{number_format($expense['amount_before_tax'],2)}}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Total Tax Amount</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
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
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Total Amount After Tax</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
                                                        <strong>{{number_format($expense['total'],2)}}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Round Off</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
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
                                                <tr bgcolor="#{{$company->color}}">
                                                    <td height="30" align="right" style="font-size: 14px; color: #fff; padding-right:10px;">
                                                        <strong>Total</strong>
                                                    </td>
                                                    <td height="30" align="right" style="font-size:14px;padding:12px 6px; color: #fff;">
                                                        <strong>{{number_format(round($expense['total']),2)}}</strong>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:50px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                                <tbody>
                                <tr>
                                    <td align="left" width="33%" style="padding:0 15px; vertical-align: top;">
                                        <table width="100%">
                                            <tr>
                                                <td height="42" valign="top" align="center">
                                                    <img src="{{url('assets/images/pdf_img/phone-icon-footer.png')}}" width="36" height="36" alt="" style="vertical-align: top;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p style="margin:0; font-size:13px; color:#69696b; padding-top:10px;">
                                                        {{$company->company_phone}}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="left" width="33%" style="padding:0 15px; vertical-align: top;">
                                        <table width="100%">
                                            <tr>
                                                <td height="42" valign="top" align="center">
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td style="background-color: #{{$company->color}};">
                                                                <img src="{{url('assets/images/pdf_img/email-icon-footer.png')}}" width="36" height="36" alt="">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p style="margin:0; font-size:13px; color:#69696b; padding-top:10px; vertical-align: top;">
                                                        {{$company->company_email}}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="left" width="33%" style="padding:0 15px; vertical-align: top;">
                                        <table width="100%">
                                            <tr>
                                                <td height="42" valign="top" align="center">
                                                    <img src="{{url('assets/images/pdf_img/location-icon-footer.png')}}" width="36" height="36" alt="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p style="margin:0; font-size:13px; color:#69696b; padding-top:10px;">
                                                        {{$company['street']}}, {{$company['city']}}-{{$company['pincode']}}, {{$company['state']}}, India
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="72" valign="middle" align="right" valign="top"
                            style="padding:40px 0 10px; margin-top:0;margin:0 10px;display: block;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td width="43%" align="right" heigh="40" valign="top" style="font-size:12px;padding-bottom: 5px;">
                                        <strong>For, {{$company['company_name']}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <img src="{{url($company['signature_image'])}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="font-size:12px;">Authorize Signature</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
        </tr>
    </table>
</body>

</html>