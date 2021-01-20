@extends('layouts.app')
@section('content')
<div class="shopi-container">
    <div class="row page-titles">
        <div class="col-md-6 align-self-center">
            <h4 class="text-themecolor">Dashboard</h4>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-lg-3 col-md-6">
            <a href="{{url('products')}}" class="text-dark">
                <div class="card mr-1">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-primary"><i class="fab  fa-product-hunt"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_product}}</h3>
                                <h5 class="text-muted m-b-0">Products</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{url('expense')}}" class="text-dark">
                <div class="card mr-1">
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
            <a href="{{route('bills.index')}}" class="text-dark">
                <div class="card mr-1">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-success"><i class="fa fa-money"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_bills}}</h3>
                                <h5 class="text-muted m-b-0">Bills</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{url('sales')}}" class="text-dark">
                <div class="card mr-1">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-danger"><i class="fa fa-line-chart"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_sales}}</h3>
                                <h5 class="text-muted m-b-0">Invoices</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{url('credit-note')}}" class="text-dark">
                <div class="card mr-1">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-warning"><i class="fas fa-clipboard"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_credit_note}}</h3>
                                <h5 class="text-muted m-b-0">Credit Notes</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{url('payees')}}" class="text-dark">
                <div class="card mr-1">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-primary"><i class="fa fa-user-plus"></i></div>
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
            <a href="{{url('companies')}}" class="text-dark">
                <div class="card mr-1">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="round align-self-center round-danger"><i class="fa fa-building"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">{{$total_companies}}</h3>
                                <h5 class="text-muted m-b-0">Companies</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

