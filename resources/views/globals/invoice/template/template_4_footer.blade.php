@php
    $company = \App\Models\Globals\CompanySettings::where('id',Session::get('company'))->first();
@endphp
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

<body>
<div style="font-family:Arial, Helvetica, sans-serif; margin-left: -8px;margin-right: -8px;">

    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="5%"></td>
            <td align="right" width="90%" style="padding-top:10px;font-size:12px; Color:#5e5e5e;">
                Generated from: www.webplanex.com &nbsp;&nbsp;&nbsp;&nbsp; Page
                <span id="pdfkit_page_current"></span> Of <span id="pdfkit_page_count"></span>
            </td>
            <td width="5%"></td>
        </tr>
    </table>

</div>

<script>
    getPdfInfo();
</script>
</body>

</html>