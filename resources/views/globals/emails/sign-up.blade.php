<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>{{env('PROJECT_TITLE')}}</title>
    <style>
        @media(max-width:600px){
            .text-body {
                width:100% !important;
            }
        }
        a, a:visited {
            color: #1575bf;
        }
    </style>
</head>
<body bgcolor="#E9E9E9" style="margin:0; padding:0; font-family:Arial, Helvetica, sans-serif;font-size:12px; color:#7e7e7e;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#E9E9E9">
    <tr>
        <td>
            <table class="text-body" width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="width:600px;">
                <!--Email header start-->
                <tr>
                    <td height="80" align="left" valign="middle" bgcolor="#FFFFFF" style="border-bottom: solid #3f4eae 5px; padding: 0px 10px;">
                        <img src="{{$company_logo}}" alt="" width="auto" height="70" style="max-height:70px;"/>
                    </td>
                </tr>
                <!--Email header end-->

                <!--Email body start-->
                <tr>
                    <td align="center" valign="top" bgcolor="#FFFFFF">
                        <table width="94%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="50%" align="left">
                                    <h1 style="margin-bottom: 20px; color: #07085B;">
                                        Hi, {{$customer_name}}
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size: 14px; line-height:20px;">
                                    <h2>Thanks for checking out GST WebPlanex,</h2>
                                    <p style="font-family: manrope, sans-serif">
                                        We hope our products can make your morning routine a little more enjoyable.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" height="20">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!--Email body end-->
                <!--Email footer Start-->
                <tr>
                    <td align="center" height="50" bgcolor="#888888" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif;">
                        <p style="font-size: 13px;">
                            &copy; by GST Webplanex, Powered by: 
                            <a href="https://www.webplanex.com/" style="color:#6037E9;">webplanex.com</a>
                        </p>
                    </td>
                </tr>
                <!--Email footer end-->
            </table>
        </td>
    </tr>
</table>
</body>
</html>