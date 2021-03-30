<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
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
                                                    <img src="{{url('assets/images/pdf_img/logo_1510567062.png')}}" alt="" width="auto" height="auto" style="max-height:50px; margin-bottom: 10px;" />
                                                    <br />
                                                    <strong style="font-size: 12px; color:#ffffff;">WebPlanex Infotech Pvt. Ltd</strong>
                                                </td>
                                                <td align="left" width="23%" style="padding:0 15px; vertical-align: top;">
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td>
                                                                <img src="{{url('assets/images/pdf_img/phone-receiver-white.png')}}" style="margin:0px;" alt="" width="16" height="16" />&nbsp;&nbsp;
                                                            </td>
                                                            <td style="margin:0; font-size:13px; color:#ffffff;">
                                                                1234567890
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
                                                                info@webplanex.com
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
                                                                311-c, 3rd Floor, Iscon Mall, 150ft Ring Road, Rajkot-360005, Gujarat, India
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
                                                                Aryan H
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="left" valign="top" style="padding-bottom: 5px; color:#fff;">
                                                                Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px; color:#fff;">
                                                                <strong>Phone:</strong> 4455661122
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="34%">
                                                    <table cellpadding="0" cellspacing="0" style="width: 100%">
                                                        <tr>
                                                            <td colspan="2" align="left" valign="middle" style="font-size:12px; padding-bottom:5px; color:#fff;">
                                                                Shipping Information
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-size:15px; font-weight:bold; padding-bottom:5px; color:#fff;">
                                                                Aryan H
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="left" valign="top" style="padding-bottom: 5px; color:#fff;">
                                                                Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom: 5px; color:#fff;">
                                                                <strong>Phone:</strong> 4455661122
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="30%" align="right" style="vertical-align: top;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="right" valign="top" style="font-size:20px; text-transform: uppercase; padding:15px 0 15px 0; color:#ffffff;">
                                                                <strong>Tax Invoice</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="padding-bottom:6px; color:#fff; vertical-align:top;">
                                                                <strong>Invoice Date:</strong> 27-03-2021
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="padding-bottom:6px; color:#fff; vertical-align:top;">
                                                                <strong>Invoice No:</strong> 12345
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" style="color:#fff; padding-bottom:6px; vertical-align:top;">
                                                                <strong>Payment Method:</strong> Cash
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr style="background-color: #313131">
        <td style="width: 5%">&nbsp;</td>
        <td width="38px" valign="middle" align="center" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>#</strong></td>
        <td width="240px" valign="middle" align="left" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>ITEM - SKU</strong></td>
        <td width="50px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>Qty</strong></td>
        <td width="100px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="100px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="50px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>HSN</strong></td>
        <td width="40px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>GST <br> (%)</strong></td>
        <td width="80px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="80px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="100px" align="center" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
        <td width="100px" align="right" valign="middle" style="color: #fff; font-size:14px; font-weight:bold; border-bottom: solid 1px #fff;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td style="width: 5%">&nbsp;</td>
    </tr>
    <tr style="background-color: #f1f1f1;">
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">1</td>
        <td style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff;" align="left" valign="top">One Plus 7T - 20208597T</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="rate-input">34,500.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">34,500.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">ONE7T</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">28</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">4,830.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">4,830.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">0.00</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="right" valign="top"><span class="amount-input">44,160.00</span></td>
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
    </tr>
    <tr style="background-color: #e8e8e8">
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">2</td>
        <td style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff;" align="left" valign="top">Samsung A50 - A502020</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="rate-input">19,500.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">19,500.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">SAMA50</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">18</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">1,755.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">1,755.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">(10) 1,950.00</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="right" valign="top"><span class="amount-input">24,960.00</span></td>
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
    </tr>
    <tr style="background-color: #f1f1f1">
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">3</td>
        <td style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff;" align="left" valign="top">Samsung Note 10+ - NOTE2019</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="rate-input">74,500.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">74,500.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">NOTE10</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">12</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">4,470.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">4,470.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">0.00</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="right" valign="top"><span class="amount-input">83,440.00</span></td>
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
    </tr>
    <tr style="background-color: #e8e8e8">
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">4</td>
        <td style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff;" align="left" valign="top">Oppo Find X - FINDX</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="rate-input">64,000.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top"><span class="taxable-input">64,000.00</span></td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">FINDX</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="center" valign="top">12</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">3,840.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">3,840.00</td>
        <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px; border-bottom: solid 2px #fff; text-transform: uppercase;">0.00</td>
        <td style="line-height:30px; border-bottom: solid 2px #fff;" align="right" valign="top"><span class="amount-input">71,680.00</span></td>
        <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
    </tr>
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
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada elit id euismod elementum
                                    </div>
                                </td>
                            </tr>

                            {{-- <tr>
                                <td valign="top"
                                    style="font-size:11px; color:#313131; margin:0; text-transform: uppercase;">
                                    <strong>{{ $invoice_label['total_amount_in_word'] }}</strong></td>
                            </tr>
                            <tr>
                                <td style="padding: 3px 0px 20px 0;">
                                    <div style="font-size:11px;">One Hundred Thirty Eight Dollars and Eighty
                                        Cents Only</div>
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
                    <td width="40%" align="left" valign="top">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                                <tr class="odd">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Total Amount before Tax
                                    </td>
                                    <td height="35" width="110" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        192500.00
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Total Tax Amount
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        31740.00
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Discount &nbsp;&nbsp;
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        22,872.48
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Shipping Charge
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        -
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Total Amount After Tax
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        201367.52
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding-right:10px;">
                                        Round Off
                                    </td>
                                    <td height="35" align="right" style="border-bottom: solid 2px #fff; padding:0 10px;">
                                        (+) 0.48
                                    </td>
                                </tr>
                                <tr bgcolor="#{{$company->color}}">
                                    <td height="38" align="right" style="font-size: 18px; color: #fff; padding-right:10px; border-bottom: solid 2px #fff;">
                                        <strong>Total</strong>
                                    </td>
                                    <td height="38" align="right" style="padding:6px 10px; font-size: 18px; color: #fff; border-bottom: solid 2px #fff;">
                                        <strong>201,368.00</strong>
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
                        <strong>For, WebPlanex Infotech Pvt. Ltd</strong></td>
                </tr>
                <tr>
                    <td align="right">
                        <img src="{{url('assets/images/pdf_img/signature.png')}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
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