@extends('layouts.app')
@section('content')
<style>
@media (max-width: 767px) {
    .table-responsive .dropdown-menu {
        overflow-x: auto;
    }
}
@media (min-width: 768px) {
    .table-responsive {
        overflow-x: visible;
    }
}
.swal2-popup #swal2-content {
    text-align: justify;
}
</style>
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Expense</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{url('expense/create')}}" class="float-right">
                <button type="button" class="btn btn-info  d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            {!! Form::open(['url' => url('expense'),'method'=>'get', 'class' => 'form-horizontal top-heading-form-box','files'=>true,'id'=>'SearchForm']) !!}
                <div class="row">
                    <div class="col-sm-3 col-lg-2">
                        <div class="form-group">
                            {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'search', 'placeholder'=>'Search']) !!}
                        </div>
                    </div>

                    <div class="col-sm-3 col-lg-2">
                        <div class="form-group">
                            {!! Form::text('start_date', $start_date, ['class' => 'form-control','id'=>'start_date', 'placeholder'=>'Start date']) !!}
                        </div>
                    </div>

                    <div class="col-sm-3 col-lg-2">
                        <div class="form-group">
                            {!! Form::text('end_date', $end_date, ['class' => 'form-control','id'=>'end_date', 'placeholder'=>'End date']) !!}
                        </div>
                    </div>

                    <div class="col-sm-3 col-lg-2">
                        <div class="form-group">
                            {!! Form::select('payee', $payees, isset($selected_payee)&&!empty($selected_payee)?$selected_payee:null, ['class' => 'form-control amounts-are-select2', 'id' => 'payee']) !!}
                        </div>
                    </div>

                    <div class="col-sm-3 col-lg-2">
                        <div class="form-group">
                            {!! Form::select('status', [null => 'Select Status'] + \App\Models\Globals\Expense::$expense_status, isset($status)&&!empty($status)?$status:null, ['class' => 'form-control amounts-are-select2', 'id' => 'status']) !!}
                        </div>
                    </div>

                   <div class="col-sm-3 col-lg-2">
                       <button type="submit" class="btn btn-primary waves-effect waves-light pt-2"><i class="ti-search"></i></button>
                       <a href="{{url('expense')}}"><button type="button" class="btn sync-orders-btn waves-effect waves-light btn-success">Clear</button></a>
                    </div>
                </div>
            {!! Form::close() !!}
            {!! Form::open(['url' => route('generate-multiple-expenses'),'class' => 'form-horizontal','files'=>true,'id'=>'MultiplePdfForm']) !!}
            <div class="card">
                <div class="results-top" style="margin: 0 5px;">
                        <div class="float-left">
                            <div class="action-on mt-1">
                                <div>Action on </div>
                                <div><span id="selected_unfulfilled_count">0</span> Selected</div>
                            </div>
                        </div>
                        <div class="col-left">
                            <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="tooltipmodel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title font-bold-500 font-16 text-primary" id="tooltipmodel">Bulk Expense Download</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <label><input type="radio" name="download_type" value="1" checked="checked"> Download selected expenses as single PDF</label>
                                                <label><input type="radio" name="download_type" value="2"> Download selected expenses as individual PDF</label>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Generate Expenses Zip"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:;" id="download_multi_expense" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Expenses Zip"><i class="fas fa-cloud-download-alt"></i></a>
                        </div>
                        <div class="pull-right dropleft custom-column-display">
                            <a href="javascript:;" class="text-dark" data-toggle="dropdown" title="Settings" aria-expanded="false">
                                <i class="fas fa-cog" style="font-size:20px;margin-top: 8px;"></i>
                            </a>
                            <div class="dropdown-menu chk-column-container">
                                @if(!empty($custom_column))
                                <div class="dropdown-item">Columns</div>
                                <div class="dropdown-divider"></div>
                                @foreach($custom_column as $column)
                                <div class="dropdown-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" value="col_{{strtolower(str_replace(' ','_',$column))}}" class="custom-control-input custom-column-checkbox" id="{{$column}}" checked>
                                        <label class="custom-control-label" for="{{$column}}">{{$column}}</label>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                </div>
                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="all_checked">
                                            <label class="custom-control-label" for="all_checked"></label>
                                        </div>
                                    </th>
                                    <th class="col_payee">Payee / Vendors</th>
                                    <th class="col_expense_date">Expense Date</th>
                                    <th class="col_payment_method">Payment Method</th>
                                    <th class="col_ref_no">Ref No</th>
                                    <th class="col_note">Note</th>
                                    <th class="col_status">Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if($expense->count()>0)
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($expense as $list)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="all_expenses_check[]" value="{{$list['id']}}" class="custom-control-input all_expenses_check" id="check_{{$list['id']}}">
                                                <label class="custom-control-label" for="check_{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                        <td class="col_payee">{{$list['Payee']['name']}}</td>
                                        <td class="col_expense_date">{{date('d F Y', strtotime($list['expense_date']))}}</td>
                                        <td class="col_payment_method">{{App\Models\Globals\Expense::$payment_method[$list['payment_method']]}}</td>
                                        <td class="col_ref_no">{{$list['ref_no']}}</td>
                                        <td class="col_note">
                                            <input type="hidden" id="Notes_{{$list['id']}}" value="{{$list['memo']}}">
                                            @if($list['memo'] != '' && strlen($list['memo']) > 30)
                                                <a href="javascript:void(0)" class="text-themecolor text-left" onclick="show_note({{$list['id']}})">{{substr($list['memo'],0,25)}}...</a>
                                            @elseif(strlen($list['memo']) > 0 && strlen($list['memo']) <= 30)
                                                {{$list['memo']}}
                                            @endif
                                        </td>
                                        <td class="col_status">
                                            @if($list['status'] == 1)
                                            <span class="badge badge-warning text-white">Pending</span>
                                            @elseif($list['status'] == 2)
                                            <span class="badge badge-primary text-white">Paid</span>
                                            @elseif($list['status'] == 3)
                                            <span class="badge badge-warning text-white">Voided</span>
                                            @endif
                                        </td>
                                        <td>Rs. {{number_format($list['total'],2)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" onclick="javascript:window.location.href='{{route('expense-edit',$list['id'])}}'" class="btn btn-secondary">Edit</button>
                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('expense-edit',$list['id'])}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_expense_records({{$list['id']}})">Delete</a>
                                                    <a class="dropdown-item" target="_blank" href="{{route('expense-download_pdf',['id'=>$list['id'],'output'=>'print'])}}">Print</a>
                                                    <a class="dropdown-item" href="{{route('expense-download_pdf',['id'=>$list['id'],'output'=>'download'])}}">Download</a>
                                                    @if(!empty($list['files']) && file_exists($list['files']))
                                                        <a class="dropdown-item" href="{{url($list['files'])}}" download>Download Receipt</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--<form name="frm_delete_{{$list['id']}}" id="frm_delete_{{$list['id']}}" action="{{route('expense-delete',$list['id'])}}" method="get"></form>-->
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                            @else
                                <tfoot>
                                    <tr>
                                        <td colspan="9" align="center">No records found!</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-6 pl-4">
                        Showing {{$expense->firstItem()}} to {{$expense->lastItem()}} of {{$expense->total()}} entries
                    </div>
                    <div class="col-md-6 pr-4">
                        @include('inc.pagination', ['paginator' => $expense])
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
<script type='text/javascript'>
    $(document).ready(function(){
        $(document).on('click', '.custom-column-display .dropdown-menu', function (e) {
            e.stopPropagation();
        });
        var checkbox_cookie_arr = [];
        var exp_cookie_json_str = getCookie('expenseColumns');
        if(exp_cookie_json_str != '') {
            checkbox_cookie_arr = JSON.parse(exp_cookie_json_str);
        }
        $('.chk-column-container').find('input:checkbox').each(function(){
            if(exp_cookie_json_str.includes($(this).val())) {
                $(this).prop("checked", false);
                $('.'+$(this).val()).addClass('hide');
            }
        });
        $('.custom-column-checkbox').on('click',function(){
            var class_name = $(this).val();
            if(!$(this).is(':checked')) {
                checkbox_cookie_arr.push(class_name);
            } else {
                var index = checkbox_cookie_arr.indexOf(class_name);
                if (index > -1) {
                    checkbox_cookie_arr.splice(index, 1);
                }
            }
            var json_str = JSON.stringify(checkbox_cookie_arr);
            $('.'+class_name).toggleClass('hide');
            setCookie("expenseColumns", json_str, 365);
        });
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    $('#download_multi_expense').click(function(){
       if($('[name="all_expenses_check[]"]:checked').length == 0){
           Swal.fire("Select at least one expense");
           return false;
       }
        $('#myModal').modal('show');
        return false;
    });

    $("#all_checked").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $('#selected_unfulfilled_count').html($('[name="all_expenses_check[]"]:checked').length);
    });

    $('.all_expenses_check').click(function(){
        if($('[name="all_expenses_check[]"]:checked').length == {{$expense->count()}}){
            $('#all_checked').prop('checked',true);
        }else{
            $('#all_checked').prop('checked',false);
        }
        $('#selected_unfulfilled_count').html($('[name="all_expenses_check[]"]:checked').length);
    });

    function delete_expense_records(expense_id){
        Swal.fire({
            title: 'Do you want to delete this?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = '{{url("expense/delete")}}/'+expense_id;
            }
        })
    }
    function show_note(ex_id) {
        Swal.fire({
            title: 'Note',
            text: $('#Notes_'+ex_id).val()
        });
    }
</script>
@endsection
