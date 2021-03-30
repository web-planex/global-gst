<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <style>
        table {
            border-collapse: collapse !important;
            color: #1d1d1d;
            font-size: 14px;
        }

        table.td-gray td {
            border: solid 1px #444444;
            font-size: 14px;
        }

        @page {
            footer: myFooter1;
            font-size: 14px;
        }
    </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; margin:0; padding:0; font-weight:normal;font-size: 14px;">
    <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" width="28%"
                                        style="border-top:solid 1px #444444;border-left:solid 1px #444444;line-height:40px; {{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">
                                        <h3 style="font-size: 20px !important;">&nbsp;&nbsp;Tax Invoice
                                        </h3>
                                    </td>
                                    <td align="center" width="44%" style="border-top:solid 1px #444444;line-height:40px; padding: 30px 0px 10px;">
                                        <img src="{{url('assets/images/pdf_img/logo_1510567062.png')}}" alt="" width="auto" height="100" style="vertical-align: middle; margin-bottom: 10px;">
                                    </td>
                                    <td width="28%"style="border-top:solid 1px #444444;border-right:solid 1px #444444;line-height:40px;">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border-left:solid 1px #444444;border-right:solid 1px #444444;line-height:25px; padding-bottom: 30px;"align="center">
                                        <strong style="{{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">WebPlanex Infotech Pvt. Ltd</strong><br>
                                        311-c, 3rd Floor, Iscon Mall, 150ft Ring Road, Rajkot-360005, Gujarat, India
                                        <div>
                                            <img src="{{url('assets/images/pdf_img/phone-icon.png')}}" alt="" width="15px" height="15px" />&nbsp;&nbsp;1234567890&nbsp;&nbsp;
                                            <img src="{{url('assets/images/pdf_img/mail-icon.png')}}" alt="" width="15px" height="15px" />&nbsp;&nbsp;info@webplanex.com
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0" id="table-top">
                                <tr>
                                    <td align="left" width="50%"style="padding:5px 15px;border-left:solid 1px #444444;border-top:solid 1px #444444;">
                                        Invoice No: <strong>12345</strong>
                                    </td>
                                    <td align="left" width="50%" style="padding:5px 15px;border:solid 1px #444444;">
                                        <strong>Transport Mode: </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding:5px 15px;border-left:solid 1px #444444;border-top:solid 1px #444444;border-bottom:solid 1px #444444;">
                                        Invoice Date: <strong>27-03-2021</strong>
                                    </td>
                                    <td align="left" style="padding:5px 15px;border:solid 1px #444444;">
                                        <strong>Payment Method: </strong>Cash
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0" id="table-top2" width="100%">
                                <tr>
                                    <td align="center" colspan="2" style="border-left:solid 1px #444444; border-right:solid 1px #444444;padding:10px;line-height:30px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" width="50%" style="border-left:solid 1px #444444;border-right:solid 1px #444444;border-top:solid 1px #444444; padding:0 5px;line-height:30px;">
                                        <strong style="color: #{{$company->color}}">Billing Information</strong>
                                    </td>

                                    <td align="center" width="50%" style="border-left:solid 1px #444444;border-top:solid 1px #444444; border-right:solid 1px #444444;padding:0 5px;line-height:30px;">
                                        <strong style="color: #{{$company->color}}">Shipping Information</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="border:solid 1px #444444;padding:0 5px;line-height:30px; font-weight: bold;">
                                        &nbsp;&nbsp;Aryan H
                                    </td>

                                    <td align="left" style="border:solid 1px #444444;padding:0 5px;line-height:30px; font-weight: bold;">
                                        &nbsp;&nbsp;Aryan H
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" style="border:solid 1px #444444;padding:0 5px;line-height:30px;">
                                        &nbsp;&nbsp;Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                    </td>

                                    <td align="left" valign="top" style="border:solid 1px #444444;padding:0 5px;line-height:30px;">
                                        &nbsp;&nbsp;Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="border:solid 1px #444444;border-bottom:0px; padding:0 5px;line-height:30px;">
                                        &nbsp;&nbsp;Phone:4455661122
                                    </td>

                                    <td align="left"style="border:solid 1px #444444;border-bottom:0px; padding:0 5px;line-height:30px;">
                                        &nbsp;&nbsp;Phone:4455661122
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2" style="border-top:solid 1px #444444;border-left:solid 1px #444444; border-right:solid 1px #444444;padding:10px;line-height:30px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="td-gray" border="1" cellspacing="0" cellpadding="0" bordercolor="#444444" width="100%">
                                <tr>
                                    <td width="38px" valign="middle" align="center" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">#</strong></td>
                                    <td width="240px" valign="middle" align="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">ITEM - SKU</strong></td>
                                    <td width="45px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">Qty</strong></td>
                                    <td width="120px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                    <td width="100px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">TAXABLE ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                    <td width="50px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">HSN</strong></td>
                                    <td width="40px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">GST <br> <span style="font-family: DejaVu Sans; sans-serif;">(%)</span></strong></td>
                                    <td width="80px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                    <td width="80px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                    <td width="100px" align="center" valign="middle" style="padding:5px 15px;"><strong style="color: #{{ $company->color }}">CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
                                    <td width="100px" align="right" valign="middle" style="padding:5px 15px;">&nbsp;&nbsp;<strong style="color: #{{ $company->color }}">Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
                                </tr>

                                <tr>
                                    <td style="line-height:30px; " align="center" valign="top">1</td>
                                    <td style="padding:0 5px;line-height:30px; " align="left" valign="top">One Plus 7T - 20208597T</td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="quantity-input">1</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="rate-input">34,500.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="taxable-input">34,500.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top">ONE7T</td>
                                    <td style="line-height:30px; " align="center" valign="top">28</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">4,830.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">4,830.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">0.00</td>
                                    <td style="line-height:30px; " align="right" valign="top"><span class="amount-input">44,160.00</span></td>
                                </tr>

                                <tr>
                                    <td style="line-height:30px; " align="center" valign="top">2</td>
                                    <td style="padding:0 5px;line-height:30px; " align="left" valign="top">Samsung A50 - A502020</td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="quantity-input">1</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="rate-input">19,500.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="taxable-input">19,500.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top">SAMA50</td>
                                    <td style="line-height:30px; " align="center" valign="top">18</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">1,755.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">1,755.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">(10) 1,950.00</td>
                                    <td style="line-height:30px; " align="right" valign="top"><span class="amount-input">24,960.00</span></td>
                                </tr>

                                <tr>
                                    <td style="line-height:30px; " align="center" valign="top">3</td>
                                    <td style="padding:0 5px;line-height:30px; " align="left" valign="top">Samsung Note 10+ - NOTE2019</td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="quantity-input">1</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="rate-input">74,500.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="taxable-input">74,500.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top">NOTE10</td>
                                    <td style="line-height:30px; " align="center" valign="top">12</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">4,470.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">4,470.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">0.00</td>
                                    <td style="line-height:30px; " align="right" valign="top"><span class="amount-input">83,440.00</span></td>
                                </tr>

                                <tr>
                                    <td style="line-height:30px; " align="center" valign="top">4</td>
                                    <td style="padding:0 5px;line-height:30px; " align="left" valign="top">Oppo Find X - FINDX</td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="quantity-input">1</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="rate-input">64,000.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top"><span class="taxable-input">64,000.00</span></td>
                                    <td style="line-height:30px; " align="center" valign="top">FINDX</td>
                                    <td style="line-height:30px; " align="center" valign="top">12</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">3,840.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">3,840.00</td>
                                    <td width="40px" align="center" valign="top" style="padding:0 5px;line-height:30px;  text-transform: uppercase;">0.00</td>
                                    <td style="line-height:30px; " align="right" valign="top"><span class="amount-input">71,680.00</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="60%" align="left" valign="top"
                                        style="border-left:solid 1px #444444;border-right:solid 1px #444444; padding: 20px 0px;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td valign="top" style="padding: 10px;">
                                                    <strong>Terms and Conditions</strong><br />
                                                    <table style="margin-top: 5px;" cellpadding="0" cellspacing="0"
                                                           border="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada elit id euismod elementum.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td style="padding:10px;" valign="bottom">
                                                    <div style="font-weight: bold;">
                                                        {{ $invoice_label['total_amount_in_word'] }}
                                                    </div>
                                                    <table width="560px" border="0" cellspacing="0" cellpadding="0"
                                                        align="left" style="margin-top: 5px;">
                                                        <tr>
                                                            <td>
                                                                Thirty Eight Dollars and Eighty Cents Only</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td valign="top" style="padding:10px;">
                                                    <strong>Thank you for your business</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="left" valign="top" width="40%" style="border-right:solid 1px #444444;border-bottom:solid 0px #444444;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;font-size: 14px;">
                                                    &nbsp;&nbsp;Total Amount before Tax</td>
                                                <td align="right" width="103.5" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    192500.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;font-size: 14px;">
                                                    &nbsp;&nbsp;Total Tax Amount&nbsp;
                                                </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    31740.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;font-size: 14px;">
                                                    &nbsp;&nbsp;Discount &nbsp;&nbsp; &nbsp;&nbsp; </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;font-size: 14px;">
                                                    22,872.48
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;">
                                                    &nbsp;&nbsp;Shipping Charge
                                                </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    -
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;">
                                                    &nbsp;&nbsp;Total Amount After Tax
                                                </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    201367.52
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444;">
                                                    &nbsp;&nbsp;Round Off
                                                </td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444;">
                                                    (+) 0.48
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:5px;border-right:solid 1px #444444;border-bottom:solid 1px #444444; text-transform: uppercase; {{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">
                                                    &nbsp;&nbsp;<strong>Total</strong></td>
                                                <td align="right" style="padding:5px;border-bottom:solid 1px #444444; {{ isset($company->color) ? 'color: #'.$company->color.';' : '' }}">
                                                    <strong>201,368.00</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <td align="left" style="border-top:solid 1px #444444;border-left:solid 1px #444444;border-bottom: solid 1px #444444;line-height:25px;">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <img src="{{url('assets/images/pdf_img/paid_imag.png')}}" alt="" width="150" height="70" />
                                    </td>
                                    <td align="right" style="padding:30px 10px 20px;border-top:solid 1px #444444;border-bottom: solid 1px #444444;border-right:solid 1px #444444;line-height:25px;">
                                        <strong>For, WebPlanex Infotech Pvt. Ltd</strong>&nbsp;&nbsp;<br />
                                        <img src="{{url('assets/images/pdf_img/signature.png')}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
                                        Authorize Signature&nbsp;&nbsp;
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>