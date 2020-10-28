<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="type" class="col-md-12 col-form-label">Type</label>
            <div class="col-md-9">
                <select name="type" id="type_selection" class="form-control">
                    @foreach(\App\Models\Globals\Payees::$type as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
                @if ($errors->has('type'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!----------------Suppliers Form---------------->
<div class="row" id="suppliers">
    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="first_name" class="col-md-12 col-form-label">First Name</label>
            <div class="col-md-9">
                <input type="text" name="first_name" class="form-control">
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
            <label for="last_name" class="col-md-12 col-form-label">Last Name</label>
            <div class="col-md-9">
                <input type="text" name="last_name" class="form-control">
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
            <label for="email" class="col-md-12 col-form-label">Email</label>
            <div class="col-md-9">
                <input type="text" name="email" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="company" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="phone" class="form-control">
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
            <label for="mobile" class="col-md-12 col-form-label">Mobile</label>
            <div class="col-md-9">
                <input type="text" name="mobile" class="form-control">
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
            <label for="display_name" class="col-md-12 col-form-label">Display Name</label>
            <div class="col-md-9">
                <input type="text" name="display_name" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="website" class="form-control">
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
            <label for="street" class="col-md-12 col-form-label">Street</label>
            <div class="col-md-9">
                <input type="text" name="street" class="form-control">
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
            <label for="city" class="col-md-12 col-form-label">City</label>
            <div class="col-md-9">
                <input type="text" name="city" class="form-control">
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
            <label for="state" class="col-md-12 col-form-label">State</label>
            <div class="col-md-9">
                <input type="text" name="state" class="form-control">
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
            <label for="pincode" class="col-md-12 col-form-label">Pincode</label>
            <div class="col-md-9">
                <input type="text" name="pincode" class="form-control">
                @if ($errors->has('pincode'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('pincode') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="country" class="col-md-12 col-form-label">Country</label>
            <div class="col-md-9">
                <input type="text" name="country" class="form-control">
                @if ($errors->has('country'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="billing_rate" class="col-md-12 col-form-label">Billing Rate (/hr)</label>
            <div class="col-md-9">
                <input type="text" name="billing_rate" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="pan_no" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="account_no" class="form-control">
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
                <input type="checkbox" name="apply_tds_for_supplier" class="form-control">
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
            <div class="col-md-9">
                <select name="gst_registration_type_id" class="form-control">
                    @foreach(\App\Models\Globals\Payees::$get_type as $key1 => $value1)
                        <option value="{{$key1}}">{{$value1}}</option>
                    @endforeach
                </select>
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
            <div class="col-md-9">
                <input type="text" name="gstin" class="form-control">
                @if ($errors->has('gstin'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('gstin') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!----------------Employees Form---------------->
<div class="row" id="employees" style="display: none;">
    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="first_name" class="col-md-12 col-form-label">First Name</label>
            <div class="col-md-9">
                <input type="text" name="first_name" class="form-control">
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
            <label for="last_name" class="col-md-12 col-form-label">Last Name</label>
            <div class="col-md-9">
                <input type="text" name="last_name" class="form-control">
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
            <label for="email" class="col-md-12 col-form-label">Email</label>
            <div class="col-md-9">
                <input type="text" name="email" class="form-control">
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
            <label for="display_name" class="col-md-12 col-form-label">Display Name</label>
            <div class="col-md-9">
                <input type="text" name="display_name" class="form-control">
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
            <label for="phone" class="col-md-12 col-form-label">Phone</label>
            <div class="col-md-9">
                <input type="text" name="phone" class="form-control">
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
            <label for="mobile" class="col-md-12 col-form-label">Mobile</label>
            <div class="col-md-9">
                <input type="text" name="mobile" class="form-control">
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
            <label for="street" class="col-md-12 col-form-label">Street</label>
            <div class="col-md-9">
                <input type="text" name="street" class="form-control">
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
            <label for="city" class="col-md-12 col-form-label">City</label>
            <div class="col-md-9">
                <input type="text" name="city" class="form-control">
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
            <label for="state" class="col-md-12 col-form-label">State</label>
            <div class="col-md-9">
                <input type="text" name="state" class="form-control">
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
            <label for="pincode" class="col-md-12 col-form-label">Pincode</label>
            <div class="col-md-9">
                <input type="text" name="pincode" class="form-control">
                @if ($errors->has('pincode'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('pincode') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="country" class="col-md-12 col-form-label">Country</label>
            <div class="col-md-9">
                <input type="text" name="country" class="form-control">
                @if ($errors->has('country'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="gender" class="col-md-12 col-form-label">Gender</label>
            @foreach(\App\Models\Globals\Employees::$gender as $key2 =>$value2)
                <div class="col-md-2">
                    <div class="custom-control custom-radio mb-2">
                        <input type="radio" class="custom-control-input" name="gender" id="gender_{{$key2}}" value="{{$key2}}">
                        <label for="gender_{{$key2}}" class="custom-control-label"> {{$value2}}</label>
                    </div>
                </div>
            @endforeach
            @if ($errors->has('gender'))
                <span class="text-danger">
                    <strong>{{ $errors->first('gender') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="hire_date" class="col-md-12 col-form-label">Hire Date</label>
            <div class="col-md-9">
                <input type="text" name="hire_date" class="form-control" id="hire_date">
                @if ($errors->has('hire_date'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('hire_date') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="released" class="col-md-12 col-form-label">Released Date</label>
            <div class="col-md-9">
                <input type="text" name="released" class="form-control" id="released">
                @if ($errors->has('released'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('released') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="date_of_birth" class="col-md-12 col-form-label">Date Of Birth</label>
            <div class="col-md-9">
                <input type="text" name="date_of_birth" class="form-control" id="date_of_birth">
                @if ($errors->has('date_of_birth'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="note" class="col-md-12 col-form-label">Note</label>
            <div class="col-md-9">
                <textarea name="note" class="form-control" id="note"></textarea>
                @if ($errors->has('note'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('note') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!----------------Customer Form---------------->
<div class="row" id="customers" style="display: none;">
    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="first_name" class="col-md-12 col-form-label">First Name</label>
            <div class="col-md-9">
                <input type="text" name="first_name" class="form-control">
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
            <label for="last_name" class="col-md-12 col-form-label">Last Name</label>
            <div class="col-md-9">
                <input type="text" name="last_name" class="form-control">
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
            <label for="email" class="col-md-12 col-form-label">Email</label>
            <div class="col-md-9">
                <input type="text" name="email" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="company" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="phone" class="form-control">
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
            <label for="mobile" class="col-md-12 col-form-label">Mobile</label>
            <div class="col-md-9">
                <input type="text" name="mobile" class="form-control">
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
            <label for="display_name" class="col-md-12 col-form-label">Display Name</label>
            <div class="col-md-9">
                <input type="text" name="display_name" class="form-control">
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
            <div class="col-md-9">
                <input type="text" name="website" class="form-control">
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
            <div class="col-md-9">
                <select name="gst_registration_type_id" class="form-control">
                    @foreach(\App\Models\Globals\Payees::$get_type as $key1 => $value1)
                        <option value="{{$key1}}">{{$value1}}</option>
                    @endforeach
                </select>
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
            <div class="col-md-9">
                <input type="text" name="gstin" class="form-control">
                @if ($errors->has('gstin'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('gstin') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="billing_street" class="col-md-12 col-form-label">Billing Street</label>
            <div class="col-md-9">
                <input type="text" name="billing_street" class="form-control">
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
            <label for="billing_city" class="col-md-12 col-form-label">Billing City</label>
            <div class="col-md-9">
                <input type="text" name="billing_city" class="form-control">
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
            <label for="billing_state" class="col-md-12 col-form-label">Billing State</label>
            <div class="col-md-9">
                <input type="text" name="billing_state" class="form-control">
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
            <label for="billing_pincode" class="col-md-12 col-form-label">Billing Pincode</label>
            <div class="col-md-9">
                <input type="text" name="billing_pincode" class="form-control">
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
            <label for="billing_country" class="col-md-12 col-form-label">Billing Country</label>
            <div class="col-md-9">
                <input type="text" name="billing_country" class="form-control">
                @if ($errors->has('billing_country'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('billing_country') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6"></div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="shipping_street" class="col-md-12 col-form-label">Shipping Street</label>
            <div class="col-md-9">
                <input type="text" name="shipping_street" class="form-control">
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
            <label for="shipping_city" class="col-md-12 col-form-label">Shipping City</label>
            <div class="col-md-9">
                <input type="text" name="shipping_city" class="form-control">
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
            <label for="shipping_state" class="col-md-12 col-form-label">Shipping State</label>
            <div class="col-md-9">
                <input type="text" name="shipping_state" class="form-control">
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
            <label for="shipping_pincode" class="col-md-12 col-form-label">Shipping Pincode</label>
            <div class="col-md-9">
                <input type="text" name="shipping_pincode" class="form-control">
                @if ($errors->has('shipping_pincode'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('shipping_pincode') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3 row">
            <label for="shipping_country" class="col-md-12 col-form-label">Shipping Country</label>
            <div class="col-md-9">
                <input type="text" name="shipping_country" class="form-control">
                @if ($errors->has('shipping_country'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('shipping_country') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $('#type_selection').change(function(){
       var tval = $(this).val();
        if(tval == 1){
            $('#employees').hide();
            $('#customers').hide();
            $('#suppliers').show();
        }

       if(tval == 2){
           $('#suppliers').hide();
           $('#customers').hide();
           $('#employees').show();
       }

        if(tval == 3){
            $('#suppliers').hide();
            $('#employees').hide();
            $('#customers').show();
        }
    });
</script>
