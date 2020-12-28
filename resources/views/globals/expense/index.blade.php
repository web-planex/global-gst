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
            <h4 class="text-themecolor">Expense</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{url('expense/create')}}" class="float-right">
                <button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
             {!! Form::open(['url' => url('expense'),'method'=>'get', 'class' => 'form-horizontal','files'=>true,'id'=>'SearchForm']) !!}
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
                                {!! Form::select('payee', $payees, isset($selected_payee)&&!empty($selected_payee)?$selected_payee:null, ['class' => 'form-control amounts-are-select2', 'id' => 'payee']) !!}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::select('status', [null => 'Select Status'] + \App\Models\Globals\Expense::$expense_status, isset($status)&&!empty($status)?$status:null, ['class' => 'form-control amounts-are-select2', 'id' => 'status']) !!}
                            </div>
                        </div>

                       <div class="col-md-2">
                           <button type="submit" class="btn btn-primary waves-effect waves-light pt-2"><i class="ti-search"></i></button>
                           <a href="{{url('expense')}}"><button type="button" class="btn sync-orders-btn waves-effect waves-light btn-success">Clear</button></a>
                        </div>
                    </div>                
              {!! Form::close() !!}
            {!! Form::open(['url' => route('generate-multiple-expenses'),'class' => 'form-horizontal','files'=>true,'id'=>'MultiplePdfForm']) !!}
            <div class="card">
                <div class="row results-top" style="margin: 0 5px;">
                    <div class="col-md-2 action">
                        <div class="action-invoice">
                            <div class="action-on mt-1">
                                <div>Action on </div>
                                <div><span id="selected_unfulfilled_count">0</span> Selected</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 btn-group">
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
                            <a href="javascript:;" id="download_multi_expense" data-toggle="modal" data-target="#myModal" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Expenses Zip"><i class="fas fa-cloud-download-alt"></i></a>
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
                                    <th>Payee</th>
                                    <th>Payment Date</th>
                                    <th>Payment Method</th>
                                    <th>Ref No</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($expense->count()>0)
                                @php $i=1; @endphp
                                @foreach($expense as $list)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="all_expenses_check[]" value="{{$list['id']}}" class="custom-control-input all_expenses_check" id="check_{{$list['id']}}">
                                                <label class="custom-control-label" for="check_{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                        <td>{{$i}}</td>
                                        <td>{{$list['Payee']['name']}}</td>
                                        <td>{{date('d F Y', strtotime($list['payment_date']))}}</td>
                                        <td>{{App\Models\Globals\Expense::$payment_method[$list['payment_method']]}}</td>
                                        <td>{{$list['ref_no']}}</td>
                                        <td>
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
                                            <form name="frm_delete_{{$list['id']}}" id="frm_delete_{{$list['id']}}" action="{{route('expense-delete',$list['id'])}}" method="get"></form>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="fixed-table-pagination">
                            <div class="float-right pagination mr-3">
                                @include('inc.pagination', ['paginator' => $expense])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
<script type='text/javascript'>
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
            title: 'Are you want to delete this?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $('#frm_delete_'+expense_id).submit();
            }
        })
    }
</script>
@endsection