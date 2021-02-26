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
        p{
            font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
        }
    </style>
</head>
<body bgcolor="#EDF2F7" style="margin:0; padding:0; font-family:Arial, Helvetica, sans-serif;font-size:12px; color:#7e7e7e;">
<div style="background-color:#ffffff;color:#718096;height:100%;line-height:1.4;margin:0;padding:0;width:100%!important">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#edf2f7;margin:0;padding:0;width:100%">
        <tbody>
        <tr>
            <td align="center" style="">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:0;padding:0;width:100%">
                    <tbody>
                    <tr>
                        <td style="padding:25px 0;text-align:center">
                            <a href="{{route('home-page')}}" target="_blank">
                                <img src="{{$company_logo}}" alt="Company Logo" width="auto" height="50" style="max-height:50px;"/>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" cellpadding="0" cellspacing="0" style="background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:570px">
                                <tbody>
                                <tr>
                                    <td style="max-width:100vw;padding:32px">
                                        <h1 style="color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">Hello {{$customer_name}}!</h1>
                                        <p style="font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            Please click the button below to verify your email address.
                                        </p>
                                        <p style="font-size:16px;line-height:1.5em;margin-top:0;text-align:center">
                                            <a href="https://gst.webplanex.com/verified-email?token={{$token}}" rel="noopener" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#2d3748;font-size:15px;border-bottom:10px solid #2d3748;border-left:36px solid #2d3748;border-right:36px solid #2d3748;border-top:10px solid #2d3748" target="_blank" data-saferedirecturl="https://gst.webplanex.com/verified-email?token={{$token}}">Verify Email Address</a>
                                        </p>
                                        <p style="font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            <span style="word-break: break-all; color: #1575bf;"><strong style="color: #000000;">Or verify using link :</strong> <a href="https://gst.webplanex.com/verified-email?token={{$token}}" target="_blank">https://gst.webplanex.com/verified-email?token={{$token}}</a></span>
                                        </p>
                                        <p style="font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            If you did not create an account, no further action is required.
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="margin:0 auto;padding:0;text-align:center;width:570px">
                                <tbody>
                                <tr>
                                    <td align="center" style="max-width:100vw;padding:32px">
                                        <p style="font-size: 13px;">
                                            © {{date('Y')}} WebPlanex Infotech PVT LTD. All rights reserved.
                                        </p>
                                        <p style="font-size: 13px;">
                                            311- C, Iscon mall, 150 feet ring road, Rajkot – 360005 , Gujarat India
                                        </p>
                                        <p>Phone : +91-281-2331006, +91-9724382401</p>
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
        </tbody>
    </table>
</div>
</body>
</html>