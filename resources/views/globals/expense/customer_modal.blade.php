<div class="modal fade bs-example-modal-lg" id="CustomersModal" role="dialog" aria-labelledby="CustomersModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="CustomersForm" action="" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row" id="Customers">
                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="first_name" class="col-md-12 col-form-label">First Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('first_name', null, ['class' => 'form-control','id'=>'fname']) !!}
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="last_name" class="col-md-12 col-form-label">Last Name <span class="text-danger"></span></label>
                                <div class="col-md-12">
                                    {!! Form::text('last_name', null, ['class' => 'form-control','id'=>'lname']) !!}
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="email" class="col-md-12 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="company" class="col-md-12 col-form-label">Company</label>
                                <div class="col-md-12">
                                    {!! Form::text('company', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('company'))
                                        <span class="text-danger">
                                                <strong>{{ $errors->first('company') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="phone" class="col-md-12 col-form-label">Phone</label>
                                <div class="col-md-12">
                                    {!! Form::text('phone', null, ['class' => 'form-control','id'=>'phone']) !!}
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="mobile" class="col-md-12 col-form-label">Mobile <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('mobile', null, ['class' => 'form-control','id'=>'mobile']) !!}
                                    @if ($errors->has('mobile'))
                                        <span class="text-danger">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="display_name" class="col-md-12 col-form-label">Display Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('display_name'))
                                        <span class="text-danger">
                                                <strong>{{ $errors->first('display_name') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="website" class="col-md-12 col-form-label">Website</label>
                                <div class="col-md-12">
                                    {!! Form::text('website', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('website'))
                                        <span class="text-danger">
                                                <strong>{{ $errors->first('website') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="gst_registration_type_id" class="col-md-12 col-form-label">Gst Registration Type</label>
                                <div class="col-md-12">
                                    {!! Form::select('gst_registration_type_id', \App\Models\Globals\Payees::$get_type, null, ['class' => 'form-control amounts-are-select2','style'=>'width:100%']) !!}
                                    @if ($errors->has('gst_registration_type_id'))
                                        <span class="text-danger">
                                                <strong>{{ $errors->first('gst_registration_type_id') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="gstin" class="col-md-12 col-form-label">GSTIN</label>
                                <div class="col-md-12">
                                    {!! Form::text('gstin', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('gstin'))
                                        <span class="text-danger">
                                                <strong>{{ $errors->first('gstin') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h3 class="pt-4">Billing Address</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="billing_name" class="col-md-12 col-form-label">Billing Name <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('billing_name', null, ['class' => 'form-control','id'=>'billing_name']) !!}
                                                    @if ($errors->has('billing_name'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('billing_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="billing_phone" class="col-md-12 col-form-label">Billing Phone <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('billing_phone', null, ['class' => 'form-control','id'=>'billing_phone']) !!}
                                                    @if ($errors->has('billing_phone'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('billing_phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="billing_street" class="col-md-12 col-form-label">Billing Street <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('billing_street', null, ['class' => 'form-control','id'=>'billing_street']) !!}
                                                    @if ($errors->has('billing_street'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('billing_street') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="billing_city" class="col-md-12 col-form-label">Billing City <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('billing_city', null, ['class' => 'form-control','id'=>'billing_city']) !!}
                                                    @if ($errors->has('billing_city'))
                                                        <span class="text-danger">
                                                                <strong>{{ $errors->first('billing_city') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="billing_state" class="col-md-12 col-form-label">Billing State <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::select('billing_state', $states, null, ['class' => 'form-control amounts-are-select2', 'id'=>'billing_state','style'=>'width:100%']) !!}
                                                    @if ($errors->has('billing_state'))
                                                        <span class="text-danger">
                                                                <strong>{{ $errors->first('billing_state') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="billing_pincode" class="col-md-12 col-form-label">Billing Pincode <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('billing_pincode', null, ['class' => 'form-control','id'=>'billing_pincode']) !!}
                                                    @if ($errors->has('billing_pincode'))
                                                        <span class="text-danger">
                                                                <strong>{{ $errors->first('billing_pincode') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="is_shipping" class="col-md-12 col-form-label">Add Shipping Address<span class="text-danger"></span></label>
                                                <div class="col-md-9">
                                                    {!! Form::checkbox('is_shipping', null, false, ['class' => 'js-switch', 'id'=>'is_shipping', 'data-color'=>'#01c0c8', 'data-size'=>'small', 'data-switchery'=>'true','style'=>'display:none;']) !!}
                                                    @if ($errors->has('is_shipping'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('is_shipping') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 hide" id="shipping_address_div">
                            <h3 class="pt-4">Shipping Address</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3 row">
                                                <div class="col-md-12">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="same_as_billing">
                                                        <label class="custom-control-label" for="same_as_billing">Same as Billing Address</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="shipping_name" class="col-md-12 col-form-label">Shipping Name <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('shipping_name', null, ['class' => 'form-control','id'=>'shipping_name']) !!}
                                                    @if ($errors->has('shipping_name'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('shipping_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="shipping_phone" class="col-md-12 col-form-label">Shipping Phone <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('shipping_phone', null, ['class' => 'form-control','id'=>'shipping_phone']) !!}
                                                    @if ($errors->has('shipping_phone'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('shipping_phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="shipping_street" class="col-md-12 col-form-label">Shipping Street <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('shipping_street', null, ['class' => 'form-control','id'=>'shipping_street']) !!}
                                                    @if ($errors->has('shipping_street'))
                                                        <span class="text-danger">
                                                                <strong>{{ $errors->first('shipping_street') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="shipping_city" class="col-md-12 col-form-label">Shipping City <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('shipping_city', null, ['class' => 'form-control','id'=>'shipping_city']) !!}
                                                    @if ($errors->has('shipping_city'))
                                                        <span class="text-danger">
                                                                <strong>{{ $errors->first('shipping_city') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="shipping_state" class="col-md-12 col-form-label">Shipping State <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::select('shipping_state', $states, null, ['class' => 'form-control amounts-are-select2', 'id'=>'shipping_state','style'=>'width:100%']) !!}
                                                    @if ($errors->has('shipping_state'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('shipping_state') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3 row">
                                                <label for="shipping_pincode" class="col-md-12 col-form-label">Shipping Pincode <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    {!! Form::text('shipping_pincode', null, ['class' => 'form-control','id'=>'shipping_pincode']) !!}
                                                    @if ($errors->has('shipping_pincode'))
                                                        <span class="text-danger">
                                                                <strong>{{ $errors->first('shipping_pincode') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

{{--                                        <div class="col-md-12">--}}
{{--                                            <div class="form-group mb-3 row">--}}
{{--                                                <label for="shipping_country" class="col-md-12 col-form-label">Shipping Country <span class="text-danger">*</span></label>--}}
{{--                                                <div class="col-md-12">--}}
{{--                                                    {!! Form::text('shipping_country', null, ['class' => 'form-control','id'=>'shipping_country']) !!}--}}
{{--                                                    @if ($errors->has('shipping_country'))--}}
{{--                                                        <span class="text-danger">--}}
{{--                                                                <strong>{{ $errors->first('shipping_country') }}</strong>--}}
{{--                                                            </span>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="CustomerBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $('#fname').keyup(function(){
       $('#billing_name').val($(this).val());
       $('#shipping_name').val($(this).val());
    });

    $('#lname').keyup(function(){
        $('#billing_name').val($('#fname').val()+' '+$(this).val());
        $('#shipping_name').val($('#fname').val()+' '+$(this).val());
    });

    $('#mobile').keyup(function(){
        $('#billing_phone').val($(this).val());
        $('#shipping_phone').val($(this).val());
    });

    $('#same_as_billing').change(function(){
        if($(this).prop('checked')){
            $('#shipping_name').val($('#billing_name').val());
            $('#shipping_phone').val($('#billing_phone').val());
            $('#shipping_street').val($('#billing_street').val());
            $('#shipping_city').val($('#billing_city').val());
            $('#shipping_state').val($('#billing_state').val()).change();
            $('#shipping_pincode').val($('#billing_pincode').val());
            // $('#shipping_country').val($('#billing_country').val());
        }else{
            $('#shipping_name').val('');
            $('#shipping_phone').val('');
            $('#shipping_street').val('');
            $('#shipping_city').val('');
            $('#shipping_state').val('').change();
            $('#shipping_pincode').val('');
            // $('#shipping_country').val('');
        }
    });
</script>
