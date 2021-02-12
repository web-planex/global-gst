<!DOCTYPE HTML>
<html style="padding:0px; margin:0px;">
    <head>
        <script>
            var pdfInfo = {};
            var x = document.location.search.substring(1).split('&');
            for (var i in x) {
                var z = x[i].split('=', 2);
                pdfInfo[z[0]] = unescape(z[1]);
            }
            function getPdfInfo() {
                var page = pdfInfo.page || 1;
                var pageCount = pdfInfo.topage || 1;
                document.getElementById('pdfkit_page_current').textContent = page;
                document.getElementById('pdfkit_page_count').textContent = pageCount;
            }
        </script>
    </head>
    <body>
        <div style="padding:0px 0 10px 0px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td align="left" style="font-size: 10px;"><strong>Thank you for your business </strong></td>
                    <td align="right" style="font-size:10px; Color:#5e5e5e;">Generated from: <a href="https://gst.webplanex.com">www.webplanex.com</a>&nbsp;&nbsp;&nbsp;&nbsp;Page <span id="pdfkit_page_current"></span> of <span id="pdfkit_page_count"></span></td>
                </tr>
            </table>
        </div>
        <script>
            getPdfInfo();
        </script>
    </body>
</html>