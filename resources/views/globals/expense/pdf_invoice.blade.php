<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice</title>
<style>
	table { border-collapse: collapse; border-color:#000; }
</style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0; font-weight:normal; line-height:16px;">

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border:solid 2px #000;">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" style="padding:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center">|| Shree Ganeshay namah ||</td>
          </tr>
          <tr>
            <td align="left"><strong>GSTIN : {{$company['gstin']}}</strong></td>
          </tr>
          <tr>
            <td align="center"><img src="{{url($company['company_logo'])}}" alt="" width="auto" height="auto" style="max-height:50px;"/></td>
          </tr>
          <tr>
            <td align="center"><strong>{{$company['name']}}</strong><br/>
              {{$company['street']}}, {{$company['city']}}, - {{$company['pincode']}} ({{$company['state']}}) Mo. {{$company['company_phone']}}  
             </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" id="table-top">
          <tr>
            <td width="67%" height="30" style="padding:0 5px;" >Invoice No. :  <strong>003</strong> <div style="float:right; width:170px;"><strong>DUPLICATE</strong></div></td>
            <td width="33%" style="padding:0 5px;">Transport Model : Bule Dart Express</td>
          </tr>
          <tr>
            <td height="30" style="padding:0 5px;">Invoice Date : {{$expense['created_at']->format('d-m-Y')}}</td>
            <td style="padding:0 5px;">Vehicle Number : </td>
          </tr>
          <tr>
            <td height="30" style="padding:0 5px;">Reverse Charge (Y/N) : </td>
            <td style="padding:0 5px;">Date of  Supply : 24-07-2017</td>
          </tr>
          <tr>
            <td height="30" v><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="68%" height="30" style="padding:0 5px;">State : GUJARAT </td>
                  <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                  <td width="16%" style="border-left: solid 1px #000;" align="center">24</td>
                </tr>
              </table></td>
            <td style="padding:0 5px;">Place of Supply : VARANASI (UP)</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" id="table-top2">
          <tr>
            <td bgcolor="#eeeeee" height="30" align="center" style="padding:0 5px;" >BILL TO PARTY</td>
            <td  bgcolor="#eeeeee" align="center" style="padding:0 5px;">SHIP TO PARTY / DELIVERY ADDRESS</td>
          </tr>
          <tr>
            <td width="50%" height="30" style="padding:0 5px;" >Name : {{$user['first_name']}} {{$user['last_name']}}</td>
            <td width="50%" style="padding:0 5px;">Name : {{$user['first_name']}} {{$user['last_name']}}</td>
          </tr>
          <tr>
            <td height="50" valign="top" style="padding:0 5px;">Address :  {{$user['street']}}, {{$user['city']}}-{{$user['pincode']}}</td>
            <td valign="top"  style="padding:0 5px;">Address :  {{$user['street']}}, {{$user['city']}}-{{$user['pincode']}}</td>
          </tr>
          <tr>
            <td height="30" style="padding:0 5px;">GSTIN : @if(!empty($user['gstin']) ) {{$user['gstin']}} @endif</td>
            <td style="padding:0 5px;">GSTIN : @if(!empty($user['gstin']) ) {{$user['gstin']}} @endif</td>
          </tr>
          <tr>
            <td height="30" v="v"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="68%" height="30" style="padding:0 5px;">State : {{$user['state']}} </td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">09</td>
              </tr>
            </table></td>
            <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="68%" height="30" style="padding:0 5px;">State : {{$user['state']}} </td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">Code</td>
                <td width="16%" style="border-left: solid 1px #000;" align="center">09</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="5%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Sr.<br/> No.</td>
            <td width="24%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Item Name</td>
            <td width="22%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Description</td>
            <td width="15%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Tax</td>
            <td width="9%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Quantity</td>
            <td width="17%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Rate</td>
            <td width="17%" align="center" bgcolor="#eeeeee" style="padding:0 5px;">Amount</td>            
          </tr>
           @if(!empty($expense))
                    @foreach($expense['ExpenseItems'] as $list)
                            <tr>
                            <td height="30" align="center">1</td>
                            <td height="30" align="center">{{$list['item_name']}}</td>
                            <td height="30" align="center">{{$list['description']}}</td>
                            <td height="30" align="center" class="tax-input"  style="padding:0 5px;">{{$list['tax_name']}}</td>
                            <td height="30" align="center">{{$list['quantity']}}</td>
                            <td height="30" align="center">{{$list['rate']}}</td>
                            <td height="30" align="right" style="padding:0 5px;">{{$list['amount']}}/-</td>                            
                          </tr>
                    @endforeach
           @endif
          <tr>
            <td colspan="3" rowspan="10" align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="123" style="padding:0 10px; border-bottom:solid 1px #000;">
                                  <strong>Bank Details</strong> :<br/>
                                  <strong>Current Account</strong> : JSK SLIVER ORNEMTNS<br/>
                                          BANK OF INDIA<br/>
                                          Branch : Bedipara<br/>
                                          A/c. No. : 310820110000502<br/>
                                          IFSC Code : BKID0003108
                              </td>
                            </tr>
                            <tr>
                                  <td height="123" style="padding:0 10px; border-bottom:solid 1px #000;" valign="bottom">
                                          <div style="display:block; height:45px;"><strong>Total Invoice Amount in Words :</strong></div>
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
                              <td height="60" style="padding:0 10px;">
                                  <strong>Subject to Rajkot Jurisdiction<br/>E. & O. E.</strong>
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
          <tr>
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
          </tr>
          <tr>
            <td height="30" colspan="2" style="padding:0 5px;">Total Amount After Taxl</td>
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
        <td height="72" valign="middle" align="right" style="padding:0 10px; border-top: solid 1px #000;"><div style="display:block; height:50px;"><strong>For, J S K Silver Omaments</strong></div>

Authorised Signature</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
