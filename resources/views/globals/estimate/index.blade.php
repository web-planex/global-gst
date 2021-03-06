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
</style>
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{url('estimate/create')}}" class="float-right">
                <button type="button" class="btn btn-info  d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <x-emailverification/>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            <div class="alert alert-info hide" id="convert_msg"></div>
            {!! Form::open(['url' => url('estimate'),'method'=>'get', 'class' => 'form-horizontal top-heading-form-box','files'=>true,'id'=>'SearchForm']) !!}
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'search', 'placeholder'=>'Search']) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::text('start_date', $start_date, ['class' => 'form-control','id'=>'start_date', 'placeholder'=>'Start date']) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::text('end_date', $end_date, ['class' => 'form-control','id'=>'end_date', 'placeholder'=>'End date']) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                       <button type="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                       <a href="{{url('estimate')}}"><button type="button" class="btn btn-danger">Clear</button></a>
                    </div>
                </div>
            {!! Form::close() !!}

            {!! Form::open(['url' => url('estimate/multiple_pdf'),'class' => 'form-horizontal','files'=>true,'id'=>'MultiplePdfForm']) !!}
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
                                        <h4 class="modal-title font-bold-500 font-16 text-primary" id="tooltipmodel">Bulk Estimate Download</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <label><input type="radio" name="download_type" value="1" checked="checked"> Download selected estimate as single PDF</label>
                                            <label><input type="radio" name="download_type" value="2"> Download selected estimate as individual PDF</label>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Generate Estimate Zip"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="estimate_btn" class="btn btn-primary waves-effect waves-light mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Estimate"><i class="fa fa-download"></i></button>
                        <a href="{{url('download-estimate-pdf-zip')}}" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Estimate Zip"><i class="fas fa-cloud-download-alt"></i></a>
                    </div>
                    <div class="pull-right dropleft custom-column-display">
                        <a href="javascript:;" class="text-dark" data-toggle="dropdown" title="Settings" aria-expanded="false">
                            <i class="fas fa-cog" style="font-size:20px;margin-top: 8px;"></i>
                        </a>
                        <div class="dropdown-menu chk-column-container dropdownMenu-box">
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
                    <div class="table-responsive data-table-gst-box pb-3" id="estimate_data">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="all_checked">
                                            <label class="custom-control-label" for="all_checked"></label>
                                        </div>
                                    </th>
                                    <th class="col_estimate_no">Estimate No.</th>
                                    <th class="col_customer">Customer</th>
                                    <th class="col_estimate_date">Estimate Date</th>
                                    <th class="col_due_date">Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if($estimate->count()>0)
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($estimate as $list)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="all_estimate_check[]" value="{{$list['id']}}" class="custom-control-input all_estimate_check" id="check_{{$list['id']}}">
                                                <label class="custom-control-label" for="check_{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                        <td class="col_estimate_no">{{$list['estimate_number']}}</td>
                                        <td class="col_customer">
                                            @php
                                                $payee = \App\Models\Globals\Payees::where('id',$list['customer_id'])->first();
                                                $pay_user = \App\Models\Globals\Customers::where('id',$payee['type_id'])->first();
                                            @endphp
                                            {{$pay_user['display_name']}}
                                        </td>
                                        <td class="col_estimate_date">{{date('d F Y', strtotime($list['estimate_date']))}}</td>
                                        <td class="col_due_date">{{date('d F Y', strtotime($list['expiry_date']))}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" onclick="javascript:window.location.href='{{url('estimate/'.$list['id'].'/edit')}}'" class="btn btn-secondary">Edit</button>
                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{url('estimate/'.$list['id'].'/edit')}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_invoice_records({{$list['id']}})">Delete</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="convert_to_invoice({{$list['id']}})">Convert To Invoice</a>
                                                    <a class="dropdown-item" target="_blank" href="{{route('estimate-download_pdf',['id'=>$list['id'],'output'=>'print'])}}">Print</a>
                                                    <a class="dropdown-item" target="_blank" href="{{route('estimate-download_pdf',['id'=>$list['id'],'output'=>'download'])}}">Download</a>
                                                    @if(!empty($list['files']) && file_exists($list['files']))
                                                        <a class="dropdown-item" href="{{url($list['files'])}}" download>Download Receipt</a>
                                                    @endif
                                                    @if(!empty($user['email_verified_at']))
                                                        <a class="dropdown-item" href="{{route('send-estimate-mail', ['id' => $list['id']])}}">Send Estimate Email</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <form name="frm_delete_{{$list['id']}}" id="frm_delete_{{$list['id']}}" action="{{route('estimate-delete',$list['id'])}}" method="get">

                                            </form>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                            @else
                                <tfoot>
                                    <tr>
                                        <td colspan="8" align="center">No records found!</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-6 pl-4">
                        Showing {{$estimate->firstItem()}} to {{$estimate->lastItem()}} of {{$estimate->total()}} entries
                    </div>
                    <div class="col-md-6 pr-4">
                        @include('inc.pagination', ['paginator' => $estimate])
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@section('custom-cookies')
<script src="{{asset('js/custom-cookies.js')}}"></script>
@endsection
<script type='text/javascript'>
    $(document).ready(function(){
        $("#all_checked").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
            $('#selected_unfulfilled_count').html($('[name="all_estimate_check[]"]:checked').length);
        });

        $('.all_estimate_check').click(function(){
            if($('[name="all_estimate_check[]"]:checked').length == {{$estimate->count()}}){
                $('#all_checked').prop('checked',true);
            }else{
                $('#all_checked').prop('checked',false);
            }
            $('#selected_unfulfilled_count').html($('[name="all_estimate_check[]"]:checked').length);
        });

        $('#estimate_btn').click(function(){
            if($('[name="all_estimate_check[]"]:checked').length == 0){
                Swal.fire("Select at least one estimate");
                return false;
            }
            $('#myModal').modal('show');
            return false;
        });

        $(document).on('click', '.custom-column-display .dropdown-menu', function (e) {
            e.stopPropagation();
        });
        var checkbox_cookie_arr = [];
        var exp_cookie_json_str = getCookie('estimateColumns');

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
            setCookie("estimateColumns", json_str, 365);
        });
    });

    function delete_invoice_records(invoice_id){
        Swal.fire({
            title: 'Do you want to delete this?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = '{{url('estimate/delete')}}/'+invoice_id;
            }
        })
    }

    function convert_to_invoice(estimate_id){
        Swal.fire({
            title: 'Are you sure to convert to invoice?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, convert it!'
        }).then((result) => {
            if (result.value) {
            estimate_convert(estimate_id)
            }
        })
    }

    function estimate_convert(eid){
        $.ajax({
            url: '{{url('ajax/convert_to_invoice')}}',
            type: 'POST',
            data: {'estimate_id':eid},
            success: function (result) {
                $('#convert_msg').html('Estimate converted into invoice successfully.');
                $('#convert_msg').removeClass('hide');
                $("#estimate_data").load(location.href + " #estimate_data");
            }
        });
    }
</script>
@endsection
