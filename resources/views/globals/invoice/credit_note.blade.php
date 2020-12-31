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
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            {!! Form::open(['url' => url('credit-note'),'method'=>'get', 'class' => 'form-horizontal','files'=>true,'id'=>'SearchForm']) !!}
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
                    <a href="{{url('sales')}}"><button type="button" class="btn btn-danger">Clear</button></a>
                </div>
            </div>
            {!! Form::close() !!}

            {!! Form::open(['url' => url('sales/multiple_pdf'),'class' => 'form-horizontal','files'=>true,'id'=>'MultiplePdfForm']) !!}
            <div class="card">
                <div class="row results-top" style="margin: 0 5px;">
                    <div class="col-md-6 col-lg-5 action">
                        <div class="action-invoice">
                            <div class="action-on">
                                <div>Action on </div>
                                <div><span id="selected_unfulfilled_count">0</span> Selected</div>
                            </div>
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
                    <div class="col-md-2 col-lg-6 btn-group">
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
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Generate Invoices Zip"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="https://gstdemo.webplanex.net/orders-invoice-zip-list?shop=wepdemo3.myshopify.com" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Invoices Zip"><i class="fas fa-cloud-download-alt"></i></a>
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
                                <th>#</th>
                                <th>Invoice No.</th>
                                <th>Credit Note No.</th>
                                <th>Customer</th>
                                <th>Invoice Date</th>
                                <th>Due Date</th>
                                <th>Total Tax</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Credit Note</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($credit_notes->count()>0)
                                @php $i=1; @endphp
                                @foreach($credit_notes as $list)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="all_sales_check[]" value="{{$list['id']}}" class="custom-control-input all_sales_check" id="check_{{$list['id']}}">
                                                <label class="custom-control-label" for="check_{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                        <td>{{$i}}</td>
                                        <td>{{$company['invoice_prefix']}}/{{$list['invoice_number']}}</td>
                                        <td>@if(!empty($list['credit_note_number'])) {{$company['credit_note_prefix']}}/{{$list['credit_note_number']}} @else - @endif</td>
                                        <td>{{$list['Payee']['name']}}</td>
                                        <td>{{date('d F Y', strtotime($list['invoice_date']))}}</td>
                                        <td>{{date('d F Y', strtotime($list['due_date']))}}</td>
                                        <td>Rs. {{$list['tax_amount']}}</td>
                                        <td>
                                            @if($list['status']==3)
                                                <label class="label label-primary">Refunded</label>
                                            @else
                                                <label class="label label-warning">Voided</label>
                                            @endif
                                        </td>
                                        <td>Rs. {{$list['total']}}</td>
                                        <td>
                                            <a class="dropdown-item" target="_blank" href="{{route('invoice-download_pdf',['id'=>$list['id'],'output'=>'print','type'=>'credit_note'])}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print Credit note"><i class="fas fa-print"></i></a>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="fixed-table-pagination">
                            <div class="float-right pagination mr-3">
                                @include('inc.pagination', ['paginator' => $credit_notes])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <script type='text/javascript'>

        $("#all_checked").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
            $('#selected_unfulfilled_count').html($('[name="all_sales_check[]"]:checked').length);
        });

        $('.all_sales_check').click(function(){
            if($('[name="all_sales_check[]"]:checked').length == {{$credit_notes->count()}}){
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

        function delete_invoice_records(invoice_id){
            Swal.fire({
                title: 'Are you want to delete this?',
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#01c0c8",
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                $('#frm_delete_'+invoice_id).submit();
            }
        })
        }
    </script>
@endsection