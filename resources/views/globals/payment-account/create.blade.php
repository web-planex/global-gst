@extends('layouts.app')
@section('content')
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">Account</h4>
    </div>
</div>
<div class="content">
    @include('inc.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                <form>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="accountType">Account Type *</label>
                            {!! Form::select('account_type', \App\Models\Globals\PaymentAccount::$account_type, null, ['class' => 'form-control']) !!}
                            @if ($errors->has('account_type'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('account_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="detailType">Detail Type *</label>
                            <select id="detailType" name="detail_type" class="form-control">
                                <option value="Current assets">Current assets</option>
                                <option value="Bank">Bank</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                            @if ($errors->has('detail_type'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('detail_type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="name">Name *</label>
                            {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="description">Description</label>
                            {!! Form::text('description', null, ['class' => 'form-control','id'=>'description']) !!}
                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-5">
                            <label for="defaultTaxCode">Default Tax Code</label>
                            <select id="defaultTaxCode" name="default_tax_code" class="form-control">
                                @foreach($taxes as $tax)
                                    <option value="{{$tax['tax_name']}}">{{$tax['tax_name']}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('default_tax_code'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('default_tax_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="balance">Balance</label>
                            {!! Form::text('balance', null, ['class' => 'form-control','id'=>'balance']) !!}
                            @if ($errors->has('balance'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('balance') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            <label for="as_of">As Of</label>
                            {!! Form::text('as_of', null, ['class' => 'form-control','id'=>'as_of']) !!}
                            @if ($errors->has('as_of'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('as_of') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
