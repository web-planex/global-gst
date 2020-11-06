@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Payees Add</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                 <div class="card-body">
                     @if(!isset($user))
                        <div class="row">
                         <div class="col-md-6">
                             <div class="form-group mb-3 row">
                                 <label for="type" class="col-md-12 col-form-label">Type</label>
                                 <div class="col-md-9">
                                     {!! Form::select('type', \App\Models\Globals\Payees::$type, null, ['class' => 'form-control', 'id'=>'type_selection']) !!}
                                     @if ($errors->has('type'))
                                         <span class="text-danger">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                     @endif
                                 </div>
                             </div>
                         </div>
                     </div>
                     @endif
                     <!----------------Suppliers Form---------------->
                     @if(isset($payee) && isset($user))
                         {!! Form::model($user,['url' => url('payees/update/'.$payee->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'signupSuppliersForm']) !!}
                     @else
                         {!! Form::open(['url' => url('payees'), 'class' => 'form-horizontal','files'=>true,'id'=>'signupSuppliersForm']) !!}
                     @endif
                         <input type="hidden" name="type" value="1">
                         <div class="row @if(isset($payee) && $payee['type'] != 1) hide @endif " id="Suppliers">
                             <div class="col-md-6">
                                 <div class="form-group mb-3 row">
                                     <label for="first_name" class="col-md-12 col-form-label">First Name *</label>
                                     <div class="col-md-9">
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
                                     <label for="last_name" class="col-md-12 col-form-label">Last Name *</label>
                                     <div class="col-md-9">
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
                                     <label for="email" class="col-md-12 col-form-label">Email *</label>
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <label for="mobile" class="col-md-12 col-form-label">Mobile *</label>
                                     <div class="col-md-9">
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
                                     <label for="display_name" class="col-md-12 col-form-label">Display Name *</label>
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <label for="street" class="col-md-12 col-form-label">Street *</label>
                                     <div class="col-md-9">
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
                                     <label for="city" class="col-md-12 col-form-label">City *</label>
                                     <div class="col-md-9">
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
                                     <label for="state" class="col-md-12 col-form-label">State *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('state', null, ['class' => 'form-control']) !!}
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
                                     <label for="pincode" class="col-md-12 col-form-label">Pincode *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('pincode', null, ['class' => 'form-control']) !!}
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
                                     <label for="country" class="col-md-12 col-form-label">Country *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('country', null, ['class' => 'form-control']) !!}
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
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                <button type="submit" class="btn btn-primary">Save</button>
                             </div>
                         </div>
                     {!! Form::close() !!}

                     <!----------------Employees Form---------------->
                     @if(isset($payee) && isset($user))
                         {!! Form::model($user,['url' => url('payees/update/'.$payee->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'signupEmployeesForm']) !!}
                     @else
                         {!! Form::open(['url' => url('payees'), 'class' => 'form-horizontal','files'=>true,'id'=>'signupEmployeesForm']) !!}
                     @endif
                         <input type="hidden" name="type" value="2">
                         <div class="row @if(isset($payee) && $payee['type'] == 2) show @else hide @endif" id="Employees">
                             <div class="col-md-6">
                                 <div class="form-group mb-3 row">
                                     <label for="first_name" class="col-md-12 col-form-label">First Name *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
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
                                     <label for="last_name" class="col-md-12 col-form-label">Last Name *</label>
                                     <div class="col-md-9">
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
                                     <label for="email" class="col-md-12 col-form-label">Email *</label>
                                     <div class="col-md-9">
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
                                     <label for="display_name" class="col-md-12 col-form-label">Display Name *</label>
                                     <div class="col-md-9">
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
                                     <label for="phone" class="col-md-12 col-form-label">Phone</label>
                                     <div class="col-md-9">
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
                                     <label for="mobile" class="col-md-12 col-form-label">Mobile *</label>
                                     <div class="col-md-9">
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
                                     <label for="street" class="col-md-12 col-form-label">Street *</label>
                                     <div class="col-md-9">
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
                                     <label for="city" class="col-md-12 col-form-label">City *</label>
                                     <div class="col-md-9">
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
                                     <label for="state" class="col-md-12 col-form-label">State *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('state', null, ['class' => 'form-control']) !!}
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
                                     <label for="pincode" class="col-md-12 col-form-label">Pincode *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('pincode', null, ['class' => 'form-control']) !!}
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
                                     <label for="country" class="col-md-12 col-form-label">Country *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('country', null, ['class' => 'form-control']) !!}
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
                                     <label for="gender" class="col-md-12 col-form-label">Gender *</label>
                                     @foreach(\App\Models\Globals\Employees::$gender as $key2 =>$value2)
                                         <?php $checked = $key2 == 1 ?'checked':'';?>
                                         <div class="col-md-2">
                                             <div class="custom-control custom-radio mb-2">
                                                 {!! Form::radio('gender', $key2, $key2==1?true:null, ['class' => 'custom-control-input', 'id'=>'gender_'.$key2]) !!}
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
                                     <label for="hire_date" class="col-md-12 col-form-label">Hire Date *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('hire_date', null, ['class' => 'form-control','id'=>'hire_date']) !!}
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
                                         {!! Form::text('released', null, ['class' => 'form-control','id'=>'released']) !!}
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
                                         {!! Form::text('date_of_birth', null, ['class' => 'form-control','id'=>'date_of_birth']) !!}
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
                                     <label for="notes" class="col-md-12 col-form-label">Note</label>
                                     <div class="col-md-9">
                                         {!! Form::textarea('notes',null,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
                                         @if ($errors->has('notes'))
                                             <span class="text-danger">
                                                <strong>{{ $errors->first('notes') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                             </div>

                             <div class="form-group col-md-12 mb-0">
                                 <button type="submit" class="btn btn-primary">Save</button>
                             </div>
                        </div>
                     {!! Form::close() !!}

                     <!----------------Customer Form---------------->
                     @if(isset($payee) && isset($user))
                        {!! Form::model($user,['url' => url('payees/update/'.$payee->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'signupCustomersForm']) !!}
                     @else
                        {!! Form::open(['url' => url('payees'), 'class' => 'form-horizontal','files'=>true,'id'=>'signupCustomersForm']) !!}
                     @endif
                        <input type="hidden" name="type" value="3">
                        <div class="row @if(isset($payee) && $payee['type'] == 3) show @else hide @endif" id="Customers">
                            <div class="col-md-6">
                                 <div class="form-group mb-3 row">
                                     <label for="first_name" class="col-md-12 col-form-label">First Name *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
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
                                     <label for="last_name" class="col-md-12 col-form-label">Last Name *</label>
                                     <div class="col-md-9">
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
                                     <label for="email" class="col-md-12 col-form-label">Email *</label>
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <label for="mobile" class="col-md-12 col-form-label">Mobile *</label>
                                     <div class="col-md-9">
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
                                     <label for="display_name" class="col-md-12 col-form-label">Display Name *</label>
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
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
                                     <div class="col-md-9">
                                         {!! Form::select('gst_registration_type_id', \App\Models\Globals\Payees::$get_type, null, ['class' => 'form-control']) !!}
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
                                         {!! Form::text('gstin', null, ['class' => 'form-control']) !!}
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
                                     <label for="billing_street" class="col-md-12 col-form-label">Billing Street *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('billing_street', null, ['class' => 'form-control']) !!}
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
                                     <label for="billing_city" class="col-md-12 col-form-label">Billing City *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('billing_city', null, ['class' => 'form-control']) !!}
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
                                     <label for="billing_state" class="col-md-12 col-form-label">Billing State *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('billing_state', null, ['class' => 'form-control']) !!}
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
                                     <label for="billing_pincode" class="col-md-12 col-form-label">Billing Pincode *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('billing_pincode', null, ['class' => 'form-control']) !!}
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
                                     <label for="billing_country" class="col-md-12 col-form-label">Billing Country *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('billing_country', null, ['class' => 'form-control']) !!}
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
                                     <label for="shipping_street" class="col-md-12 col-form-label">Shipping Street *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('shipping_street', null, ['class' => 'form-control']) !!}
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
                                     <label for="shipping_city" class="col-md-12 col-form-label">Shipping City *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('shipping_city', null, ['class' => 'form-control']) !!}
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
                                     <label for="shipping_state" class="col-md-12 col-form-label">Shipping State *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('shipping_state', null, ['class' => 'form-control']) !!}
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
                                     <label for="shipping_pincode" class="col-md-12 col-form-label">Shipping Pincode *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('shipping_pincode', null, ['class' => 'form-control']) !!}
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
                                     <label for="shipping_country" class="col-md-12 col-form-label">Shipping Country *</label>
                                     <div class="col-md-9">
                                         {!! Form::text('shipping_country', null, ['class' => 'form-control']) !!}
                                         @if ($errors->has('shipping_country'))
                                             <span class="text-danger">
                                                <strong>{{ $errors->first('shipping_country') }}</strong>
                                            </span>
                                         @endif
                                     </div>
                                 </div>
                            </div>

                            <div class="form-group col-md-12 mb-0">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                     {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#type_selection').change(function(){
            var tval = $(this).find(":selected").text();
            $('#type_selection > option').each(function() {
                $('#'+$(this).text()).addClass('hide');
                $('#'+$(this).text()).removeClass('show');
                if(tval == $(this).text()) {
                    $('#'+$(this).text()).addClass('show');
                    $('#'+$(this).text()).removeClass('hide');
                    return;
                }
            });
            $('.err-msg').remove();
        });

        $().ready(function() {
            $("#signupSuppliersForm").validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    display_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: "required",
                    street: "required",
                    city: "required",
                    state: "required",
                    pincode: "required",
                    country: "required",
                    gender: "required",
                    hire_date: "required",
                    billing_street: "required",
                    billing_city: "required",
                    billing_state: "required",
                    billing_pincode: "required",
                    billing_country: "required",
                    shipping_street: "required",
                    shipping_city: "required",
                    shipping_state: "required",
                    shipping_pincode: "required",
                    shipping_country: "required",
                },
                messages: {
                    first_name: "The firstname field is required",
                    last_name: "The lastname field is required",
                    display_name: {
                        required: "The displayname field is required",
                    },
                    email: "Please enter a valid email address",
                    mobile: "The mobile field is required",
                    street: "The street field is required",
                    city: "The city field is required",
                    state: "The state field is required",
                    pincode: "The pincode field is required",
                    country: "The country field is required",
                    gender: "The gender field is required",
                    hire_date: "The hire date field is required",
                    billing_street: "The billing street field is required",
                    billing_city: "The billing city field is required",
                    billing_state: "The billing state field is required",
                    billing_pincode: "The billing pincode field is required",
                    billing_country: "The billing country field is required",
                    shipping_street: "The shipping street field is required",
                    shipping_city: "The shipping city field is required",
                    shipping_state: "The shipping state field is required",
                    shipping_pincode: "The shipping pincode field is required",
                    shipping_country: "The shipping country field is required",

                }
            });

            $("#signupEmployeesForm").validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    display_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: "required",
                    street: "required",
                    city: "required",
                    state: "required",
                    pincode: "required",
                    country: "required",
                    gender: "required",
                    hire_date: "required",
                    billing_street: "required",
                    billing_city: "required",
                    billing_state: "required",
                    billing_pincode: "required",
                    billing_country: "required",
                    shipping_street: "required",
                    shipping_city: "required",
                    shipping_state: "required",
                    shipping_pincode: "required",
                    shipping_country: "required",
                },
                messages: {
                    first_name: "The firstname field is required",
                    last_name: "The lastname field is required",
                    display_name: {
                        required: "The displayname field is required",
                    },
                    email: "Please enter a valid email address",
                    mobile: "The mobile field is required",
                    street: "The street field is required",
                    city: "The city field is required",
                    state: "The state field is required",
                    pincode: "The pincode field is required",
                    country: "The country field is required",
                    gender: "The gender field is required",
                    hire_date: "The hire date field is required",
                    billing_street: "The billing street field is required",
                    billing_city: "The billing city field is required",
                    billing_state: "The billing state field is required",
                    billing_pincode: "The billing pincode field is required",
                    billing_country: "The billing country field is required",
                    shipping_street: "The shipping street field is required",
                    shipping_city: "The shipping city field is required",
                    shipping_state: "The shipping state field is required",
                    shipping_pincode: "The shipping pincode field is required",
                    shipping_country: "The shipping country field is required",

                }
            });

            $("#signupCustomersForm").validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    display_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: "required",
                    street: "required",
                    city: "required",
                    state: "required",
                    pincode: "required",
                    country: "required",
                    gender: "required",
                    hire_date: "required",
                    billing_street: "required",
                    billing_city: "required",
                    billing_state: "required",
                    billing_pincode: "required",
                    billing_country: "required",
                    shipping_street: "required",
                    shipping_city: "required",
                    shipping_state: "required",
                    shipping_pincode: "required",
                    shipping_country: "required",
                },
                messages: {
                    first_name: "The firstname field is required",
                    last_name: "The lastname field is required",
                    display_name: {
                        required: "The displayname field is required",
                    },
                    email: "Please enter a valid email address",
                    mobile: "The mobile field is required",
                    street: "The street field is required",
                    city: "The city field is required",
                    state: "The state field is required",
                    pincode: "The pincode field is required",
                    country: "The country field is required",
                    gender: "The gender field is required",
                    hire_date: "The hire date field is required",
                    billing_street: "The billing street field is required",
                    billing_city: "The billing city field is required",
                    billing_state: "The billing state field is required",
                    billing_pincode: "The billing pincode field is required",
                    billing_country: "The billing country field is required",
                    shipping_street: "The shipping street field is required",
                    shipping_city: "The shipping city field is required",
                    shipping_state: "The shipping state field is required",
                    shipping_pincode: "The shipping pincode field is required",
                    shipping_country: "The shipping country field is required",

                }
            });
        });
    </script>
@endsection
