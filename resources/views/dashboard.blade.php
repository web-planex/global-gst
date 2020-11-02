@extends('layouts.app')
@section('content')
<div class="shopi-container">
    <header class="pt-3">
      <h1>Dashboard</h1>
      <p class="shopi-subhead">
        <label for="shop">Welcome to GST App</label>
      </p>
    </header>
    <div class="row text-center mb-3">
        <div class="col-md-3">
            <a href="{{url('expense')}}">
                <div class="counter">
                    <i class="fa fa-money fa-2x"></i>
                    <h2 class="timer count-title count-number text-dark" data-to="100" data-speed="1500">{{$total_expense}}</h2>
                    <p class="count-text text-dark">Total Expenses</p>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{url('payees')}}">
                <div class="counter">
                    <i class="fa fa-user-plus fa-2x"></i>
                    <h2 class="timer count-title count-number text-dark" data-to="100" data-speed="1500">{{$total_payee}}</h2>
                    <p class="count-text text-dark">Total Payees</p>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{url('payment-account')}}">
                <div class="counter">
                    <i class="fa fa-credit-card fa-2x"></i>
                    <h2 class="timer count-title count-number text-dark" data-to="100" data-speed="1500">{{$total_payment_account}}</h2>
                    <p class="count-text text-dark">Total Payment Accounts</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

