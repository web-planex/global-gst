<div class="modal fade bs-example-modal-lg" id="ShippingAddressModal" role="dialog" aria-labelledby="ShippingAddressModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Shipping Address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="ShippingAddressForm" method="POST" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="customer_id" id="shipping_cust_id" value="@if(isset($estimate)) {{$estimate['customer_id']}} @endif">
                    <div class="row" id="Customers">
                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="shipping_name" class="col-md-12 col-form-label">Shipping Name <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('shipping_name', isset($estimate) && !empty($estimate)?$estimate['customer']['shipping_name']:null, ['class' => 'form-control','id'=>'shipping_name_1']) !!}
                                    @if ($errors->has('shipping_name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('shipping_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="shipping_phone" class="col-md-12 col-form-label">Shipping Phone <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('shipping_phone', isset($estimate) && !empty($estimate)?$estimate['customer']['shipping_phone']:null, ['class' => 'form-control','id'=>'shipping_phone_1']) !!}
                                    @if ($errors->has('shipping_phone'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('shipping_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="shipping_street" class="col-md-12 col-form-label">Shipping Street <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('shipping_street', isset($estimate) && !empty($estimate)?$estimate['customer']['shipping_street']:null, ['class' => 'form-control','id'=>'shipping_street_1']) !!}
                                    @if ($errors->has('shipping_street'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('shipping_street') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="shipping_city" class="col-md-12 col-form-label">Shipping City <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('shipping_city', isset($estimate) && !empty($estimate)?$estimate['customer']['shipping_city']:null, ['class' => 'form-control','id'=>'shipping_city_1']) !!}
                                    @if ($errors->has('shipping_city'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('shipping_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="shipping_state" class="col-md-12 col-form-label">Shipping State <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    <select name="shipping_state" class="form-control amounts-are-select2" id="shipping_state_1" style="width: 100%;">
                                        @foreach($address_states as $add)
                                            <option value="{{$add['id']}}" @if(isset($estimate) && !empty($estimate) && $estimate['customer']['shipping_state']== $add['id']) selected @endif>{{$add['state_name']}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('shipping_state'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('shipping_state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3 row">
                                <label for="shipping_pincode" class="col-md-12 col-form-label">Shipping Pincode <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('shipping_pincode', isset($estimate) && !empty($estimate)?$estimate['customer']['shipping_pincode']:null, ['class' => 'form-control','id'=>'shipping_pincode_1']) !!}
                                    @if ($errors->has('shipping_pincode'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('shipping_pincode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="ShippingBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>