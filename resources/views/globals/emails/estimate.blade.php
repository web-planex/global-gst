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
                                @if(!empty($company_logo))
                                <img src="{{url($company_logo)}}" alt="" width="auto" height="50" style="max-height:50px;"/>
                                @else
                                <h2>{{$company_name}}</h2>
                                @endif
                            </td>
                        </tr>
                        <!--Email header end-->

                        <!--Email body start-->
                        <tr>
                            <td align="center" valign="top" bgcolor="#FFFFFF">
                                <table width="94%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="50%" align="left">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px;">
                                            {!! $email_content !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px;">
                                            <a style="display:inline-block;background-color: #3f4eae; color: #ffffff; border-left:20px solid #3f4eae; border-right:20px solid #3f4eae; border-top:10px solid #3f4eae; border-bottom:10px solid #3f4eae; text-decoration:none;" href="{{route('estimate-download_pdf',['id'=>$estimate_id,'output'=>'download'])}}" target="_blank">
                                                Download Estimate
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" height="20">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px;">
                                            
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
                                <p>&copy; by {{$company_name}}, Powered by: <a href="https://www.webplanex.com/" style="color:#ffffff;">webplanex.com</a></p>
                            </td>
                        </tr>
                        <!--Email footer end-->
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>



















