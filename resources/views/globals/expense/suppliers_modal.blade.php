<div class="modal fade bs-example-modal-lg" id="SuppliersModal" role="dialog" aria-labelledby="SuppliersModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Supplier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="SuppliersForm" action="" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row" id="Suppliers">
                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="first_name" class="col-md-12 col-form-label">First Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('first_name', null, ['class' => 'form-control','id'=>'sf_name']) !!}
                                    <span class="text-danger hide" id="sf_name_msg"></span>
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
                                <label for="last_name" class="col-md-12 col-form-label">Last Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
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
                                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
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
                                    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
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
                                <label for="street" class="col-md-12 col-form-label">Street <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('street', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('street'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('street') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="city" class="col-md-12 col-form-label">City <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('city', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('city'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="state" class="col-md-12 col-form-label">State <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::select('state', $states, null, ['class' => 'form-control amounts-are-select2','id'=>'sup_state','style'=>'width:100%']) !!}
                                    @if ($errors->has('state'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="pincode" class="col-md-12 col-form-label">Pincode <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('pincode', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('pincode'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('pincode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group mb-3 row">--}}
{{--                                <label for="country" class="col-md-12 col-form-label">Country <span class="text-danger">*</span></label>--}}
{{--                                <div class="col-md-12">--}}
{{--                                    {!! Form::text('country', null, ['class' => 'form-control']) !!}--}}
{{--                                    @if ($errors->has('country'))--}}
{{--                                        <span class="text-danger">--}}
{{--                                            <strong>{{ $errors->first('country') }}</strong>--}}
{{--                                        </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="billing_rate" class="col-md-12 col-form-label">Billing Rate (/hr)</label>
                                <div class="col-md-12">
                                    {!! Form::text('billing_rate', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('billing_rate'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('billing_rate') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="pan_no" class="col-md-12 col-form-label">Pan no.</label>
                                <div class="col-md-12">
                                    {!! Form::text('pan_no', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('pan_no'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('pan_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="account_no" class="col-md-12 col-form-label">Account No.</label>
                                <div class="col-md-12">
                                    {!! Form::text('account_no', null, ['class' => 'form-control']) !!}
                                    @if ($errors->has('account_no'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('account_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="apply_tds_for_supplier" class="col-md-12 col-form-label">Apply Tds For Supplier</label>
                                <div class="col-md-1">
                                    {!! Form::checkbox('apply_tds_for_supplier', isset($payee) && $user['apply_tds_for_supplier']==1 ? 1:null, isset($payee) && $user['apply_tds_for_supplier']==1 ? true:false, ['class' => 'form-control']) !!}
                                    @if ($errors->has('apply_tds_for_supplier'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('apply_tds_for_supplier') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="gst_registration_type_id" class="col-md-12 col-form-label">Gst Registration Type</label>
                                <div class="col-md-12">
                                    {!! Form::select('gst_registration_type_id', \App\Models\Globals\Payees::$get_type, null, ['class' => 'form-control', 'id'=>'type_selection']) !!}
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

                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="SupplierBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
