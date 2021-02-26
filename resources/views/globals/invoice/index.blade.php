@extends('layouts.app')
@section('content')
<style>
@media (max-width: 767px) {
    .table-responsive .dropdown-menu {
        overflow-x: auto;
    }
}
</style>
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{url('sales/create')}}" class="float-right">
                <button type="button" class="btn btn-info  d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <x-emailverification/>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            {!! Form::open(['url' => url('sales'),'method'=>'get', 'class' => 'form-horizontal top-heading-form-box','files'=>true,'id'=>'SearchForm']) !!}
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'search', 'placeholder'=>'Search']) !!}
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            {!! Form::text('start_date', $start_date, ['class' => 'form-control','id'=>'start_date', 'placeholder'=>'Start date']) !!}
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            {!! Form::text('end_date', $end_date, ['class' => 'form-control','id'=>'end_date', 'placeholder'=>'End date']) !!}
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            {!! Form::select('status', [''=>'All Status']+\App\Models\Globals\Invoice::$invoice_status, isset($status)&&!empty($status)?$status:null, ['class' => 'form-control amounts-are-select2', 'id' => 'status']) !!}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                       <button type="submit" class="btn btn-primary mr-2 mb-0"><i class="ti-search"></i></button>
                       <a href="{{url('sales')}}"><button type="button" class="btn btn-danger mb-0">Clear</button></a>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}

            {!! Form::open(['url' => url('sales/multiple_pdf'),'class' => 'form-horizontal','files'=>true,'id'=>'MultiplePdfForm']) !!}
            <div class="card">
                <div class="row my-3" style="margin: 0 5px;">
                    <div class="col-lg-2">
                        <div class="action-on mt-2">
                            <div>Action on </div>
                            <div><span id="selected_unfulfilled_count">0</span> Selected</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="invoice-type-btm">
                            <div class="invoice-type">
                                <div class="form-group has-success mb-0">
                                    <select class="form-control custom-select" id="invoice_type" name="invoice_type" data-toggle="tooltip" data-placement="top" title="" data-original-title="Select &amp; Generate Invoices Zip">
                                        <option value="">Select Invoice Type</option>
                                        <option value="original">Download Original</option>
                                        <option value="duplicate">Download Duplicate</option>
                                        <option value="triplicate">Download Triplicate</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="col-left">
                        <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="tooltipmodel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title font-bold-500 font-16 text-primary" id="tooltipmodel">Bulk Invoice Download</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <label><input type="radio" name="download_type" value="1" checked="checked"> Download selected invoices as single PDF</label>
                                            <label><input type="radio" name="download_type" value="2"> Download selected invoices as individual PDF</label>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Generate Invoice Zip"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{url('download-invoice-pdf-zip')}}" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" ><i class="fas fa-cloud-download-alt"></i></a>
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

                </div>

                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3" id="invoice_data">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="all_checked">
                                            <label class="custom-control-label" for="all_checked"></label>
                                        </div>
                                    </th>
                                    <th class="col_invoice_no">Invoice No.</th>
                                    <th class="col_customer">Customer</th>
                                    <th class="col_invoice_date">Invoice Date</th>
                                    <th class="col_due_date">Due Date</th>
                                    <th class="col_total">Total</th>
                                    <th class="col_notes">Note</th>
                                    <th class="col_status">Status</th>
                                    <th>Invoice</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if($invoice->count()>0)
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($invoice as $list)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="all_sales_check[]" value="{{$list['id']}}" class="custom-control-input all_sales_check" id="check_{{$list['id']}}">
                                                <label class="custom-control-label" for="check_{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                        <td class="col_invoice_no">{{$list['invoice_number']}}</td>
                                        <td class="col_customer">{{$list['Payee']['name']}}</td>
                                        <td class="col_invoice_date">{{date('d F Y', strtotime($list['invoice_date']))}}</td>
                                        <td class="col_due_date">{{date('d F Y', strtotime($list['due_date']))}}</td>
                                        <td class="col_total">{{$list['total']}}</td>
                                        <td class="col_notes">
                                            <input type="hidden" id="Invoice_Notes_{{$list['id']}}" value="{{$list['notes']}}">
                                            @if(!empty($list['notes']) && strlen($list['notes']) > 25)
                                                <a href="javascript:void(0)" class="text-themecolor text-left" onclick="show_note({{$list['id']}})">
                                                    {{ substr($list['notes'], 0 ,25) }}...
                                                </a>
                                            @else
                                                {{ $list['notes'] }}
                                            @endif
                                        </td>
                                        <td class="col_status">
                                            @if($list['status']==1)
                                                <label class="label label-warning">Pending</label>
                                            @elseif($list['status']==2)
                                                <label class="label label-success">Paid</label>
                                            @elseif($list['status']==3)
                                                <label class="label label-danger">Void</label>
                                            @else
                                                <label class="label label-warning">Refund</label>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" onclick="javascript:;" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Download</button>
                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('invoice-download_pdf',['id'=>$list['id'],'output'=>'download','download'=>'1'])}}">Original</a>
                                                    <a class="dropdown-item" href="{{route('invoice-download_pdf',['id'=>$list['id'],'output'=>'download','download'=>'2'])}}">Duplicate</a>
                                                    <a class="dropdown-item" href="{{route('invoice-download_pdf',['id'=>$list['id'],'output'=>'download','download'=>'3'])}}">Triplicate</a>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="btn-group">
                                                <button type="button" onclick="javascript:window.location.href='{{url('sales/'.$list['id'].'/edit')}}'" class="btn btn-secondary">Edit</button>
                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{url('sales/'.$list['id'].'/edit')}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_invoice_records({{$list['id']}})">Delete</a>
                                                    @if(!in_array($list['status'],[2,3]))
                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#MakePaymentModal{{$list['id']}}">Make Payment</a>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="void_bills({{$list['id']}})">Void</a>
                                                    @endif
                                                    <a class="dropdown-item" target="_blank" href="{{route('invoice-download_pdf',['id'=>$list['id'],'output'=>'print'])}}">Print</a>
                                                    @if(!empty($list['files']) && file_exists($list['files']))
                                                        <a class="dropdown-item" href="{{url($list['files'])}}" download>Download Receipt</a>
                                                    @endif
                                                    <a class="dropdown-item" href="{{route('send-invoice-mail', ['id' => $list['id']])}}">Send Invoice Email</a>
                                                </div>
                                            </div>
                                            <form name="frm_delete_{{$list['id']}}" id="frm_delete_{{$list['id']}}" action="{{route('sales-delete',$list['id'])}}" method="get"></form>
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
                                                            <label for="invoice_number">Invoice No <span class="text-danger">*</span></label>
                                                            {!! Form::text('invoice_number', isset($list['invoice_number'])&&!empty($list['invoice_number'])?$list['invoice_number']:null, ['class' => 'form-control','id'=>'invoice_number'.$list['id']]) !!}
                                                            <span class="text-danger hide" id="invoiceno_msg"></span>
                                                        </div>
                                                        <div class="form-group mb-0 col-md-12">
                                                            <label for="note">Note <span class="text-danger"></span></label>
                                                            {!! Form::textarea('note', isset($list['notes'])&&!empty($list['notes'])?$list['notes']:null, ['rows'=>'3','class' => 'form-control','id'=>'note'.$list['id']]) !!}
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
                                        <td colspan="9" align="center">No records found!</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-6 pl-4">
                        Showing {{$invoice->firstItem()}} to {{$invoice->lastItem()}} of {{$invoice->total()}} entries
                    </div>
                    <div class="col-md-6 pr-4">
                        @include('inc.pagination', ['paginator' => $invoice])
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
        var exp_cookie_json_str = getCookie('invoiceColumns');

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
            setCookie("invoiceColumns", json_str, 365);
        });

        $("#all_checked").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
            $('#selected_unfulfilled_count').html($('[name="all_sales_check[]"]:checked').length);
        });

        $('.all_sales_check').click(function(){
            if($('[name="all_sales_check[]"]:checked').length == {{$invoice->count()}}){
                $('#all_checked').prop('checked',true);
            }else{
                $('#all_checked').prop('checked',false);
            }
            $('#selected_unfulfilled_count').html($('[name="all_sales_check[]"]:checked').length);
        });

        $('#invoice_type').change(function(){
        if($('[name="all_sales_check[]"]:checked').length == 0){
            Swal.fire("Select at least one sales");
            return false;
        }
            $('#myModal').modal('show');
            return false;
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
                window.location.href = '{{url('sales/delete')}}/'+invoice_id;
            }
        })
    }

    function MakePayment(inid){
        var flag = 1;
        var pdate = $('#payment_date'+inid).val();
        var pmethod = $('#payment_method'+inid).val();
        var in_no = $('#invoice_number'+inid).val();
        var note = $('#note'+inid).val();

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

        if(in_no == ""){
            $('#invoiceno_msg').html('<strong>The invoice number field is required</strong>');
            $('#invoiceno_msg').removeClass('hide');
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
                url: '{{url('sales/make_payment')}}/'+inid,
                type: 'POST',
                data: {'pdate':pdate,'pmethod':pmethod,'invoice_number':in_no,'note':note},
                success: function (result) {
                    $('#MakePaymentModal'+inid).modal('hide');
                    $("#invoice_data").load(location.href + " #invoice_data");
                    $("#payment_msg").html('Payment successfully done.');
                    $("#payment_msg").removeClass('hide');
                }
            });
        }
    }

    function void_bills(invoice_id){
        Swal.fire({
            title: 'Are you sure to void this invoice?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, void it!'
        }).then((result) => {
            if (result.value) {
            window.location.href = '{{url('sales/void')}}/'+invoice_id;
        }
    })
    }

    function show_note(in_id) {
        Swal.fire({
            title: 'Note',
            text: $('#Invoice_Notes_'+in_id).val()
        });
    }
</script>
@endsection