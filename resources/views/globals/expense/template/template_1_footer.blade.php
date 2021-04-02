<!DOCTYPE HTML>
<html style="padding:0px; margin:0px;">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" charset="UTF-8" />
        <script>
            var pdfInfo = {};
            var x = document.location.search.substring(1).split('&');
            for (var i in x) { var z = x[i].split('=',2); pdfInfo[z[0]] = unescape(z[1]); }
            function getPdfInfo() {
                var page = pdfInfo.page || 1;
                var pageCount = pdfInfo.topage || 1;
                document.getElementById('pdfkit_page_current').textContent = page;
                document.getElementById('pdfkit_page_count').textContent = pageCount;
            }
        </script>
    </head>
    <body style="font-family:Arial, Helvetica, sans-serif; font-size:14px; margin:0; padding:0; font-weight:normal; line-height:20px;">
        <div style="margin-left: -7px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: -3px;">
                <tr>
                    <td width="4%" style="height:60px; border-left:solid 20px #{{$color}};"></td>
                    <td width="91%" style="height:60px; border-bottom:solid 5px #{{$color}};"></td>
                    <td width="5%" style="height:60px;"></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td width="4%" style="padding-top:10px; border-left:solid 20px #{{$color}};"></td>
                    <td align="left" width="46%" style="padding-top:10px;font-size: 14px;">
                        Thank you for your business
                    </td>
                    <td align="right" width="45%" style="padding-top:10px;font-size:12px; Color:#5e5e5e;">
                        Generated from: www.webplanex.com &nbsp;&nbsp;&nbsp;&nbsp; Page
                        <span id="pdfkit_page_current"></span> Of <span id="pdfkit_page_count"></span>
                    </td>
                    <td width="5%"></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td width="49%" style="padding-bottom:25px; border-left:solid 20px #{{$color}}; border-bottom:solid 18px #{{$color}};"></td>
                    <td width="51%" style="padding-bottom:25px;"></td>
                </tr>
            </table>
        </div>
        <script>
            getPdfInfo();
        </script>
    </body>
</html>
