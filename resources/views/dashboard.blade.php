@extends('layouts.app')
@section('content')
<div class="shopi-container">
    <div class="row page-titles">
        <div class="col-md-6 align-self-center">
            <h4 class="text-themecolor">Dashboard</h4>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-6">
            <a href="{{url('expense')}}" class="text-dark">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-success"><i class="fa fa-money"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_expense}}</h3>
                                <h5 class="text-muted m-b-0">Expenses</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{url('payees')}}" class="text-dark">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-danger"><i class="fa fa-user-plus"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_payee}}</h3>
                                <h5 class="text-muted m-b-0">Payees</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{url('payment-account')}}" class="text-dark">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-primary"><i class="fa fa-credit-card"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_payment_account}}</h3>
                                <h5 class="text-muted m-b-0">Payment Accounts</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

