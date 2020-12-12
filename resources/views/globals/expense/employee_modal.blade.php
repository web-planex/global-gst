<div class="modal fade bs-example-modal-lg" id="EmployeeModal" role="dialog" aria-labelledby="EmployeeModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="EmployeesForm" action="" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row" id="Employees">
                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="first_name" class="col-md-12 col-form-label">First Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
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
                                    {!! Form::select('state', $states, null, ['class' => 'form-control amounts-are-select2', 'id'=>'emp_state']) !!}
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

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="country" class="col-md-12 col-form-label">Country <span class="text-danger">*</span></label>
                                <div class="col-md-12">
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
                                <label for="gender" class="col-md-12 col-form-label">Gender <span class="text-danger">*</span></label>
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
                                <label for="hire_date" class="col-md-12 col-form-label">Hire Date <span class="text-danger">*</span></label>
                                <div class="col-md-12">
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
                                <div class="col-md-12">
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
                                <div class="col-md-12">
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
                                <div class="col-md-12">
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
                            <button type="submit" id="EmployeeBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
