@extends('layouts.app')
@section('content')

<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">Add Expense</h4>
    </div>
</div>
<div class="content">
    @include('inc.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                <form action="{{route('payment-account-insert')}}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="payee">Payee *</label>
                            {!! Form::select('payee', [], null, ['class' => 'form-control', 'id' => 'payee']) !!}
                            @if ($errors->has('payee'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payee') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="payment_account">Payment account *</label>
                            {!! Form::select('payment_account', $payment_accounts, null, ['class' => 'form-control', 'id' => 'payment_account']) !!}
                            @if ($errors->has('payment_account'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_account') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_date">Payment date *</label>
                            {!! Form::text('payment_date', null, ['class' => 'form-control','id'=>'payment_date']) !!}
                            @if ($errors->has('payment_date'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_date') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_method">Payment method</label>
                            {!! Form::select('payment_method', \App\Models\Globals\Expense::$payment_method, null, ['class' => 'form-control', 'id' => 'payment_method']) !!}
                            @if ($errors->has('payment_method'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_method') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="red_no">Ref no.</label>
                            {!! Form::text('red_no', null, ['class' => 'form-control','id'=>'red_no']) !!}
                            @if ($errors->has('red_no'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('red_no') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
