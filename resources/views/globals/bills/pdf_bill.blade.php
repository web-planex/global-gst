<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bill</title>
    <style>
        table { border-collapse: collapse!important; border-color:#444444;}
        table.td-gray td {border:solid 1px #444444;	}
        td {
            color:#1d1d1d;
        }
        @page {
            footer: myFooter1;
        }
        .hide{display: none;}
    </style>
    <script src="{{ asset('assets/jquery/jquery-3.2.1.min.js') }}"></script>
</head>
<body style="font-family:Arial, Helvetica, sans-serif;font-size:16px; margin:0; padding:0; font-weight:normal;">
@if($bill['tax_type'] == 1)
    <input type="hidden" id="amounts_are" value="exclusive" />
@elseif($bill['tax_type'] == 2)
    <input type="hidden" id="amounts_are" value="inclusive" />
@elseif($bill['tax_type'] == 3)
    <input type="hidden" id="amounts_are" value="out_of_scope" />
@endif
    <table width="1182" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" valign="top" width="31%" style="border-top:solid 1px #444444;border-left:solid 1px #444444;font-size:22px; padding: 8px 0px 0px 5px;">
                <h2>&nbsp;Bill</h2>
                &nbsp;&nbsp;<strong style="font-size:16px;">GSTIN : {{$company['gstin']}}</strong>
            </td>
            <td align="center" valign="top" width="38%" style="border-top:solid 1px #444444; padding: 10px 0px 0px;">
                <img src="{{url($company['company_logo'])}}" alt="" width="100" height="100" style="max-height:100px;"/>
            </td>
            <td align="center" valign="top" width="38%" style="border-top:solid 1px #444444;border-right:solid 1px #444444;padding: 10px 0px 0px;"></td>
        </tr>
        <tr>
            <td colspan="3" style="border-left:solid 1px #444444;border-right:solid 1px #444444;line-height:25px; padding-bottom: 10px;" align="center">
                <strong>{{$company['company_name']}}</strong>
                <br/>
                {{$company['street']}}, {{$company['city']}}-{{$company['pincode']}}, {{$company['state']}}, India
            </td>
        </tr>
        <tr>
            <td style="border-left:solid 1px #444444;line-height:25px; padding: 0px 0px 8px 8px;" align="left" >
                &nbsp;<img src="{{url('assets/images/pdf_img/mail-icon.png')}}" alt="" width="12px" height="12px" />&nbsp;<strong >{{$company['company_email']}}</strong>
            </td>
            <td style="line-height:25px; padding-bottom: 8px;" align="center" >
                &nbsp;<img src="{{url('assets/images/pdf_img/web-icon.png')}}" alt="" width="10px" height="10px" />&nbsp;<strong>{{$company['website']}}</strong>
            </td>
            <td style="border-right:solid 1px #444444;line-height:25px; padding: 0px 8px 8px 0px;" align="right" >
                &nbsp;<img src="{{url('assets/images/pdf_img/phone-icon.png')}}" alt="" width="12px" height="12px" />&nbsp;<strong>{{$company['company_phone']}}</strong>&nbsp;
            </td>
        </tr>
    </table>

    <table width="1182" border="0" cellspacing="0" cellpadding="0" id="table-top">
        <tr>
            <td align="left" width="591" style="padding:0 5px;border-top:solid 1px #444444;border-right:solid 1px #444444;border-left:solid 1px #444444;line-height:30px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                    <tr>
                        <td align="left" width="295" style="line-height:30px;">&nbsp;&nbsp;Bill No:&nbsp;&nbsp;</strong>{{$bill['bill_no']}} </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" width="591" style="padding:0 5px;border:solid 1px #444444;line-height:30px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" width="295" style="line-height:30px;">&nbsp;&nbsp;Bill Date: <strong>{{date('d-m-Y', strtotime($bill['bill_date']))}}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" style="border-left: solid 1px #444444;border-right:solid 1px #444444;"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                    <tr>
                        <td align="left" width="68%" style="padding:0 5px;line-height:30px;">&nbsp;&nbsp;State: <strong>{{$company['state']}}</strong></td>
                        <td width="16%" style="border-left: solid 1px #444444;line-height:30px;" align="center">&nbsp;&nbsp;Code</td>
                        <td width="16%" style="border-left: solid 1px #444444;line-height:30px;" align="center"><strong>{{$company['state_code']}}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="td-gray" width="1182" border="1" cellspacing="0" cellpadding="0" id="table-top2">
        <tr>
            <td colspan="2" style="padding: 20px 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td bgcolor="#eeeeee" align="center" style="padding:0 5px;line-height:30px;"><strong>BILL TO PARTY</strong></td>
            <td align="center" bgcolor="#eeeeee" align="center" style="padding:0 5px;line-height:30px;"><strong>SHIP TO PARTY / DELIVERY ADDRESS</strong></td>
        </tr>
        <tr>
            <td align="left" width="50%" style="padding:0 5px;line-height:30px;" >&nbsp;&nbsp;<strong>{{$user['billing_first_name']}} {{$user['billing_last_name']}}</strong></td>
            <td align="left" width="50%" style="padding:0 5px;line-height:30px;">&nbsp;&nbsp;<strong>{{$user['shipping_first_name']}} {{$user['shipping_last_name']}}</strong></td>
        </tr>
        <tr>
            <td align="left" valign="top" style="padding:0 14px;line-height:30px;">{{$user['billing_street']}}, {{$user['billing_city']}}-{{$user['billing_pincode']}}, {{$user['state']}}, {{$user['billing_country']}}.</td>
            <td align="left" valign="top" style="padding:0 14px;line-height:30px;">{{$user['shipping_street']}}, {{$user['shipping_city']}}-{{$user['shipping_pincode']}}, {{$user['shipping_state']}}, {{$user['shipping_country']}}.</td>
        </tr>
        <tr>
            <td align="left" style="padding:0 5px;line-height:30px;">&nbsp;&nbsp;<strong>Phone No:</strong> {{$user['billing_phone']}}</td>
            <td align="left" style="padding:0 5px;line-height:30px;">&nbsp;&nbsp;<strong>Phone No:</strong> {{$user['shipping_phone']}}</td>
        </tr>
        <tr>
            <td align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" width="40%" style="padding:0 5px;line-height:30px; border: 0px;">&nbsp;&nbsp;<strong>State:</strong> {{$user['state']}}</td>
                        <td width="16%" style="border-left: solid 1px #444444; border-right: solid 1px #444444; border-top:0px; border-bottom:0px; line-height:30px;" align="center"><strong>Code</strong></td>
                        <td width="16%" style="border-left: solid 1px #444444; border-top:0px; border-bottom:0px;line-height:30px;" align="center">{{$user['state_code']}}</td>
                        <td align="left" width="28%" style="padding:0 5px;line-height:30px; border: 0px;">&nbsp;&nbsp;<strong>Country:</strong> {{$user['billing_country']}}</td>
                    </tr>
                </table>
            </td>
            <td align="left" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" width="40%" style="padding:0 5px;line-height:30px; border: 0px;">&nbsp;&nbsp;<strong>State:</strong> {{$user['shipping_state']}}</td>
                        <td width="16%" style="border-left: solid 1px #444444; border-right: solid 1px #444444; border-top:0px; border-bottom:0px;line-height:30px;" align="center"><strong>Code</strong></td>
                        <td width="16%" style="border-left: solid 1px #444444; border-top:0px; border-bottom:0px; line-height:30px;" align="center">{{$user['shipping_state_code']}}</td>
                        <td align="left" width="28%" style="padding:0 5px;line-height:30px; border: 0px;">&nbsp;&nbsp;<strong>Country:</strong> {{$user['shipping_country']}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 10px;border-left: solid 1px #444444; border-right:0px; border-bottom: 0px;">&nbsp;</td>
            <td style="padding: 20px 10px;border-top: solid 1px #444444; border-left:0px; border-right: solid 1px #444444;border-bottom: 0px;">&nbsp;</td>
        </tr>
    </table>

    <table width="1182" border="1" cellspacing="0" cellpadding="0" class="td-gray" style="margin-top: -1px;">
        <tr>
            <td width="38px" valign="top" align="center" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px;"><strong>#</strong></td>
            <td width="280px" valign="top" align="center" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Product</strong></td>
            <td width="40px" align="center" valign="top" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>HSN</strong></td>
            @if($bill['tax_type'] != 3)
                <td width="40px" align="center" valign="top" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Tax <br> %</strong></td>
            @endif
            <td width="50px" align="center" valign="top" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Qty</strong></td>
            <td width="140px" align="center" valign="top" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>RATE PER ITEM</strong></td>
            @if($bill['discount_level'] == 1)
                <td width="140px" align="center" valign="top" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Discount</strong></td>
            @endif

            <td width="150px" align="center" valign="top" bgcolor="#eeeeee" style="padding:0 5px;line-height:30px; text-transform: uppercase;">&nbsp;&nbsp;<strong>Total <br>Rs.</strong></td>
        </tr>
        @if(!empty($bill['BillItems']))
            @php $i=1; @endphp
            @foreach($bill['BillItems'] as $item)
                <tr>
                    <td style="line-height:30px;" align="center" valign="top">{{$i}}</td>
                    <td style="padding:0 5px;line-height:30px;" align="left" valign="top">{{$item['Product']['title']}}</td>
                    <td style="line-height:30px;" align="center" valign="top">{{$item['Product']['hsn_code']}}</td>
                    @if($bill['tax_type'] != 3)
                        <td style="line-height:30px;" align="center" valign="top">{{$item['tax_name']}}</td>
                    @endif
                    <td style="line-height:30px;" align="center" valign="top"><span class="quantity-input">{{$item['quantity']}}</span></td>
                    <td style="line-height:30px;" align="center" valign="top"><span class="rate-input">{{$item['rate']}}</span></td>
                    @if($bill['discount_level'] == 1)
                    <td style="line-height:30px;" align="center" valign="top">
                        @if($item['discount_type'] == 1)
                            @if($item['discount'])
                                {{$item['discount']}}%
                            @endif
                        @elseif($item['discount_type'] == 2)
                            @if($item['discount'])
                            Rs. {{$item['discount']}}
                            @endif
                        @endif
                    </td>
                    @endif
                    <td style="line-height:30px;" align="center" valign="top"><span class="amount-input">{{$item['amount']}} &nbsp;</span></td>
                    <td style="display:none;">
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

            @for($i=1; $i<=($bill['billItems']->count()>0?10-$bill['BillItems']->count():10); $i++)
                <tr>
                    <td style="line-height:30px;" align="center" valign="top"> &nbsp; </td>
                    <td style="padding:0 5px;line-height:30px;" align="left" valign="top"> &nbsp; </td>
                    <td style="line-height:30px;" align="center" valign="top"> &nbsp; </td>
                    @if($bill['tax_type'] != 3)
                        <td style="line-height:30px;" align="center" valign="top"> &nbsp; </td>
                    @endif
                    <td style="line-height:30px;" align="center" valign="top"><span class="quantity-input"> &nbsp; </span></td>
                    <td style="line-height:30px;" align="center" valign="top"><span class="rate-input"> &nbsp; </span></td>
                    @if($bill['discount_level'] == 1)
                        <td style="line-height:30px;" align="center" valign="top"><span class="rate-input"> &nbsp; </span></td>
                    @endif
                    <td style="line-height:30px;" align="center" valign="top"><span class="amount-input"> &nbsp; </span></td>
                </tr>
            @endfor
        @endif
    </table>

    <table width="1182" border="0" cellspacing="0" cellpadding="0" style="margin-top: -1px;">
        <tr>
            <td align="left" valign="top" style="border-top: solid 1px #444444; border-left:solid 1px #444444; border-right:solid 1px #444444;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding:8px 0px;border-bottom:solid 1px #444444;" valign="bottom">
                            <table  width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                                <tr>
                                    <td style="padding-left:15px"><strong>Payment Method : </strong>{{$payment_method['method_name']}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding:15px 15px 5px 15px;border-bottom:solid 1px #444444;">
                            <table cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td><strong>Memo</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0px;">{{$bill['memo']}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:5px 15px;" valign="bottom">
                            <table  width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                                <tr>
                                    <td><strong>Total Bill Amount in Words</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0px;">{{ucwords($bill['total_in_word'])}} Ruppes Only</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%" align="left" valign="top" style="border-right: solid 1px #444444;border-top: solid 1px #444444; line-height: 35px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" height="35" style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;">&nbsp;&nbsp;Total Amount before Tax</td>
                        <td align="right" height="35" style="border-right:0px;border-bottom:solid 1px #444444;">{{$bill['amount_before_tax']}}/-&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" height="35" style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;">&nbsp;&nbsp;Total Tax Amount</td>
                        <td align="right" height="35" style="border-right:0px;border-bottom:solid 1px #444444;">{{$bill['tax_amount']}}/-&nbsp;&nbsp;</td>
                    </tr>

                    @foreach($all_tax_labels as $tax)
                        @php
                            $arr = explode("_", $tax, 2);
                            $rate = $arr[0];
                            $tax_name = $arr[1];
                        @endphp
                        @if($tax_name == 'GST')
                            <tr class="{{str_replace(".","-",$rate).'_'.$tax_name}} hide">
                                <td align="left" height="35" style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;"> &nbsp; {{$rate / 2}}% CGST on Rs. <span id="label_1_{{str_replace(".","-",$rate).'_'.$tax_name}}">0.00</span></td>
                                <td align="right" style="border-right:0px;border-bottom:solid 1px #444444;"><span id="input_1_{{str_replace(".","-",$rate).'_'.$tax_name}}" class="tax-input-row"></span>&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="{{str_replace(".","-",$rate).'_'.$tax_name}} hide">
                                <td align="left" height="35" style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;"> &nbsp; {{$rate / 2}}% SGST on Rs. <span id="label_2_{{str_replace(".","-",$rate).'_'.$tax_name}}">0.00</span></td>
                                <td align="right" style="border-right:0px;border-bottom:solid 1px #444444;"><span id="input_2_{{str_replace(".","-",$rate).'_'.$tax_name}}" class="tax-input-row"></span>&nbsp;&nbsp;</td>
                            </tr>
                        @else
                            <tr class="{{str_replace(".","-",$rate).'_'.$tax_name}} hide">
                                <td align="left" height="35" style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;"> &nbsp; {{$rate.'% '.$tax_name}} on Rs. <span id="label_{{str_replace(".","-",$rate).'_'.$tax_name}}">0.00</span></td>
                                <td align="right" style="border-right:0px;border-bottom:solid 1px #444444;"><span id="input_{{str_replace(".","-",$rate).'_'.$tax_name}}" class="tax-input-row"></span>&nbsp;&nbsp;</td>
                            </tr>
                        @endif
                    @endforeach
                    @if($bill['discount_level'] == 0)
                    <tr>
                        <td style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; ">
                                <tr>
                                    <td height="35" align="left" width="60%" style="">&nbsp;&nbsp;Discount</td>
                                    <td align="right" style="border-left:solid 1px #444444; text-align: center;">@if($bill['discount_type']==1) {{$bill['discount']}} % @else - @endif</td>
                                </tr>
                            </table>
                        </td>
                        <td style="border-bottom:solid 1px #444444;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; ">
                                <tr>
                                    <td height="35" align="left" width="50%" style="">
                                        &nbsp;&nbsp;Discount
                                    </td>
                                    <td align="right" style="width:100px;border-left:solid 1px #444444;">{{$bill['discount']}}&nbsp;&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td align="left" height="35" style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;">&nbsp;&nbsp;Total Amount After Tax</td>
                        <td align="right" style="border-right:0px;border-bottom:solid 1px #444444;">{{$bill['total']}}/-&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" height="35" style="border-right:solid 1px #444444;border-bottom:solid 1px #444444;">&nbsp;&nbsp;Round Off</td>
                        <td align="right" style="border-right:0px;border-bottom:solid 1px #444444;">-&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" height="35" style="border-right:solid 1px #444444; border-bottom:solid 1px #444444; text-transform: uppercase;"><strong>&nbsp;&nbsp;Total</strong></td>
                        <td align="right" style="border-right:0px; border-bottom:solid 1px #444444;"><strong>{{$bill['total']}}/-&nbsp;&nbsp;</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="2" align="left" style="padding: 3px 5px; border-left:solid 1px #444444;border-right: solid 1px #444444;border-top: solid 1px #444444;">E. & O.E</td></tr>
        <tr>
            <td align="left" style="border-left:solid 1px #444444;border-bottom: solid 1px #444444;line-height:30px;">
                @if(in_array($bill['status'],[1,2,4]))
                    <img src="{{$bill['status_image']}}" alt="" width="150" height="70" />
                @endif
            </td>
            <td align="right" style="padding:0 10px 20px; border-bottom: solid 1px #444444;border-right:solid 1px #444444;line-height:30px;">
                <strong>For, {{$company['company_name']}}</strong>&nbsp;&nbsp;<br/>
                <img src="{{url($company['signature_image'])}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
                Authorised Signature&nbsp;&nbsp;
                <br>
                This is computer generated bill and does not require a signature
            </td>
        </tr>
    </table>


    <script type="text/javascript">
        function subTotal() {
            amount = 0;
            $('.amount-input').each(function(){
                var val = $(this).html();
                if(val == null || val == '') {
                    val = 0;
                }
                amount += parseFloat(val);
            });

            var tax_type = $('#amounts_are').val();
            var final_amount = 0;
            if(tax_type == 'exclusive') {
                final_amount = amount;
            } else if(tax_type == 'inclusive') {
                var total_tax_amount = getTotalTax();
                final_amount = parseFloat(amount) - parseFloat(total_tax_amount);
            } else {
                final_amount = amount;
            }
            //$('#subtotal').val('Rs. ' + final_amount.toFixed(2));

            return final_amount.toFixed(2);
        }

        function getTotalTax() {
            total_tax_amount = 0;
            $('.tax-input-row').each(function() {
                var val = $(this).html();
                if(!$(this).parent('td').parent('tr').hasClass('hide')){
                    val = val.replace('Rs. ','');
                    if(val == null || val == '') {
                        val = 0;
                    }
                    total_tax_amount += parseFloat(val);
                }
            });
            return total_tax_amount;
        }

        function taxCalculation() {
            var subtotal = subTotal();
            var tax_type = $('#amounts_are').val();
            var tax = 0;
            var total = 0;
            var amount_before_tax = 0;

            var tax_arr = [];
            var tax_total_arr = [];
            var i = 0;

            $('.tax-input').find('option').each(function() {
                var str = $(this).filter(":selected").text();
                var opt = $(this).text();
                var opt_str = opt.replace("% ", "_").replace(" + ","+").replace(" ", "_").replace("%", "").replace(".", "-");
                var tax_str = str.replace("% ", "_").replace(" + ","+").replace(" ", "_").replace("%", "").replace(".", "-");
                var is_cess = false;
                var cess_arr = [];
                if (tax_str.indexOf('CESS') > -1) {
                    is_cess = true;
                    cess_arr = tax_str.split("+");
                }
                var amount = 0;
                amount = $(this).parent('select').parent('td').prev('td').find('.amount-input').html();

                if(cess_arr.length > 0 && is_cess) {
                    for(var r=0;r < cess_arr.length;r++){
                        tax_str = cess_arr[r];
                        var opt1_str = opt_str.substr(0, opt_str.indexOf('+'));
                        var opt2_str = opt_str.split('+').pop();
                        var tax_name = tax_str.split('_').pop();
                        var tax_rate = tax_str.substr(0, tax_str.indexOf('_'));
                        var tax_raw_html = '';
                        var tax_id = $(this).val();
                        if(tax_str != '') {
                            var tax_hidden = 0;
                            tax_hidden += parseFloat(amount);
                            $("#id_"+ tax_str).val(tax_hidden);
                        }

                        var cls_opt_str1 = "." + opt1_str;
                        var cls_opt_str2 = "." + opt2_str;

                        $(cls_opt_str1).addClass("hide");
                        $(cls_opt_str2).addClass("hide");

                        if(tax_str != '' && tax_str !=  null) {
                            tax_arr[i] = tax_str;
                            if(tax_total_arr.hasOwnProperty(tax_str)) {
                                tax_total_arr[tax_str] += parseFloat(amount);
                            } else {
                                tax_total_arr[tax_str] = parseFloat(amount);
                            }
                            i++;
                        }
                    }
                } else {
                    var tax_name = tax_str.split('_').pop();
                    var tax_rate = tax_str.substr(0, tax_str.indexOf('_'));
                    var tax_raw_html = '';
                    var tax_id = $(this).val();

                    if(tax_str != '') {
                        var tax_hidden = 0;
                        tax_hidden += parseFloat(amount);
                        $("#id_"+ tax_str).val(tax_hidden);
                    }
                    if (opt_str.indexOf('CESS') > -1) {
                        var opt_str2 = opt_str.substr(0, opt_str.indexOf('+'));
                        opt_str = opt_str.split('+').pop();
                        $('.'+opt_str2).addClass("hide");
                    }
                    var cls_opt_str = "." + opt_str;
                    $(cls_opt_str).addClass("hide");
                    if(tax_str != '' && tax_str !=  null) {
                        tax_arr[i] = tax_str;
                        if(tax_total_arr.hasOwnProperty(tax_str)) {
                            tax_total_arr[tax_str] += parseFloat(amount);
                        } else {
                            tax_total_arr[tax_str] = parseFloat(amount);
                        }
                        i++;
                    }
                }
            });

            $('.amount-input').each(function() {
                var tax_text = $(this).parent('td').next('td').find('.tax-input').find(":selected").text();
                var amount = parseFloat($(this).val());
            });

            if(tax_type != 'out_of_scope') {
                for(var a=0; a < tax_arr.length; a++) {
                    $("."+tax_arr[a]).removeClass("hide");
                }
            }

            for (var key in tax_total_arr) {
                var value = parseFloat(tax_total_arr[key]);
                var tax = key.split('_')[1];
                var tax_rate = parseFloat(key.substr(0, key.indexOf('_')).replace("-", "."));
                var tax_amount = 0;

                if(tax == 'GST') {
                    if(tax_type == 'exclusive') {
                        var tax_rate_gst = tax_rate / 2;
                        if(isNaN(value)) {
                            value=0;
                        }
                        $("#label_1_"+key).html(value.toFixed(2));
                        $("#label_2_"+key).html(value.toFixed(2));
                        tax_amount = value * tax_rate_gst / 100;
                        amount_before_tax = parseFloat(subtotal).toFixed(2);
                        if(isNaN(tax_amount)) {
                            tax_amount=0;
                        }
                        $("#input_1_"+key).html(tax_amount.toFixed(2));
                        $("#input_2_"+key).html(tax_amount.toFixed(2));
                    } else if(tax_type == 'inclusive') {
                        var tax_rate_gst = tax_rate / 2;
                        tax_amount = value * tax_rate / (parseInt(100) + parseInt(tax_rate));
                        var new_value = parseFloat(value) - parseFloat(tax_amount);
                        if(isNaN(new_value)) {
                            new_value=0;
                        }
                        amount_before_tax = parseFloat(new_value).toFixed(2);
                        $("#label_1_"+key).html(new_value.toFixed(2));
                        $("#label_2_"+key).html(new_value.toFixed(2));
                        var new_tax_value = tax_amount / 2;
                        if(isNaN(new_tax_value)) {
                            new_tax_value=0;
                        }
                        $("#input_1_"+key).html(new_tax_value.toFixed(2));
                        $("#input_2_"+key).html(new_tax_value.toFixed(2));
                    }
                } else {
                    if(tax_type == 'exclusive') {
                        tax_amount = value * tax_rate / 100;
                        amount_before_tax = parseFloat(subtotal).toFixed(2);
                        if(isNaN(value)) {
                            value=0;
                        }
                        $("#label_"+key).html(value.toFixed(2));
                    } else if(tax_type == 'inclusive') {
                        tax_amount = value * tax_rate / (parseInt(100) + parseInt(tax_rate));
                        var new_value = parseFloat(value) - parseFloat(tax_amount);
                        if(isNaN(new_value)) {
                            new_value=0;
                        }
                        amount_before_tax = parseFloat(new_value).toFixed(2);
                        $("#label_"+key).html(new_value.toFixed(2));
                    }
                    if(isNaN(tax_amount)) {
                        tax_amount=0;
                    }
                    $("#input_"+key).html(tax_amount.toFixed(2));
                }
            }
            var total_tax = getTotalTax();
            if(tax_type == 'exclusive') {
                total = parseFloat(subtotal) + parseFloat(total_tax);
            } else if(tax_type == 'inclusive') {
                subtotal = subTotal();
                amount_before_tax = parseFloat(subtotal);
                total = parseFloat(subtotal) + parseFloat(total_tax);
            } else {
                total_tax = 0;
                amount_before_tax = parseFloat(subtotal).toFixed(2);
                total = parseFloat(subtotal);
            }

            //$('#total').val('Rs. '+ parseFloat(total).toFixed(2));
            //$('#amount_before_tax').val(amount_before_tax);
            //$('#tax_amount').val(total_tax.toFixed(2));
            //$('#total_amount').val(parseFloat(total).toFixed(2));
        }

        $(document).ready(function(){
            taxCalculation();
        });
    </script>

</body>
</html>
