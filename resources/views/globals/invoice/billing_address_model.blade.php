<div class="modal fade bs-example-modal-lg" id="BillingAddressModal" role="dialog" aria-labelledby="BillingAddressModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Billing Address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="overflow-x: hidden;">
                <form id="BillingAddressForm" method="POST" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="customer_id" id="billing_cust_id" value="{{$invoice['customer_id']}}">
                    <div class="row" id="CustomersBillingAddress">
                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="billing_name" class="col-md-12 col-form-label">Billing Name <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('billing_name', isset($invoice) && !empty($invoice)?$invoice['customer']['billing_name']:null, ['class' => 'form-control','id'=>'billing_name_1']) !!}
                                    @if ($errors->has('billing_name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('billing_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="billing_phone" class="col-md-12 col-form-label">Billing Phone <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('billing_phone', isset($invoice) && !empty($invoice)?$invoice['customer']['billing_phone']:null, ['class' => 'form-control','id'=>'billing_phone_1']) !!}
                                    @if ($errors->has('billing_phone'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('billing_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="billing_street" class="col-md-12 col-form-label">Billing Street <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('billing_street', isset($invoice) && !empty($invoice)?$invoice['customer']['billing_street']:null, ['class' => 'form-control','id'=>'billing_street_1']) !!}
                                    @if ($errors->has('billing_street'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('billing_street') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="billing_city" class="col-md-12 col-form-label">Billing City <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('billing_city', isset($invoice) && !empty($invoice)?$invoice['customer']['billing_city']:null, ['class' => 'form-control','id'=>'billing_city_1']) !!}
                                    @if ($errors->has('billing_city'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('billing_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="billing_state" class="col-md-12 col-form-label">Billing State <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    <select name="billing_state" class="form-control amounts-are-select2" id="billing_state_1" style="width: 100%;">
                                        @foreach($address_states as $add)
                                            <option value="{{$add['id']}}" @if(isset($invoice) && !empty($invoice) && $invoice['customer']['billing_state']== $add['id']) selected @endif>{{$add['state_name']}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('billing_state'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('billing_state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="billing_pincode" class="col-md-12 col-form-label">Billing Pincode <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('billing_pincode', isset($invoice) && !empty($invoice)?$invoice['customer']['billing_pincode']:null, ['class' => 'form-control','id'=>'billing_pincode_1']) !!}
                                    @if ($errors->has('billing_pincode'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('billing_pincode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="BillingBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>