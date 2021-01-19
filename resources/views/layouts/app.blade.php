<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>GST Invoice India</title>
    <link href="{{ asset('assets/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <link href="{{ asset('assets/dist/css/pages/float-chart.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/prism/prism.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/select2/dist/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/jquery.magnify.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--Validation Jquery File-->
    <script src="{{ asset('assets/dist/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jquery.magnify.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
    <style>
        .error{color: #ff0000;}
    </style>
</head>
<body class="skin-megna fixed-layout skin-default-dark">
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">GST Invoice India</p>
    </div>
</div>
<div id="main-wrapper">
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0);">
                    <b>
                        <img src="{{ asset('assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                    </b>
                    <span class="hidden-xs text-white"><span class="font-bold">GST</span> Invoices</span>
                </a>
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark"
                                             href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    <li class="nav-item"> <a
                            class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                            href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                </ul>

                <div class="dropdown u-pro mr-5">
                    <select class="form-control amounts-are-select2" name="company" id="company_list">
                        <option value="0">Select Company</option>
                        @foreach(\App\Http\Controllers\Controller::AllCompanies() as $com)
                            <option value="{{$com['id']}}" @if(\App\Http\Controllers\Controller::SetCompany() && \App\Http\Controllers\Controller::SetCompany()==$com['id']) selected @endif >{{$com['company_name']}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="dropdown u-pro mr-3">
                    <span class="dropdown-toggle text-white" style="cursor: pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="hidden-md-down">{{\App\Http\Controllers\Controller::AuthUser()->name}} &nbsp;<i class="fa fa-angle-down"></i></span>
                    </span>
                    <div class="dropdown-menu dropdown-menu-header animated flipInY" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{url('edit-profile/'.\App\Http\Controllers\Controller::AuthUser()->id)}}"><i class="ti-user pr-2"></i>My Profile</a>
                        <a class="dropdown-item" href="{{url('companies')}}"><i class="fa fa-building pr-2"></i>My Companies</a>
                        <a class="dropdown-item" href="{{url('change-password/'.\App\Http\Controllers\Controller::AuthUser()->id)}}"><i class="ti-settings pr-2"></i>Change Password</a>
                        <a class="dropdown-item" href="{{url('logout')}}"><i class="fa fa-power-off pr-2"></i>Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="@if(isset($menu) && $menu == 'Dashboard') active @endif">
                        <a class="waves-effect waves-dark" href="{{ url('dashboard')}}"><i class="fa fa-home"></i><span class="hide-menu">Dashboard</span></a>
                    </li>

                    <li class="@if(isset($menu) && $menu == 'Products') active @endif">
                        <a class="waves-effect waves-dark" href="{{ url('products')}}"><i class="fab fa-product-hunt"></i><span class="hide-menu">Products / Services</span></a>
                    </li>

                    <li class="@if(isset($menu) && ($menu == 'Expense' || $menu == 'Bill')) active @endif">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-bag"></i>
                            <span class="hide-menu">Purchases</span>
                        </a>
                        <ul aria-expanded="false" class="collapse @if(isset($menu) && ($menu == 'Expense' || $menu == 'Bill')) in @endif">
                            <li class=""><a href="{{route('expense')}}" class="@if(isset($menu) && $menu == 'Expense' ) active @endif">Expenses</a></li>
                            <li class=""><a href="{{route('bills.index')}}" class="@if(isset($menu) && $menu == 'Bill' ) active @endif">Bills</a></li>
                        </ul>
                    </li>

                    <li class="@if(isset($menu) && $menu == 'Sales Orders' || isset($menu) && $menu == 'Credit Notes' || isset($menu) && $menu == 'Estimate') active @endif">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-shopping-cart"></i>
                            <span class="hide-menu">Sales</span>
                        </a>
                        <ul aria-expanded="false" class="collapse @if(isset($menu) && $menu == 'Sales Orders' || isset($menu) && $menu == 'Credit Notes' || isset($menu) && $menu == 'Estimate') in @endif">
                            <li><a href="{{ url('sales')}}" class="@if(isset($menu) && $menu == 'Sales Orders' ) active @endif">Sales Orders</a></li>
                            <li><a href="{{url('credit-note')}}" class="@if(isset($menu) && $menu == 'Credit Notes' ) active @endif">Credit Notes</a></li>
                            <li><a href="{{url('estimate')}}" class="@if(isset($menu) && $menu == 'Estimate' ) active @endif">Estimate</a></li>
                        </ul>
                    </li>

                    <li class="@if(isset($menu) && $menu == 'Company Setting' || isset($menu) && $menu == 'Payment Terms' || isset($menu) && $menu == 'Payment Methods') active @endif">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i>
                            <span class="hide-menu">Settings</span>
                        </a>
                        <ul aria-expanded="false" class="collapse @if(isset($menu) && $menu == 'Company Setting' || isset($menu) && $menu == 'Payment Terms' || isset($menu) && $menu == 'Payment Methods') in @endif">
                            <li><a href="{{url('company-setting')}}" class="@if(isset($menu) && $menu == 'Company Setting' ) active @endif">Company Settings</a></li>
                            <li><a href="{{url('payment-terms')}}" class="@if(isset($menu) && $menu == 'Payment Terms' ) active @endif">Payment Terms</a></li>
                            <li><a href="{{url('payment-methods')}}" class="@if(isset($menu) && $menu == 'Payment Methods' ) active @endif">Payment Methods</a></li>
                        </ul>
                    </li>

                    <li class="@if(isset($menu) && $menu == 'Payees') active @endif">
                        <a class="waves-effect waves-dark" href="{{ url('payees')}}"><i class="fa fa-user-plus"></i>
                            <span class="hide-menu">Payees / Vendors</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-files"></i>
                        <span class="hide-menu">Report Builder</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li class=""> <a href="javascript:;">Export Report</a></li>
                            <li class=""> <a href="javascript:;">Report Templates</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="page-wrapper">
        <div class="container-fluid">
            @yield('content')
{{--            <div class="row">--}}
{{--                <div class="col-12 text-center">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-body other-useful">--}}
{{--                            <h2><strong>Other Useful Applications from Webplanex Team</strong></h2>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="other-useful-box">--}}
{{--                                        <a href="https://apps.shopify.com/cashback-sale-booster" data-toggle="tooltip" title="Cashback Rewards Program" target="_blanck">--}}
{{--                                            <img src="{{ asset('assets/images/banner.jpg') }}" alt="" class="img-fluid">--}}
{{--                                        </a>--}}
{{--                                        <a href="https://apps.shopify.com/social-card" data-toggle="tooltip" title="Social Card" target="_blanck">--}}
{{--                                            <img src="{{ asset('assets/images/banner-social-card.jpg') }}" alt="" class="img-fluid">--}}
{{--                                        </a>--}}
{{--                                        <a href="https://apps.shopify.com/mobidesign-android-app-builder" data-toggle="tooltip" title="Webplanex Native App Builder" target="_blanck">--}}
{{--                                            <img src="{{ asset('assets/images/banner-native-appbuilder.jpg') }}" alt="" class="img-fluid">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
    <footer class="footer text-center">
        © {{date('Y')}} WebPlanex. All Rights Reserved.
    </footer>
</div>
<script src="{{ asset('assets/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/waves.js') }}"></script>
<script src="{{ asset('assets/dist/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/moment/moment.js') }}"></script>
<script src="{{ asset('assets/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/prism/prism.js') }}"></script>
<script src="{{ asset('assets/switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('assets/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/sweetalert2/sweet-alert.init.js') }}"></script>
<script src="{{ asset('assets/select2/dist/select2.js')}}"></script>
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
        $('.amounts-are-select2').select2();
        $('.discount-level-select2').select2({
            minimumResultsForSearch: -1
        });
    });
</script>
<script>
    $('#start_date_orderlist, #end_date_orderlist').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false });
    $('#start_date, #end_date, #hire_date, #released, #date_of_birth, #as_of, #expense_date, #invoice_date, #due_date,#estimate_date, #expiry_date, #bill_date, #payment_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false});
    $('.payment_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false});
    $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
    $('#date-format').bootstrapMaterialDatePicker({ format: 'DD MMMM YYYY' });
    $('#min-date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', minDate: new Date() });

    $('#due_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart : 0, time: false });
    $('#bill_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart : 0, time: false }).on('change', function(e, date) {
        $('#due_date').bootstrapMaterialDatePicker('setMinDate', date);
    });
</script>
<script>
    $(function () {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });
    });
</script>
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

    $('#company_list').change(function(){
       var cid = $(this).val();
       if(cid>0){
           $.ajax({
               url: '{{url('ajax/set_company')}}',
               type: 'POST',
               data:  {'data':cid},
               success: function (result) {
                    window.location.href = '{{url('/dashboard')}}';
               }
           });
       }
    });
</script>
</body>
</html>
