@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Account</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{route('payment-account-add')}}" class="btn sync-orders-btn waves-effect waves-light btn-warning">New Payment Account</a>
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
                                <th>Account Type</th>
                                <th>Detail Type</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Default Tax Code</th>
                                <th>Balance</th>
                                <th>As Of</th>
                            </thead>
                            <tbody>
                                @if($payment_accounts->count()>0)
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
                                            <td>{{$payment_account['description']}}</td>
                                            <td>{{$payment_account['default_tax_code']}}</td>
                                            <td>{{number_format($payment_account['balance'],2)}}</td>
                                            <td>{{date('d F Y', strtotime($payment_account['as_of']))}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
