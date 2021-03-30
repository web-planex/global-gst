<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Expense Voucher</title>
    <style>
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

<body style="font-family:Arial, Helvetica, sans-serif;font-size:16px; margin:0; padding:0; font-weight:normal;">
    <div>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="50%"></td>
                <td width="50%" style="border-top:solid 18px #{{$company->color}};"></td>
            </tr>
        </table>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#fff; color:#212121; ">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: -2px;">
                    <tr>
                        <td width="5%"></td>
                        <td width="20%">
                            @if(isset($company->company_logo))
                                <img src="{{url($company['company_logo'])}}" alt="" width="auto" height="100" style="vertical-align: middle; margin-bottom: 10px;">
                                <br />
                            @endif
                            <strong style="font-size: 12px; color:#{{$company->color}};">{{$company->company_name}}</strong>
                        </td>
                        <td width="46%" align="center" style="font-size:36px; text-transform: uppercase; color:#656565; vertical-align: middle">
                            Expense Voucher
                        </td>
                        <td width="24%" style="padding: 50px 0px 20px 40px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff; display: block;">
                                <tbody>
                                <tr>
                                    <td align="left" style="padding-bottom:10px; vertical-align: top; font-size:11px;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td bgcolor="#{{$company->color}}">
                                                    <img src="{{url('assets/images/pdf_img/phone-icon-white.png')}}" width="16px" height="16px" alt="" />
                                                </td>
                                                <td style="padding-left: 5px;">
                                                    {{$company->company_phone}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-bottom:10px; vertical-align: top; font-size:11px;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td bgcolor="#{{$company->color}}">
                                                    <img src="{{url('assets/images/pdf_img/mail-icon-white.png')}}" width="16px" height="16px" alt="" />
                                                </td>
                                                <td style="padding-left: 5px;">
                                                    {{$company->company_email}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: top; font-size:11px;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td valign="top">
                                                    <table cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td bgcolor="#{{$company->color}}">
                                                                <img src="{{url('assets/images/pdf_img/location-icon-white.png')}}" width="16px" height="16px" alt="" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="padding-left: 5px;">
                                                    {{$company['street']}}, {{$company['city']}}-{{$company['pincode']}}, {{$company['state']}}, India
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="5%" style="border-right:solid 18px #{{$company->color}};"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="5%"></td>
                        <td align="left" style="border-bottom: solid 5px #{{$company->color}}; padding:0 10px;"></td>
                        <td width="5%"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" style="padding:35px 15px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:separate; background-color:#fff;">
                    <tbody>
                    <tr>
                        <td width="5%"></td>
                        <td width="30%" align="left" valign="top" style="padding-right: 30px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                            <tr>
                                                <td align="left" valign="middle" style="font-size:14px; padding:4px 0px;">Billing Information</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" style="font-size:14px; font-weight:bold; padding-bottom: 5px;">
                                                    {{$user['billing_name']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="line-height: 20px;font-size:14px; padding-bottom: 5px;">
                                                    {{$user['billing_street']}}, {{$user['billing_city']}}-{{$user['billing_pincode']}}, {{$user['state']}}, {{$user['billing_country']}}.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom: 5px;"><strong>Phone: </strong>
                                                    {{$user['billing_phone']}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="30%" align="left" valign="top" style="padding-right: 30px;">
                            @if($user['is_shipping']==1 && $print_type==1)
                                <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                            <tr>
                                                <td align="left" valign="middle" style="font-size:14px; padding:4px 0px;">Shipping Information</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" style="font-size:14px; font-weight:bold; padding-bottom: 5px;">
                                                    {{$user['shipping_name']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="line-height: 20px;font-size:14px; padding-bottom: 5px;">
                                                    {{$user['shipping_street']}}, {{$user['shipping_city']}}-{{$user['shipping_pincode']}}, {{$user['shipping_state']}}, {{$user['shipping_country']}}.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom: 5px;"><strong>Phone:</strong>
                                                    {{$user['shipping_phone']}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            @endif
                        </td>
                        <td width="30%" align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom: 5px;">
                                                    <strong style="color:#{{$company->color}};">Ref. No: </strong>{{$expense['ref_no']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="60" align="left" valign="top" style="font-size:14px; padding-bottom:20px;">
                                                    <strong style="color:#{{$company->color}};">Payment Date: </strong>
                                                    {{date('d-m-Y', strtotime($expense['expense_date']))}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom:5px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom:5px;">
                                                    <strong>Payment Method:</strong>
                                                    {{$expense['PaymentMethod']['method_name']}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="5%"></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 5%">&nbsp;</td>
            <td width="38px" valign="top" align="center" bgcolor="#{{$company->color}}" style="color: #ffffff; padding:0 5px;line-height:30px;"><strong>#</strong></td>
            <td width="240px" valign="top" align="center" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Expense Type</strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Note</strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            @if($expense['tax_type'] != 3)
                <td width="40px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>GST <br> (%)</strong></td>
            @endif
            @if($expense['tax_type'] != 3)
                @if($company['state_code'] == $user['billing_state_code'])
                    <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                    <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                @else
                    <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>IGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                @endif
                @if($expense['is_cess'] == 1)
                    <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
                @endif
            @endif
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td style="width: 5%">&nbsp;</td>
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
                <tr style="background-color: @if($i%2 == 0) #e8e8e8 @else #f1f1f1 @endif">
                    <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">{{$i}}</td>
                    <td style="padding:0 5px;line-height:30px; border: solid 2px #fff;" align="left" valign="top">
                        @foreach($expense_types as $pro)
                            @if($pro['id'] == $item['expense_type_id']){{$pro['name']}}@endif
                        @endforeach
                    </td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">{{$item['note']}}</span></td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="rate-input">{{number_format($item['amount'], 2)}}</span></td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">
                        <span class="taxable-input">
                            @if($expense['tax_type'] == 1)
                                {{number_format($item['amount'], 2)}}
                            @elseif($expense['tax_type'] == 2)
                                {{number_format($item['amount'], 2)}}
                            @else
                                {{number_format($item['amount'], 2)}}
                            @endif
                        </span>
                    </td>
                    @if($expense['tax_type'] != 3)
                        <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">{{$item['tax_rate']}}</td>
                    @endif
                    @if($expense['tax_type'] != 3)
                        @if($company['state_code'] == $user['billing_state_code'])
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">{{number_format($total_tax/2,2)}}</td>
                        @else
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">{{number_format($total_tax ,2)}}</td>
                        @endif
                        @if($expense['is_cess'] == 1)
                            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">@if($cess_tax != 0.00) ({{ $main_tax['cess']}}) @endif {{number_format($cess_tax ,2)}} </td>
                        @endif
                    @endif
                    <td style="line-height:30px; border: solid 2px #fff;" align="right" valign="top">
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
                    <td style="display:none; border: solid 2px #fff;">
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

            @for($j=1; $j<=($expense['ExpenseItems']->count()>0?10-$expense['ExpenseItems']->count():10); $j++)
                <tr style="background-color: @if($j%2 == 0) #e8e8e8 @else #f1f1f1 @endif">
                    <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"> &nbsp; </td>
                    <td style="padding:0 5px; border: solid 2px #fff; line-height:30px;" align="left" valign="top"> &nbsp; </td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"> &nbsp; </td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="quantity-input"> &nbsp; </span></td>
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="rate-input"> &nbsp; </span></td>
                    @if($expense['discount_level']==1)
                        <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="discount-input"> &nbsp; </span></td>
                    @endif
                    <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>
                    @if($expense['tax_type'] != 3)
                        @if($company['state_code'] == $user['billing_state_code'])
                            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>
                            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>
                        @else
                            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>
                        @endif
                        @if($expense['is_cess'] == 1)
                            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input"> &nbsp; </span></td>
                        @endif
                    @endif
                    <td style="line-height:30px; border: solid 2px #fff;" align="right" valign="top"><span class="amount-input"> &nbsp; </span></td>
                    <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
                </tr>
            @endfor
        @endif
    </table>
    <table width="1050" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#fff; color:#212121;">
        <tr>
            <td align="left" style="padding:0 0 15px 2px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="5%"></td>
                        <td align="left" valign="top" style="padding-right:16px; padding-top: 30px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td valign="top" height="28" style="font-weight:bold; font-size:11px; padding-top:8px; border-bottom: solid 1px #212121">
                                        Terms and Conditions
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0px; font-size:12px;">
                                        {{$company['terms_and_condition']}}
                                    </td>
                                </tr>
                                {{-- <tr>
                                  <td valign="top" height="20"
                                    style="padding:20px 0 8px;font-size:11px; color:#{{$company->color}}; margin:0;">
                                    <strong>{{ $expense_label['total_amount_in_word'] }}</strong></td>
                                </tr>
                                <tr>
                                  <td style="padding: 0px 0px 10px 0px; font-size:12px;">
                                    One Hundred Thirty Eight Dollars and Eighty Cents Only
                                  </td>
                                </tr> --}}

                                <tr>
                                    <td align="left" valign="top" style="padding:8px 0; font-size:11px; color:#{{$company->color}};">
                                        @if(in_array($expense['status'],[1,2,4]))
                                            <img src="{{$expense['status_image']}}" alt="" width="150" height="70" />
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td align="right" width="40%" align="left" valign="top">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tbody>
                                <tr class="odd">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Total Amount before Tax
                                    </td>
                                    <td height="35" width="110" align="right" style="border: solid 2px #fff; padding:0 10px;">
                                        {{number_format($expense['amount_before_tax'],2)}}
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Total Tax Amount
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">
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
                                <tr class="odd">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Total Amount After Tax
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">
                                        {{number_format($expense['total'],2)}}
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Round Off
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">
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
                                <tr bgcolor="#{{$company->color}}">
                                    <td height="38" align="right" style="font-size: 18px; color: #fff; padding-right:10px; border: solid 2px #fff;">
                                        <strong>Total</strong>
                                    </td>
                                    <td height="38" align="right" style="padding:6px 10px; font-size: 18px; color: #fff; border: solid 2px #fff;">
                                        <strong>{{number_format(round($expense['total']),2)}}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="5%"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table align="center" width="1100" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;">
        <tr>
            <td width="5%"></td>
            <td height="72" valign="middle" align="right" valign="top" style="padding:50px 10px 0 10px; margin-top:0; display: block;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                        <td width="43%" align="right" valign="top" style="padding-bottom:10px; font-size:16px;">
                            <strong>For, {{$company['company_name']}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <img src="{{url($company['signature_image'])}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size:16px;">Authorize Signature</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="5%"></td>
        </tr>
    </table>
</body>
</html>