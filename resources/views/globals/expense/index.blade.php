@extends('layouts.app')
@section('content')
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
            <div class="card">
                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Payee</th>
                                    <th>Payment Account</th>
                                    <th>Payment Date</th>
                                    <th>Payment Method</th>
                                    <th>Ref No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($expense->count()>0)
                                @php $i=1; @endphp
                                @foreach($expense as $list)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$list['Payee']['name']}}</td>
                                        <td>{{$list['PaymentAccount']['name']}}</td>
                                        <td>{{date('d F Y', strtotime($list['payment_date']))}}</td>
                                        <td>{{App\Models\Globals\Expense::$payment_method[$list['payment_method']]}}</td>
                                        <td>{{$list['ref_no']}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" style="will-change: transform;">
                                                    <a class="dropdown-item" href="{{route('expense-edit',$list['id'])}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_expense_records({{$list['id']}})">Delete</a>
                                                    <a class="dropdown-item" href="{{url('expense/download_pdf/'.$list['id'])}}">Download PDF</a>
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
        </div>
    </div>
<script type='text/javascript'>
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