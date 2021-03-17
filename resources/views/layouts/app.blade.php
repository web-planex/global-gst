<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{url('website/img/favicon.png')}}" type="image/x-icon">
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

    <!-- CSS FOR ROBOCROP IMAGES -->
    <link rel="stylesheet" href="{{ asset('assets/dist/robocrop/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/dist/robocrop/css/demo.css')}}">

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
                <a class="navbar-brand" href="{{url('/dashboard')}}">
                    <b>
                        <img id="logo-icon-small" src="{{ asset('assets/images/logo-light-icon-small.png') }}" style="width:50px" alt="homepage" class="light-logo big-small-logo-hide border-0">
                        <img id="logo-icon-big" src="{{ asset('assets/images/logo-light-icon.png') }}" width="200px" alt="homepage" class="light-logo border-0" />
                    </b>
                    <!--<span class="hidden-xs text-white"><span class="font-bold">GST</span> Invoices</span>-->
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

                <div class="fullscreen-icon">
                    <svg id="svg_fullscreen" width="18" data-toggle="tooltip" data-placement="top" data-original-title="Full Screen" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="expand" class="svg-inline--fa fa-expand fa-w-14 fullscreen-icon-expand" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#fff" d="M0 180V56c0-13.3 10.7-24 24-24h124c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H64v84c0 6.6-5.4 12-12 12H12c-6.6 0-12-5.4-12-12zM288 44v40c0 6.6 5.4 12 12 12h84v84c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12V56c0-13.3-10.7-24-24-24H300c-6.6 0-12 5.4-12 12zm148 276h-40c-6.6 0-12 5.4-12 12v84h-84c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h124c13.3 0 24-10.7 24-24V332c0-6.6-5.4-12-12-12zM160 468v-40c0-6.6-5.4-12-12-12H64v-84c0-6.6-5.4-12-12-12H12c-6.6 0-12 5.4-12 12v124c0 13.3 10.7 24 24 24h124c6.6 0 12-5.4 12-12z"></path></svg>
                    <svg id="svg_exit_fullscreen" style="display:none;" width="18" data-toggle="tooltip" data-placement="top" data-original-title="Exit Full Screen" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="compress" class="svg-inline--fa fa-compress fa-w-14 fullscreen-icon-compress" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#fff" d="M436 192H312c-13.3 0-24-10.7-24-24V44c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v84h84c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm-276-24V44c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v84H12c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h124c13.3 0 24-10.7 24-24zm0 300V344c0-13.3-10.7-24-24-24H12c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h84v84c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-84h84c6.6 0 12-5.4 12-12v-40c0-6.6-5.4-12-12-12H312c-13.3 0-24 10.7-24 24v124c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12z"></path></svg>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'user')
                    <div class="dropdown u-pro mr-5">
                        <select class="form-control amounts-are-select2" name="company" id="company_list">
                            <option value="0">Select Company</option>
                            @foreach(\App\Http\Controllers\Controller::AllCompanies() as $com)
                                <option value="{{$com['id']}}" @if(\App\Http\Controllers\Controller::SetCompany() && \App\Http\Controllers\Controller::SetCompany()==$com['id']) selected @endif >{{$com['company_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="dropdown u-pro mr-3">
                    <span class="dropdown-toggle text-white" style="cursor: pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="disable-name">{{\App\Http\Controllers\Controller::AuthUser()->name}}</span> &nbsp;<i class="fa fa-angle-down"></i>
                    </span>
                    <div class="dropdown-menu dropdown-menu-header animated flipInY" aria-labelledby="dropdownMenuButton">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'user')
                            <a class="dropdown-item" href="{{route('edit-profile')}}"><i class="ti-user pr-2"></i>My Profile</a>
                            <a class="dropdown-item" href="{{url('companies')}}"><i class="fa fa-building pr-2"></i>My Companies</a>
                            <a class="dropdown-item" href="{{route('change-password')}}"><i class="ti-settings pr-2"></i>Change Password</a>
                            <a class="dropdown-item" href="{{url('logout')}}"><i class="fa fa-power-off pr-2"></i>Logout</a>
                        @else
                            <a class="dropdown-item" href="{{url('admin/edit-profile/'.\Illuminate\Support\Facades\Auth::user()->id)}}"><i class="ti-user pr-2"></i>My Profile</a>
                            <a class="dropdown-item" href="{{url('admin/logout')}}"><i class="fa fa-power-off pr-2"></i>Logout</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 'user')
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('dashboard')}}"><i class="fa fa-home"></i><span class="hide-menu">Dashboard</span></a>
                        </li>

                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('products')}}"><i class="fab fa-product-hunt"></i><span class="hide-menu">Products / Services</span></a>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-bag"></i>
                                <span class="hide-menu">Purchases</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('expense')}}">Expenses</a></li>
                                <li><a href="{{route('bills.index')}}">Bills</a></li>
                                <li><a href="{{route('debit-notes.index')}}">Debit Notes</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-shopping-cart"></i>
                                <span class="hide-menu">Sales</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('estimate')}}">Estimates</a></li>
                                <li><a href="{{url('sales')}}">Invoices</a></li>
                                <li><a href="{{url('credit-note')}}">Credit Notes</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-clipboard"></i>
                                <span class="hide-menu">Reports</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('expense-report')}}">Expense Report</a></li>
                                <li><a href="{{url('bill-report')}}">Bill Report</a></li>
                                <li><a href="{{url('estimate-report')}}">Estimate Report</a></li>
                                <li><a href="{{url('invoice-report')}}">Invoice Report</a></li>
                                <li><a href="{{url('credit-note-report')}}">Credit Note Report</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i>
                                <span class="hide-menu">Settings</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('company-setting')}}">Company Settings</a></li>
                                <li><a href="{{url('payment-terms')}}">Payment Terms</a></li>
                                <li><a href="{{url('payment-methods')}}">Payment Methods</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('payees')}}"><i class="fa fa-user-plus"></i>
                                <span class="hide-menu">Payees / Vendors</span>
                            </a>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-envelope"></i>
                            <span class="hide-menu">Email Templates</span></a>
                            <ul aria-expanded="false" class="collapse">
                                @foreach(\App\Http\Controllers\Controller::AllEmailTemplates() as $template)
                                    <li><a href="{{route('show-email-template',['slug'=>$template['slug']])}}">{{$template['name']}}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-file-text"></i>
                                <span class="hide-menu">Templates</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('/invoice-template')}}">Invoice Template</a></li>
                            </ul>
                        </li>
                    @else
                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('admin')}}"><i class="fa fa-home"></i><span class="hide-menu">Dashboard</span></a>
                        </li>

                        <li>
                            <a class="waves-effect waves-dark" href="{{ url('admin/users')}}"><i class="fa fa-users"></i>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
    <div class="page-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <footer class="footer text-center">
        © {{date('Y')}} WebPlanex. All Rights Reserved.
    </footer>
    <div id="companySelectionModal" class="modal fade bs-example-modal-sm" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select Company</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <div class="col-md-12">
                            <select class="form-control" id="company_select_modal">
                                @foreach(\App\Http\Controllers\Controller::AllCompanies() as $com)
                                    <option value="{{$com['id']}}" @if(\App\Http\Controllers\Controller::SetCompany() && \App\Http\Controllers\Controller::SetCompany()==$com['id']) selected @endif >{{$com['company_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="select_company">Submit</button>
                </div>
            </div>
        </div>
    </div>
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

<!--******************JS FOR ROBOCROP IMAGES******************-->
<script src="{{ asset('assets/dist/robocrop/js/robocrop.demo.js')}}"></script>
<script src="{{ asset('assets/dist/robocrop/js/demo.js')}}"></script>

@if(\Illuminate\Support\Facades\Auth::user()->role == 'user')
    <script type="text/javascript">
        var gst_user_email = '{{Auth::user()->email}}';
        var gst_name_chat = '{{Auth::user()->name}}';
    </script>
    <script id="sbinit" src="{{ asset('supportboard/js/main.js') }}"></script>
@endif

@yield('page_confirmation_script')
@yield('tax_calculations_discount')
@yield('custom-cookies')
<script>
    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener('webkitfullscreenchange', exitHandler);
    document.addEventListener('mozfullscreenchange', exitHandler);
    document.addEventListener('MSFullscreenChange', exitHandler);

    function exitHandler() {
        if (!document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
            $('#svg_fullscreen').css('display','block');
            $('#svg_exit_fullscreen').css('display','none');
        }
    }
    $(document).ready(function() {
        @if(Session::get('company_selection'))
            $('#companySelectionModal').modal('show');
        @endif

        // Set active class for sidebar menu
        setTimeout(function(){
            var url1 = window.location;
            url1 = url1.toString().replace('/create','');
            url1 = url1.split('/edit')[0];
            url1 = url1.split('?')[0];
            var str = window.location.toString();
            $('nav a[href="'+ url1 +'"]').addClass('active');
            if(str.includes("/create") || str.includes("/edit") || str.includes("?")) {
                $('nav a[href="'+ url1 +'"]').parent('li').parent('ul').siblings('a').trigger('click');
            }
            $('nav a').filter(function() {
                return this.href == url1;
            }).addClass('active');
        },500);

        //if ($("#message_body").length > 0) {
            tinymce.init({
                selector: "textarea#message_body",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
            });
        //}
        $('.amounts-are-select2').select2();
        $('.amounts-are-select4').select2();
        $('.discount-level-select2').select2({
            minimumResultsForSearch: -1
        });
        $('.fullscreen-icon').on('click',function() {
            if(document.fullscreenElement||document.webkitFullscreenElement||document.mozFullScreenElement||document.msFullscreenElement) { //in fullscreen, so exit it
                if(document.exitFullscreen) {
                    document.exitFullscreen();
                } else if(document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if(document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if(document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
                $('#svg_fullscreen').css('display','block');
                $('#svg_exit_fullscreen').css('display','none');
            } else { //not fullscreen, so enter it
                if(document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if(document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen();
                } else if(document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if(document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
                $('#svg_fullscreen').css('display','none');
                $('#svg_exit_fullscreen').css('display','block');
            }
        });
    });
</script>
<script>
    $('#start_date_orderlist, #end_date_orderlist').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false });
    $('#hire_date, #released, #date_of_birth, #as_of, #expense_date, #invoice_date, #due_date,#estimate_date, #expiry_date, #bill_date, #payment_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false});
    $('.payment_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart: 0, time: false});
    $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
    $('#date-format').bootstrapMaterialDatePicker({ format: 'DD MMMM YYYY' });
    $('#min-date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', minDate: new Date() });

    $('#due_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart : 0, time: false });
    $('#bill_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart : 0, time: false }).on('change', function(e, date) {
        $('#due_date').bootstrapMaterialDatePicker('setMinDate', date);
    });

    $('#end_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart : 0, time: false });
    $('#start_date').bootstrapMaterialDatePicker({ format: 'DD-MM-YYYY', weekStart : 0, time: false }).on('change', function(e, date) {
        $('#end_date').bootstrapMaterialDatePicker('setMinDate', date);
    });
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

    $('#select_company').click(function(){
       var cid = $("#company_select_modal").val();
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

    $('#is_shipping').change(function(){
        if($("#is_shipping").is(':checked')){
            $('#shipping_address_div').removeClass('hide');
        }else{
            $("#shipping_address_div").addClass('hide');
        }
    });
</script>
</body>
</html>
