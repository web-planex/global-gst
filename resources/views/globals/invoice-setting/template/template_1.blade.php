<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
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
                            <img src="{{url('assets/images/pdf_img/logo_1510567062.png')}}" alt="" width="auto" height="100" style="vertical-align: middle; margin-bottom: 10px;">
                            <br />
                            <strong style="font-size: 12px; color:#{{$company->color}};">WebPlanex Infotech Pvt. Ltd</strong>
                        </td>
                        <td width="46%" align="center" style="font-size:36px; text-transform: uppercase; color:#656565; vertical-align: middle">
                            Tax Invoice
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
                                                    1234567890
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
                                                    info@webplanex.com
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
                                                    311-c, 3rd Floor, Iscon Mall, 150ft Ring Road, Rajkot-360005, Gujarat, India
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
                                                    Aryan H
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="line-height: 20px;font-size:14px; padding-bottom: 5px;">
                                                    Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom: 5px;"><strong>Phone: </strong>
                                                    4455661122
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="30%" align="left" valign="top" style="padding-right: 30px;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                            <tr>
                                                <td align="left" valign="middle" style="font-size:14px; padding:4px 0px;">Shipping Information</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" style="font-size:14px; font-weight:bold; padding-bottom: 5px;">
                                                    Aryan H
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="line-height: 20px;font-size:14px; padding-bottom: 5px;">
                                                    Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom: 5px;"><strong>Phone:</strong>
                                                    4455661122
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="30%" align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom: 5px;">
                                                    <strong style="color:#{{$company->color}};">Invoice No: </strong>13465
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="60" align="left" valign="top" style="font-size:14px; padding-bottom:20px;">
                                                    <strong style="color:#{{$company->color}};">Invoice Date: </strong>
                                                    27-03-2021
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom:5px;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:14px; padding-bottom:5px;">
                                                    <strong>Payment Method:</strong>
                                                    Cash
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
            <td width="240px" valign="top" align="center" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>ITEM - SKU</strong></td>
            <td width="50px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Qty</strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="50px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>HSN</strong></td>
            <td width="40px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>GST <br> (%)</strong></td>
            <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-left: solid 2px #fff; padding:0 5px;line-height:30px; text-transform: uppercase;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td style="width: 5%">&nbsp;</td>
        </tr>
        <tr style="background-color:#e8e8e8">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">1</td>
            <td style="padding:0 5px;line-height:30px; border: solid 2px #fff;" align="left" valign="top">One Plus 7T - 20208597T </td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="rate-input">34,500.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">34,500.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">ONE7T</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">28</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">4,830.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">4,830.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">0.00</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="right" valign="top"><span class="amount-input">44,160.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
        <tr style="background-color:#f1f1f1">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">2</td>
            <td style="padding:0 5px;line-height:30px; border: solid 2px #fff;" align="left" valign="top">Samsung A50 - A502020 </td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="rate-input">19,500.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">19,500.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">SAMA50</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">18</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">1,755.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">1,755.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">(10) 1,950.00</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="right" valign="top"><span class="amount-input">24,960.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
        <tr style="background-color:#e8e8e8">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">3</td>
            <td style="padding:0 5px;line-height:30px; border: solid 2px #fff;" align="left" valign="top">Samsung Note 10+ - NOTE2019</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="rate-input">74,500.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">74,500.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">NOTE10</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">12</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">4,470.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">4,470.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">0.00</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="right" valign="top"><span class="amount-input">83,440.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
        <tr style="background-color:#f1f1f1">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">4</td>
            <td style="padding:0 5px;line-height:30px; border: solid 2px #fff;" align="left" valign="top">Oppo Find X - FINDX</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="rate-input">64,000.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">64,000.00</span></td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">FINDX</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="center" valign="top">12</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">3,840.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">3,840.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border: solid 2px #fff; text-transform: uppercase;">0.00</td>
            <td style="line-height:30px; border: solid 2px #fff;" align="right" valign="top"><span class="amount-input">71,680.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
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
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada elit id euismod elementum
                                    </td>
                                </tr>
                                {{-- <tr>
                                  <td valign="top" height="20"
                                    style="padding:20px 0 8px;font-size:11px; color:#{{$company->color}}; margin:0;">
                                    <strong>{{ $invoice_label['total_amount_in_word'] }}</strong></td>
                                </tr>
                                <tr>
                                  <td style="padding: 0px 0px 10px 0px; font-size:12px;">
                                    One Hundred Thirty Eight Dollars and Eighty Cents Only
                                  </td>
                                </tr> --}}

                                <tr>
                                    <td align="left" valign="top" style="padding:8px 0; font-size:11px; color:#{{$company->color}};">
                                        <img src="{{url('assets/images/pdf_img/paid_imag.png')}}" alt="" width="150" height="70" />
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
                                        192500.00
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Total Tax Amount
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">
                                        31740.00
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Discount &nbsp;&nbsp;
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">
                                        22,872.48
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Shipping Charge
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">
                                        -
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Total Amount After Tax
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">
                                        201367.52
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border: solid 2px #fff; padding-right:10px;">
                                        Round Off
                                    </td>
                                    <td height="35" align="right" style="border: solid 2px #fff; padding:0 10px;">(+) 0.48</td>
                                </tr>
                                <tr bgcolor="#{{$company->color}}">
                                    <td height="38" align="right" style="font-size: 18px; color: #fff; padding-right:10px; border: solid 2px #fff;">
                                        <strong>Total</strong>
                                    </td>
                                    <td height="38" align="right" style="padding:6px 10px; font-size: 18px; color: #fff; border: solid 2px #fff;">
                                        <strong>201,368.00</strong>
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
                            <strong>For, WebPlanex Infotech Pvt. Ltd</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <img src="{{url('assets/images/pdf_img/signature.png')}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
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