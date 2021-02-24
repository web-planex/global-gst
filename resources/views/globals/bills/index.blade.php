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
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{route('bills.create')}}" class="float-right">
                <button type="button" class="btn btn-info  d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            <div class="alert alert-info hide" id="payment_msg"></div>
            {!! Form::open(['url' => route('bills.index'),'method'=>'get', 'class' => 'form-horizontal top-heading-form-box','files'=>true,'id'=>'SearchForm']) !!}
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
                        <div class="form-group">
                            {!! Form::select('status', [''=>'All Status']+\App\Models\Globals\Bills::$bill_status, isset($status)&&!empty($status)?$status:null, ['class' => 'form-control amounts-are-select2', 'id' => 'status']) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                       <button type="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                       <a href="{{route('bills.index')}}"><button type="button" class="btn btn-danger">Clear</button></a>
                    </div>
                </div>
            {!! Form::close() !!}

            {!! Form::open(['url' => route('bill-multiple-pdf'),'class' => 'form-horizontal top-heading-form-box','files'=>true,'id'=>'MultiplePdfForm']) !!}
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
                                        <h4 class="modal-title font-bold-500 font-16 text-primary" id="tooltipmodel">Bulk Bill Download</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <label><input type="radio" name="download_type" value="1" checked="checked"> Download selected bills as single PDF</label>
                                            <label><input type="radio" name="download_type" value="2"> Download selected bills as individual PDF</label>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Generate Bills Zip"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" id="download_multi_bill" class="btn btn-success waves-effect waves-light mb-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Bills Zip"><i class="fas fa-cloud-download-alt"></i></a>
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
                    <div class="table-responsive data-table-gst-box pb-3" id="bill_data">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="all_checked">
                                            <label class="custom-control-label" for="all_checked"></label>
                                        </div>
                                    </th>
                                    <th class="col_bill_no">Bill No.</th>
                                    <th class="col_customer">Customer</th>
                                    <th class="col_bill_date">Bill Date</th>
                                    <th class="col_due_date">Due Date</th>
                                    <th class="col_memo">Memo</th>
                                    <th class="col_status">Status</th>
                                    <th class="col_total">Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            @if($bills->count()>0)
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($bills as $list)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="all_bills_check[]" value="{{$list['id']}}" class="custom-control-input all_bills_check" id="check_{{$list['id']}}">
                                                <label class="custom-control-label" for="check_{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                        <td class="col_bill_no">{{$list['bill_no']}}</td>
                                        <td class="col_customer">{{$list['Payee']['name']}}</td>
                                        <td class="col_bill_date">{{date('d M Y', strtotime($list['bill_date']))}}</td>
                                        <td class="col_due_date">{{date('d M Y', strtotime($list['due_date']))}}</td>
                                        <td class="col_memo">
                                            <input type="hidden" id="Notes_{{$list['id']}}" value="{{$list['memo']}}">
                                            @if($list['memo'] != '' && strlen($list['memo']) > 30)
                                                <a href="javascript:void(0)" class="text-themecolor text-left" onclick="show_note({{$list['id']}})">{{substr($list['memo'],0,25)}}...</a>
                                            @elseif(strlen($list['memo']) > 0 && strlen($list['memo']) <= 30)
                                                {{$list['memo']}}
                                            @endif
                                        </td>
                                        <td class="col_status">
                                            @if($list['status']==1)
                                                <label class="label label-warning">Open</label>
                                            @elseif($list['status']==2)
                                                <label class="label label-success">Paid</label>
                                            @elseif($list['status']==3)
                                                <label class="label label-danger">Void</label>
                                            @else
                                                <label class="label label-primary">Overdue</label>
                                            @endif
                                        </td>
                                        <td class="col_total">Rs. {{$list['total']}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" onclick="javascript:window.location.href='{{route('bills.edit',['bill'=>$list['id']])}}'" class="btn btn-secondary">Edit</button>
                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('bills.edit',['bill'=>$list['id']])}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_bills_records({{$list['id']}})">Delete</a>
                                                    @if(!in_array($list['status'],[2,3]))
                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#MakePaymentModal{{$list['id']}}">Make Payment</a>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="void_bills({{$list['id']}})">Void</a>
                                                    @endif
                                                    <a class="dropdown-item" target="_blank" href="{{route('download-bill-pdf',['id'=>$list['id'],'output'=>'print'])}}">Print</a>
                                                    <a class="dropdown-item" href="{{route('download-bill-pdf',['id'=>$list['id'],'output'=>'download'])}}">Download</a>
                                                    @if(!empty($list['files']) && file_exists($list['files']))
                                                        <a class="dropdown-item" href="{{url($list['files'])}}" download>Download Receipt</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp

                                    <!-------------------------MAKE PAYMENT MODAL------------------------->
                                    <div id="MakePaymentModal{{$list['id']}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title font-bold-500 font-16 text-primary" id="tooltipmodel">Make Payment</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="form-group mb-3 col-md-12">
                                                            <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                                                            {!! Form::text('payment_date', date('d-m-Y'), ['class' => 'form-control payment_date','id'=>'payment_date'.$list['id']]) !!}
                                                            <span class="text-danger hide" id="pdate_msg"></span>
                                                        </div>
                                                        <div class="form-group mb-3 col-md-12">
                                                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                                            {!! Form::select('payment_method', $payment_method, isset($list['payment_method'])&&!empty($list['payment_method'])?$list['payment_method']:null, ['class' => 'form-control amounts-are-select2', 'id' => 'payment_method'.$list['id'],'style'=>'width:100%;']) !!}
                                                            <span class="text-danger hide" id="pmethod_msg"></span>
                                                        </div>
                                                        <div class="form-group mb-3 col-md-12">
                                                            <label for="bill_no">Bill No <span class="text-danger">*</span></label>
                                                            {!! Form::text('bill_no', isset($list['bill_no'])&&!empty($list['bill_no'])?$list['bill_no']:null, ['class' => 'form-control','id'=>'bill_no'.$list['id']]) !!}
                                                            <span class="text-danger hide" id="billno_msg"></span>
                                                        </div>
                                                        <div class="form-group mb-0 col-md-12">
                                                            <label for="note">Note <span class="text-danger"></span></label>
                                                            {!! Form::textarea('note', isset($list['memo'])&&!empty($list['memo'])?$list['memo']:null, ['rows'=>'3','class' => 'form-control','id'=>'note'.$list['id']]) !!}
                                                            @if ($errors->has('note'))
                                                                <span class="text-danger">
                                                                    <strong>{{ $errors->first('note') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" onclick="MakePayment({{$list['id']}})">Make Payment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<!--                        <div class="fixed-table-pagination">
                            <div class="float-right pagination mr-3">
                                @include('inc.pagination', ['paginator' => $bills])
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-6 pl-4">
                        Showing {{$bills->firstItem()}} to {{$bills->lastItem()}} of {{$bills->total()}} entries
                    </div>
                    <div class="col-md-6 pr-4">
                        @include('inc.pagination', ['paginator' => $bills])
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
        $(document).on('click', '.custom-column-display .dropdown-menu', function (e) {
            e.stopPropagation();
        });
        var checkbox_cookie_arr = [];
        var exp_cookie_json_str = getCookie('billsColumns');

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
            setCookie("billsColumns", json_str, 365);
        });

        $('#download_multi_bill').click(function(){
            if($('[name="all_bills_check[]"]:checked').length == 0){
                Swal.fire("Select at least one bill");
                return false;
            }
            $('#myModal').modal('show');
            return false;
        });
    });

    $("#all_checked").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
        $('#selected_unfulfilled_count').html($('[name="all_bills_check[]"]:checked').length);
    });

    $('.all_bills_check').click(function(){
        if($('[name="all_bills_check[]"]:checked').length == {{$bills->count()}}){
            $('#all_checked').prop('checked',true);
        }else{
            $('#all_checked').prop('checked',false);
        }
        $('#selected_unfulfilled_count').html($('[name="all_bills_check[]"]:checked').length);
    });

    function MakePayment(bid){
        var flag = 1;
        var pdate = $('#payment_date'+bid).val();
        var pmethod = $('#payment_method'+bid).val();
        var billno = $('#bill_no'+bid).val();
        var note = $('#note'+bid).val();

        if(pdate == ""){
            $('#pdate_msg').html('<strong>The payment date field is required</strong>');
            $('#pdate_msg').removeClass('hide');
            flag = 0;
        }else{
            $('#pdate_msg').addClass('hide');
        }

        if(pmethod == ""){
            $('#pmethod_msg').html('<strong>The payment method field is required</strong>');
            $('#pmethod_msg').removeClass('hide');
            flag = 0;
        }else{
            $('#pmethod_msg').addClass('hide');
        }

        if(billno == ""){
            $('#billno_msg').html('<strong>The bill number field is required</strong>');
            $('#billno_msg').removeClass('hide');
            flag = 0;
        }else{
            $('#billno_msg').addClass('hide');
        }

        if(flag ==0){
            return false;
        }else{
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('ajax/make_payment')}}/'+bid,
                type: 'POST',
                data: {'pdate':pdate,'pmethod':pmethod,'billno':billno,'note':note},
                success: function (result) {
                    $('#MakePaymentModal'+bid).modal('hide');
                    $("#bill_data").load(location.href + " #bill_data");
                    $("#payment_msg").html('Payment successfully done.');
                    $("#payment_msg").removeClass('hide');
                }
            });
        }
    }

    function delete_bills_records(bill_id){
        Swal.fire({
            title: 'Do you want to delete this?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = '{{url('bills/delete')}}/'+bill_id;
            }
        })
    }

    function void_bills(bill_id){
        Swal.fire({
            title: 'Are you sure to void this bill?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, void it!'
        }).then((result) => {
            if (result.value) {
            window.location.href = '{{url('bills/void')}}/'+bill_id;
            }
        })
    }
    function show_note(bill_id) {
        Swal.fire({
            title: 'Note',
            text: $('#Notes_'+bill_id).val()
        });
    }
</script>
@endsection
