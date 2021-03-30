<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
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
                                        <tr>
                                            <td align="left" style="padding-top:15px;">
                                                <img src="{{url('assets/images/pdf_img/logo_1510567062.png')}}" alt="Webplanex" width="auto" height="100" style="vertical-align:top;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0px;">
                                                <strong style="font-size: 12px; color:#{{$company->color}};">WebPlanex Infotech Pvt. Ltd</strong>
                                            </td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                    </table>
                                </td>
                                <td width="436" align="right" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="30" align="right" valign="top"
                                                style="font-size:36px; text-transform: uppercase; color:#373b46; padding-top:15px;">
                                                Tax Invoice
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
                                                                        <strong>Invoice Date&nbsp;&nbsp;</strong>27-03-2021</td>
                                                                    <td align="center" style="font-size:18px; padding:12px 2px; color:#fff;">|</td>
                                                                    <td align="center" style="font-size:14px; padding:12px; color:#fff;">
                                                                        <strong>Invoice No&nbsp;&nbsp;</strong>12345
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
                                                            Aryan H
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" style="font-size:12px; padding-bottom: 5px;">
                                                            Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" style="font-size:12px; padding-bottom: 5px;">Phone:
                                                            4455661122
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="50%" align="right" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="left" valign="middle"
                                                style="font-size:18px; padding-right:20px; vertical-align: middle;">
                                                <strong>Shipping Information</strong></td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                                    <tr>
                                                        <td align="right" style="font-size:13px; font-weight:bold; padding-bottom: 5px;">
                                                            Aryan H
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" style="font-size:12px; padding-bottom: 5px;">
                                                            Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" style="font-size:12px; padding-bottom: 5px;">Phone:
                                                            4455661122
                                                        </td>
                                                    </tr>
                                                </table>
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
                    <td style="padding:15px 0px; font-size:13px;" valign="middle" align="left">
                        <strong>Payment Method: </strong>
                        Cash
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@php $total_quanity = 0; @endphp
<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 15px; background-color:#f2f2f2;">
    <tr>
        <td width="38px" valign="middle" align="center" style="background-color:#{{$company->color}}; color: #fff; font-size:13px; font-weight:400; padding:12px 10px; border-left: solid 1px #b7b7b7;"><strong>#</strong></td>
        <td width="240px" valign="middle" align="center" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>ITEM - SKU</strong></td>
        <td width="45px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>Qty</strong></td>
        <td width="120px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="100px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="50px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>HSN</strong></td>
        <td width="40px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>GST <br> <span style="font-family: DejaVu Sans; sans-serif;">(%)</span></strong></td>
        <td width="80px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="80px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
        <td width="100px" align="center" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
        <td width="100px" align="right" valign="middle" style="background-color:#{{$company->color}};color: #fff; font-size:13px; font-weight:400; padding:0 10px; border-right:1px solid #b7b7b7;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
    </tr>
    <tr>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">1</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="left" valign="top">One Plus 7T - 20208597T</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="rate-input">34,500.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="taxable-input">34,500.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">ONE7T</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">28</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">4,830.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">4,830.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">0.00</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="right" valign="top"><span class="amount-input">44,160.00</span></td>
    </tr>
    <tr>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">2</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="left" valign="top">Samsung A50 - A502020</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="rate-input">19,500.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="taxable-input">19,500.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">SAMA50</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">18</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">1,755.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">1,755.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">(10) 1,950.00</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="right" valign="top"><span class="amount-input">24,960.00</span></td>
    </tr>
    <tr>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">3</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="left" valign="top">Samsung Note 10+ - NOTE2019</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="rate-input">74,500.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="taxable-input">74,500.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">NOTE10</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">12</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">4,470.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">4,470.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">0.00</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="right" valign="top"><span class="amount-input">83,440.00</span></td>
    </tr>
    <tr>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">4</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="left" valign="top">Oppo Find X - FINDX</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="quantity-input">1</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="rate-input">64,000.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top"><span class="taxable-input">64,000.00</span></td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">FINDX</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="center" valign="top">12</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">3,840.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">3,840.00</td>
        <td width="40px" align="center" valign="top" style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;">0.00</td>
        <td style="border: solid 1px #b7b7b7; font-size:12px; padding:5px 10px; line-height: 20px;" align="right" valign="top"><span class="amount-input">71,680.00</span></td>
    </tr>
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
                                <strong>{{ $invoice_label['total_amount_in_word'] }}</strong></td>
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
                                    <strong>192500.00</strong>
                                </td>
                            </tr>
                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Total Tax Amount </strong>
                                </td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>31740.00</strong>
                                </td>
                            </tr>
                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Discount&nbsp;&nbsp;  </strong>
                                </td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>22,872.48</strong>
                                </td>
                            </tr>
                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Shipping Charge</strong></td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>-</strong>
                                </td>
                            </tr>

                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Total Amount After Tax</strong>
                                </td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>201367.52</strong>
                                </td>
                            </tr>
                            <tr>
                                <td height="24" width="60%" align="right" style="white-space: nowrap;font-size:12px;">
                                    <strong>Round Off</strong></td>
                                <td height="24" width="40%" align="right" style="text-align: right;padding:0 5px; font-size:12px;">
                                    <strong>(+) 0.48</strong>
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
            <strong>201,368.00</strong>
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
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada elit id euismod elementum
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
                        1234567890
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
                        info@webplanex.com
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
                        311-c, 3rd Floor, Iscon Mall, 150ft Ring Road, Rajkot-360005, Gujarat, India
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
            <img src="{{url('assets/images/pdf_img/paid_imag.png')}}" alt="" width="150" height="70" />
        </td>
        <td height="72" valign="middle" align="right" valign="top" style="padding:10px 0; margin:0 10px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td width="43%" align="right" valign="top" style="padding-bottom: 10px;">
                        <strong>For, WebPlanex Infotech Pvt. Ltd</strong>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <img src="{{url('assets/images/pdf_img/signature.png')}}" alt="" width="auto" height="40"style="max-height:40px;" />&nbsp;&nbsp;&nbsp;
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