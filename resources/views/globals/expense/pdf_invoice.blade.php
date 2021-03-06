<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Expense</title>
<style>
    table { border-collapse: collapse; border-color:#000; }
    .hide {display: none;}
    
</style>
<script src="{{ asset('assets/jquery/jquery-3.2.1.min.js') }}"></script>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0; font-weight:normal; line-height:16px;">
@if($expense['tax_type'] == 1)
<input type="hidden" id="amounts_are" value="exclusive" />
@elseif($expense['tax_type'] == 2)
<input type="hidden" id="amounts_are" value="inclusive" />
@elseif($expense['tax_type'] == 3)
<input type="hidden" id="amounts_are" value="out_of_scope" />
@endif
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border:solid 2px #000;">
    <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top" style="padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left"><strong>GSTIN : {{$company['gstin']}}</strong></td>
        </tr>
        <tr>
            <td align="center"><img src="{{url($company['company_logo'])}}" alt="" width="auto" height="auto" style="max-height:50px;"/></td>
        </tr>
        <tr>
            <td align="center"><strong>{{$company['name']}}</strong><br/>
                {{$company['street']}}, {{$company['city']}}, - {{$company['pincode']}} ({{$company['state']}}) Phone No. {{$company['company_phone']}}  
            </td>
        </tr>
        </table></td>
        </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" id="table-top">
          <tr>
            <td width="67%" height="30" style="padding:0 5px;" >Ref no. :  <strong>003</strong></td>
            <!--<td width="33%" style="padding:0 5px;">Transport Model : Bule Dart Express</td>-->
          </tr>
          <tr>
            <td height="30" style="padding:0 5px;">Expense Date : {{$expense['created_at']->format('d-m-Y')}}</td>
            <!--<td style="padding:0 5px;">Vehicle Number : </td>-->
          </tr>
          <tr>
            <td height="30" style="padding:0 5px;">Reverse Charge (Y/N) : </td>
            <!--<td style="padding:0 5px;">Date of  Supply : 24-07-2017</td>-->
          </tr>
          <tr>
            <td height="30" v><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="68%" height="30" style="padding:0 5px;">State : {{$user['state']}} </td>
                  <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                  <td width="16%" style="border-left: solid 1px #000;" align="center">{{$user['state_code']}}</td>
                </tr>
              </table></td>
            <!--<td style="padding:0 5px;">Place of Supply : VARANASI (UP)</td>-->
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" id="table-top2">
          <tr>
            <td bgcolor="#eeeeee" height="30" align="center" style="padding:0 5px;" >Payment To</td>
            <!--<td  bgcolor="#eeeeee" align="center" style="padding:0 5px;">SHIP TO PARTY / DELIVERY ADDRESS</td>-->
          </tr>
          <tr>
            <td width="50%" height="30" style="padding:0 5px;" >Payee Name : {{$user['first_name']}} {{$user['last_name']}}</td>
            <!--<td width="50%" style="padding:0 5px;">Name : {{$user['first_name']}} {{$user['last_name']}}</td>-->
          </tr>
          <tr>
            <td height="50" style="padding:0 5px;">Address :  {{$user['street']}}, {{$user['city']}}-{{$user['pincode']}}</td>
            <!--<td valign="top"  style="padding:0 5px;">Address :  {{$user['street']}}, {{$user['city']}}-{{$user['pincode']}}</td>-->
          </tr>
          <tr>
            <td height="30" style="padding:0 5px;">GSTIN : @if(!empty($user['gstin']) ) {{$user['gstin']}} @endif</td>
            <!--<td style="padding:0 5px;">GSTIN : @if(!empty($user['gstin']) ) {{$user['gstin']}} @endif</td>-->
          </tr>
          <tr>
            <td height="30" v="v"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="68%" height="30" style="padding:0 5px;">State : {{$user['state']}} </td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">{{$user['state_code']}}</td>
              </tr>
            </table></td>
<!--            <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="68%" height="30" style="padding:0 5px;">State : {{$user['state']}} </td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">{{$user['state_code']}}</td>
              </tr>
            </table></td>-->
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="4%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Sr.<br/> No.</td>
            <td width="34%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Product</td>
            <td width="12%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">HSN Code</td>
            <td width="20%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Tax</td>
            <td width="5%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Quantity</td>
            <td width="13%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Rate</td>
            <td width="21%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Amount</td>            
          </tr>
           @if(!empty($expense))
                    @php $i=1; @endphp
                    @foreach($expense['ExpenseItems'] as $list)
                        <tr>
                            <td height="30" align="center">{{$i}}</td>
                            <td height="30" align="left" style="padding:0 5px;">
                            @foreach($products as $pro)
                                @if($pro['id'] == $list['product_id']){{$pro['title']}}@endif
                            @endforeach
                            </td>
                            <td height="30" align="center">{{$list['hsn_code']}}</td>
                            <td height="30" align="left" style="padding:0 5px;">{{$list['tax_name']}}</td>
                            <td height="30" align="center"><span class="quantity-input">{{$list['quantity']}}</span></td>
                            <td height="30" align="center"><span class="rate-input">{{$list['rate']}}</span></td>
                            <td height="30" align="right" style="padding:0 5px;"><span class="amount-input">{{$list['amount']}}</span>/-</td>
                            <td style="display:none;">
                            <select id="taxes" class="tax-input">
                                @foreach($taxes as $tax)
                                    @if($tax['is_cess'] == 0)
                                    <option value="{{$tax['id']}}" @if(!empty($list['tax_id']) && $list['tax_id']==$tax['id'])) selected @endif>{{$tax['rate'].'% '.$tax['tax_name']}}</option>
                                    @else
                                    <option value="{{$tax['id']}}" @if(!empty($list['tax_id']) && $list['tax_id']==$tax['id'])) selected @endif>{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </td>
                          </tr>
                    @php $i++; @endphp
                    @endforeach
            @endif
            <tr>
                <td colspan="3" rowspan="{{$tax_count}}" align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="123" style="padding:0 10px; border-bottom:solid 1px #000;">
                                <strong>Payment Method</strong> : {{App\Models\Globals\Expense::$payment_method[$expense['payment_method']]}}
                            </td>
                        </tr>
                        <tr>
                            <td height="123" style="padding:0 10px; border-bottom:solid 1px #000;" valign="bottom">
                                <div style="display:block; height:45px;"><strong>Total Expense Amount in Words :</strong></div>
                                <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                        <td height="35" style="padding:0 5px; border-top:solid 1px #000;">{{ucwords($expense['total_in_word'])}} Only</td>
                                    </tr>
                                    <tr>
                                          <td height="35" style="padding:0 5px; border-top:solid 1px #000;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                          <td height="30" style="padding:0 10px;">
                              <strong>E. & O. E.</strong>
                          </td>
                        </tr>
                    </table>
                </td>
                <td height="30">&nbsp;</td>
                <td height="30">&nbsp;</td>
                <td height="30">&nbsp;</td>
                <td height="30">&nbsp;</td>
            </tr>
            <tr>
                  <td height="30" colspan="2" style="padding:0 5px;">Total Amount before Tax</td>
                  <td height="30" colspan="2" align="right" style="padding:0 5px;">{{$expense['amount_before_tax']}}</td>
            </tr>
            @foreach($all_tax_labels as $tax)
                @php
                $arr = explode("_", $tax, 2);
                $rate = $arr[0];
                $tax_name = $arr[1];
                @endphp
                @if($tax_name == 'GST')
                <tr class="{{$rate.'_'.$tax_name}} hide">
                    <td height="30" align="left" colspan="2" style="padding:0 5px;">{{$rate / 2}}% CGST on Rs. <span id="label_1_{{$rate.'_'.$tax_name}}">0.00</span></td>
                    <td height="30" align="right" colspan="2" style="padding:0 5px;"><span id="input_1_{{$rate.'_'.$tax_name}}" class="tax-input-row"></span></td>
                </tr>
                <tr class="{{$rate.'_'.$tax_name}} hide">
                    <td height="30" align="left" colspan="2" style="padding:0 5px;">{{$rate / 2}}% SGST on Rs. <span id="label_2_{{$rate.'_'.$tax_name}}">0.00</span></td>
                    <td height="30" align="right" colspan="2" style="padding:0 5px;"><span id="input_2_{{$rate.'_'.$tax_name}}" class="tax-input-row"></span></td>
                </tr>
                @else
                <tr class="{{$rate.'_'.$tax_name}} hide">
                    <td height="30" align="left" colspan="2" style="padding:0 5px;">{{$rate.'% '.$tax_name}} on Rs. <span id="label_{{$rate.'_'.$tax_name}}">0.00</span></td>
                    <td height="30" align="right" colspan="2" style="padding:0 5px;"><span id="input_{{$rate.'_'.$tax_name}}" class="tax-input-row"></span></td>
                </tr>
                @endif
            @endforeach
<!--          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">Add. CGST &nbsp; 0 %</td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;">-</td>
          </tr>
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">Add. SGST &nbsp; 0 %</td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;">-</td>
          </tr>
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">Add. IGST &nbsp; 3 %</td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;">39663/-</td>
          </tr>
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">Total Tax Amount</td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;">{{$expense['tax_amount']}}</td>
          </tr>
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">GST on Reverse Charge</td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;">&nbsp;</td>
          </tr>-->
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">Total Amount After Tax</td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;">{{$expense['total']}}</td>
          </tr>
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">Discount / Labour Etx.</td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;"><strong>Total</strong></td>
            <td height="30" colspan="2" align="right" style="padding:0 5px;"><strong>{{$expense['total']}}</strong></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="72" valign="middle" align="right" style="padding:0 10px; border-top: solid 1px #000;"><div style="display:block; height:50px;"><strong>For, {{$company_name}}</strong></div>

Authorised Signature</td>
      </tr>
    </table></td>
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
        var opt_str = opt.replace("% ", "_").replace(" + ","+").replace(" ", "_").replace("%", "");
        var tax_str = str.replace("% ", "_").replace(" + ","+").replace(" ", "_").replace("%", "");
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
        var tax_rate = key.substr(0, key.indexOf('_'));
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
