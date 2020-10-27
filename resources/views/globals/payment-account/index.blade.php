@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="expense/create">
                    <button type="button" class="btn btn-info float-right mb-2">New Payment Account</button>
                </a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Payment Account</div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th>User</th>
                                
                            </thead>
                            <tbody>
                                @if($payment_accounts->count()>0)
                                    @foreach($payment_accounts as $payment_account)
                                        <tr>
                                            <td>{{$payment_account['id']}}</td>
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
