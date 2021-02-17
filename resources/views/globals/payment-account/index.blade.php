@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Account</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{route('payment-account-add')}}" class="float-right">
                <button type="button" class="btn btn-info  d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
                {!! Form::open(['url' => url('payment-account'),'method'=>'get', 'class' => 'form-horizontal','files'=>true,'id'=>'SearchForm']) !!}
                    <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                            {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'search', 'placeholder'=>'Search']) !!}
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                            {!! Form::text('start_date', $start_date, ['class' => 'form-control','id'=>'start_date', 'placeholder'=>'Start date']) !!}
                                    </div>
                                </div>
                        
                               <div class="col-md-3">
                                    <div class="form-group">
                                            {!! Form::text('end_date', $end_date, ['class' => 'form-control','id'=>'end_date', 'placeholder'=>'End date']) !!}
                                    </div>
                                </div>

                               <div class="col-md-2">
                                   <button type="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                                   <a href="{{url('payment-account')}}"><button type="button" class="btn btn-danger">Clear</button></a>
                                </div>
                    </div>                
                 {!! Form::close() !!}
            <div class="card">
                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <th>Account Type</th>
                                <th>Detail Type</th>
                                <th>Name</th>
                                <!--<th>Description</th>-->
                                <th>Default Tax Code</th>
                                <th>Balance</th>
                                <th>As Of</th>
                                <th>Action</th>
                            </thead>
                            @if($payment_accounts->count()>0)
                                <tbody>
                                    <?php $i=1;?>
                                    @foreach($payment_accounts as $payment_account)
                                        <tr>
                                            <td>{{\App\Models\Globals\PaymentAccount::$account_type[$payment_account['account_type']]}}</td>
                                            @if($payment_account['account_type'] == 1)
                                            <td>{{\App\Models\Globals\PaymentAccount::$current_assets[$payment_account['detail_type']]}}</td>
                                            @elseif($payment_account['account_type'] == 2)
                                            <td>{{\App\Models\Globals\PaymentAccount::$bank[$payment_account['detail_type']]}}</td>
                                            @elseif($payment_account['account_type'] == 3)
                                            <td>{{\App\Models\Globals\PaymentAccount::$credit_card[$payment_account['detail_type']]}}</td>
                                            @endif
                                            <td>{{$payment_account['name']}}</td>
                                            <!--<td>{{$payment_account['description']}}</td>-->
                                            <td>{{$payment_account['DefaultTax']['tax_name']}}</td>
                                            <td>{{number_format($payment_account['balance'],2)}}</td>
                                            <td>{{date('d F Y', strtotime($payment_account['as_of']))}}</td>
                                            <td>
                                                <div class="btn-group table-icons-box" role="group" aria-label="Basic example">
                                                     <a href="{{url('payment-account/edit/'.$payment_account['id'])}}" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Update"><i class="fas fa-edit"></i></a>
                                                    <a href="javascript:;" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="delete_report_records({{$payment_account['id']}});"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++;?>
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
                        <div class="fixed-table-pagination">
                            <div class="float-right pagination mr-3">
                                @include('inc.pagination', ['paginator' => $payment_accounts])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type='text/javascript'>
        function delete_report_records(report_id){
            Swal.fire({
                title: 'Do you want to delete this?',
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#01c0c8",
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href= '{{url('payment-account/delete')}}/'+report_id;
                }
            })
        }
    </script>
@endsection
