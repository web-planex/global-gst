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
                            <select id="accountType" name="account_type" class="form-control">
                                @foreach(\App\Models\Globals\PaymentAccount::$account_type as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="detailType">Detail Type *</label>
                            <select id="detailType" name="detail_type" class="form-control">
                                <option value="Current assets">Current assets</option>
                                <option value="Bank">Bank</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="">
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
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="balance">Balance</label>
                            <input type="text" class="form-control" id="balance" name="balance" placeholder="">
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            <label for="as_of">As Of</label>
                            <input type="text" class="form-control" id="as_of" placeholder="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
