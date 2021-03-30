<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
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
                                                <img src="{{url('assets/images/pdf_img/logo_1510567062.png')}}" alt="" width="auto" height="auto" style="max-height:50px; margin-bottom: 10px;" />
                                                <br />
                                                <strong style="font-size: 12px; color:#{{$company->color}};">WebPlanex Infotech Pvt. Ltd</strong>
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
                                                                        Aryan H
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="50" align="left" valign="top" style="padding-bottom: 5px; font-size:10px;"><strong>Address: </strong></td>
                                                                    <td style="font-size:10px; padding-bottom: 5px;">
                                                                        Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-bottom: 5px; font-size:10px;"><strong>Phone:</strong></td>
                                                                    <td style="font-size:10px; padding-bottom: 5px;">4455661122</td>
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
                                                <strong>Tax Invoice</strong>
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
                                                                    <td style="font-size:14px; padding:10px 10px 0 10px; color:#fff;">Invoice Date</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" style="font-size:14px; font-weight: normal; text-transform: uppercase; color:#383838; padding:5px 10px 10px 10px; color:#fff;">
                                                                        <strong>27-03-2021</strong>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="50%" style="border: solid 1px #{{$company->color}};">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td align="left" style="font-size:14px; padding:10px 10px 0 10px;">Invoice No.</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" style="font-size:14px; font-weight:normal; text-transform: uppercase; color:#383838; padding:5px 10px 10px 10px;">
                                                                        <strong>12345</strong>
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
                                                    Aryan H
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top" style="font-size:10px;padding-bottom: 5px;">
                                                    <strong>Address:</strong></td>
                                                <td align="left" style="font-size:10px; padding-bottom: 5px;">
                                                    Panchvati Main Road, Rajkot-360005, Gujarat, india.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size:10px; padding-bottom: 5px;"><strong>Phone:</strong></td>
                                                <td align="left" style="font-size:10px; padding-bottom: 5px;">4455661122</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="20%"></td>

                                    <td width="40%" align="right" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
    {{--                                        <tr>--}}
    {{--                                            <td colspan="2" align="left" valign="middle" style="font-size:12px; font-weight:bold; padding-bottom: 5px;">{{ $invoice_label["shipping_method"] }}</td>--}}
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
                                                    Cash
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
            <td width="240px" valign="top" align="center" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>ITEM - SKU</strong></td>
            <td width="50px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>Qty</strong></td>
            <td width="105px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>RATE PER ITEM <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="105px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>TAXABLE ITEM  <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="50px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>HSN</strong></td>
            <td width="40px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>GST <br> (%)</strong></td>
            <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="80px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>SGST <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;"><strong>CESS <br> <span style="font-family: DejaVu Sans; sans-serif;">(%) (&#8377;)</span></strong></td>
            <td width="100px" align="center" valign="top" bgcolor="#{{$company->color}}" style="color: #ffffff; border-bottom: solid 1px #b7b7b7; padding:0 5px;line-height:30px; text-transform: uppercase;">&nbsp;&nbsp;<strong>Total <br> <span style="font-family: DejaVu Sans; sans-serif;">(&#8377;)</span></strong></td>
            <td width="5%"></td>
        </tr>

        <tr style="background-color:#e8e8e8">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">1</td>
            <td style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="left" valign="top">One Plus 7T - 20208597T </td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="rate-input">34,500.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="taxable-input">34,500.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">ONE7T</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">28</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">4,830.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">4,830.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">0.00</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="right" valign="top"><span class="amount-input">44,160.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
        <tr style="background-color:#f1f1f1">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">2</td>
            <td style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="left" valign="top">Samsung A50 - A502020 </td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="rate-input">19,500.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="taxable-input">19,500.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">SAMA50</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">18</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">1,755.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">1,755.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">(10) 1,950.00</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="right" valign="top"><span class="amount-input">24,960.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
        <tr style="background-color:#e8e8e8">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">3</td>
            <td style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="left" valign="top">Samsung Note 10+ - NOTE2019</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="rate-input">74,500.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="taxable-input">74,500.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">NOTE10</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">12</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">4,470.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">4,470.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">0.00</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="right" valign="top"><span class="amount-input">83,440.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
        <tr style="background-color:#f1f1f1">
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">4</td>
            <td style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="left" valign="top">Oppo Find X - FINDX</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="quantity-input">1</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="rate-input">64,000.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top"><span class="taxable-input">64,000.00</span></td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">FINDX</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="center" valign="top">12</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">3,840.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">3,840.00</td>
            <td width="40px" align="center" valign="top" style="padding:0 5px;padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7; text-transform: uppercase;">0.00</td>
            <td style="padding:0 5px;line-height:30px; border-bottom: solid 1px #b7b7b7;" align="right" valign="top"><span class="amount-input">71,680.00</span></td>
            <td style="width: 5%; background-color: #ffffff!important;">&nbsp;</td>
        </tr>
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
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam malesuada elit id euismod elementum
                                                        </p>
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                  <td valign="top" height="20"
                                                    style="padding:8px 0;font-size:11px; color:#{{$company->color}}; margin:0;">
                                                    <strong>{{ $invoice_label['total_amount_in_word'] }}</strong></td>
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
                                                        <img src="{{url('assets/images/pdf_img/paid_imag.png')}}" alt="" width="150" height="70" />
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
                                                        <strong>192500.00</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Total Tax Amount</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
                                                        <strong>31740.00</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Discount</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
                                                        <strong>22,872.48</strong>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Shipping Charge</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
                                                        -
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Total Amount After Tax</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
                                                        <strong>201367.52</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="24" align="right" style="font-size:12px;padding-right:10px;">
                                                        <strong>Round Off</strong>
                                                    </td>
                                                    <td height="24" align="right" style="font-size:12px;padding:0 5px;">
                                                        <strong>(+) 0.48</strong>
                                                    </td>
                                                </tr>
                                                <tr bgcolor="#{{$company->color}}">
                                                    <td height="30" align="right" style="font-size: 14px; color: #fff; padding-right:10px;">
                                                        <strong>Total</strong>
                                                    </td>
                                                    <td height="30" align="right" style="font-size:14px;padding:12px 6px; color: #fff;">
                                                        <strong>201,368.00</strong>
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
                                                        1234567890
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
                                                        info@webplanex.com
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
                                                        311-c, 3rd Floor, Iscon Mall, 150ft Ring Road, Rajkot-360005, Gujarat, India
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
                                        <strong>For, WebPlanex Infotech Pvt. Ltd</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <img src="{{url('assets/images/pdf_img/signature.png')}}" alt="" width="auto" height="40" style="max-height:40px;"/>&nbsp;&nbsp;&nbsp;<br>
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