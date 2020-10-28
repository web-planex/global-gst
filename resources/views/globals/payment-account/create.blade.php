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
                            <label for="inputEmail4">Account Type *</label>
                            <select id="accountType" class="form-control">
                                <option value="Current assets">Current assets</option>
                                <option value="Bank">Bank</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="inputPassword4">Detail Type *</label>
                            <select id="accountType" class="form-control">
                                <option value="Current assets">Current assets</option>
                                <option value="Bank">Bank</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="inputAddress">Name *</label>
                            <input type="text" class="form-control" id="name" placeholder="">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="inputAddress2">Description</label>
                            <input type="text" class="form-control" id="description" placeholder="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="inputCity">Default Tax Code</label>
                            <select id="inputState" class="form-control">
                                <option>18.0% IGST</option>
                                <option>14.00% ST</option>
                                <option>0% IGST</option>
                                <option>Out of Scope</option>
                                <option>0% GST</option>
                                <option>14.5% ST</option>
                                <option>14.00% ST</option>
                                <option>14.00% ST</option>
                                <option>14.00% ST</option>
                                <option>14.00% ST</option>
                                <option>14.00% ST</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="inputState">State</label>
                            <select id="inputState" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
