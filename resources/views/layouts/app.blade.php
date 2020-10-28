<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    {{-- <title>{// config('app.name', 'GST Invoice India') }}</title> --}}
    <title>GST Invoice India</title>

    <link href="{{ asset('assets/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <!--  //Z:\\HTML-25-04-2020\gst\export-report.html -->
    <link href="{{ asset('assets/dist/css/pages/float-chart.css') }}" rel="stylesheet">
    <!-- style.min CSS -->
    <link href="{{ asset('assets/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/dist/css/custom.css') }}" rel="stylesheet">
    <!--  // Z:\\HTML-25-04-2020\gst\invoice-setting.html -->
    <link href="{{ asset('assets/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <!-- Prism CSS -->
    <link href="{{ asset('assets/prism/prism.css') }}" rel="stylesheet">
    <!--alerts CSS -->
    <!-- //Z:\\HTML-25-04-2020\gst\report-templates.html -->
    <link href="{{ asset('assets/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

    {{--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <script src="{{ asset('assets/jquery/jquery-3.2.1.min.js') }}"></script>

    <!-- Chat Module CSS Start -->
    <style type="text/css">
        #sb-chatboard-iframe{
            border: none;
            height: 35px;
            width: 175px;
            position: fixed;
            bottom: 0;
            right: 10px;
            z-index: 9999;
        }
    </style>
    <!-- Chat Module CSS End -->

    <!--  else -->
    <!-- <script>(function(d,t,u,s,e){e=d.getElementsByTagName(t)[0];s=d.createElement(t);s.src=u;s.async=1;e.parentNode.insertBefore(s,e);})(document,'script','//webplanex.com/gst-livechat/php/app.php?widget-init.js');</script> -->
    <!--  endif -->

    <!-- <script type="text/javascript" lang="javascript">
      if(self==top){
          //alert('Not IFrame');
          var url      = window.location.href;
          var result = url.split('shop=');
          var shop_domain = result[1];
          var redirect_uri = url.replace('https://gst.webplanex.biz/','');
          top.location.href = 'https://' + shop_domain + '/admin/apps/gst-invoice-india/' + redirect_uri;
      }
      else
      {
          //alert('In IFrame');
      }
      </script> -->
</head>

<body class="skin-megna fixed-layout skin-default-dark">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">GST Invoice India</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0);">
                    <!-- Logo icon --><b>
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" /> -->
                        <!-- Light Logo icon -->
                        <img src="{{ asset('assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                    </b>
                    <!--End Logo icon -->
                    <span class="hidden-xs text-white"><span class="font-bold">GST</span> Invoices</span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto">
                    <!-- This is  -->
                    <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark"
                                             href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    <li class="nav-item"> <a
                            class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                            href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                </ul>
                <ul class="navbar-nav my-lg-0" style="margin-right:20px;">

                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">

                    <li class="@if(Route::currentRouteName() == 'expense' ) active @endif">
                        <a class="waves-effect waves-dark" href="{{ url('expense')}}"><i class="ti-pencil-alt"></i><span class="hide-menu">Expense</span></a>
                    </li>
                    <li class="@if($menu == 'payment-account' ) active @endif">
                        <a class="waves-effect waves-dark" href="{{route('payment-account')}}"><i class="ti-wallet"></i><span class="hide-menu">Payment Account</span></a>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

        @yield('content')

        <!-- Begin Other Useful -->
            <div class="row">
                <div class="col-12 text-center">
                    <div class="card">
                        <div class="card-body other-useful">
                            <h2><strong>Other Useful Applications from Webplanex Team</strong></h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="other-useful-box">
                                        <a href="https://apps.shopify.com/cashback-sale-booster" data-toggle="tooltip" title="Cashback Rewards Program" target="_blanck">
                                            <img src="{{ asset('assets/images/banner.jpg') }}" alt="" class="img-fluid">
                                        </a>
                                        <a href="https://apps.shopify.com/social-card" data-toggle="tooltip" title="Social Card" target="_blanck">
                                            <img src="{{ asset('assets/images/banner-social-card.jpg') }}" alt="" class="img-fluid">
                                        </a>
                                        <a href="https://apps.shopify.com/mobidesign-android-app-builder" data-toggle="tooltip" title="Webplanex Native App Builder" target="_blanck">
                                            <img src="{{ asset('assets/images/banner-native-appbuilder.jpg') }}" alt="" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Other Useful -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>

    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
        © 2020 WebPlanex. All Rights Reserved.
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('assets/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('assets/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('assets/dist/js/sidebarmenu.js') }}"></script>
<!--stickey kit -->
<script src="{{ asset('assets/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/sparkline/jquery.sparkline.min.js') }}"></script>

<!--Custom JavaScript -->
<script src="{{ asset('assets/dist/js/custom.min.js') }}"></script>

<!--  // Z:\\HTML-25-04-2020\gst\export-report.html -->
<!-- Plugin JavaScript -->
<script src="{{ asset('assets/moment/moment.js') }}"></script>
<script src="{{ asset('assets/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<!-- This is data table -->
<script src="{{ asset('assets/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
<!-- This is tinymce min -->
<!--   // Z:\\HTML-25-04-2020\gst\email-template.html -->
<script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
<!-- Flot Charts JavaScript -->
<!--  //Z:\\HTML-25-04-2020\gst\invoice-setting.html -->
<script src="{{ asset('assets/prism/prism.js') }}"></script>
<script src="{{ asset('assets/switchery/dist/switchery.min.js') }}"></script>
<!--  //Z:\\HTML-25-04-2020\gst\report-templates.html -->
<!-- Sweet-Alert  -->
<script src="{{ asset('assets/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/sweetalert2/sweet-alert.init.js') }}"></script>
<!-- //Z:\\HTML-25-04-2020\gst\email-template.html -->
<script>
    $(document).ready(function() {

        if ($("#message_body").length > 0) {
            tinymce.init({
                selector: "textarea#message_body",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });
</script>

<!-- //Z:\\HTML-25-04-2020\gst\export-report.html  -->
<script>
    $('#start_date_orderlist, #end_date_orderlist').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false });
    $('#start_date, #end_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false });
    $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
    $('#date-format').bootstrapMaterialDatePicker({ format: 'DD MMMM YYYY' });
    $('#min-date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', minDate: new Date() });
</script>

<!-- //Z:\\HTML-25-04-2020\gst\invoice-setting.html
   Z:\\HTML-25-04-2020\gst\shipping-setting.html -->
<script>
    $(function () {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });
    });
</script>

<!-- // Z:\\HTML-25-04-2020\gst\orders.html -->
<script>
    $(function () {
        $('#myTable, #myTable2, #myTable3').DataTable();
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
        // responsive table
        $('#config-table').DataTable({
            responsive: true
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

    });

</script>

<!-- Remove loading -->
<script type="text/javascript">
    /*
     var url      = window.location.href;
     var result = url.split('shop=');
     var shop_domain = result[1];
     if (shop_domain.indexOf('&') > -1)
     {
       var shop_domain1 = shop_domain.split('&');
       shop_domain = shop_domain1[0];
     }
     shop_domain = 'https://' + shop_domain;
     ShopifyApp.init({
       apiKey: 'env("SHOPIFY_KEY")}}',
       shopOrigin: shop_domain
     });

    $('.navbar-nav li').on('click', function(){
         if($(this).data('name') != 'gst-hsn' && $(this).data('name') !='report-builder'){
             ShopifyApp.Bar.loadingOn();
         }
     });

     ShopifyApp.ready(function(){
         ShopifyApp.Bar.loadingOff();
     });


      $(document).ready(function(){
         //Switchery
         var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
         $('.js-switch').each(function() {
             new Switchery($(this)[0], $(this).data());
         });

         $('[data-toggle="tooltip"]').tooltip()
     }); */

</script>
</body>

</html>
