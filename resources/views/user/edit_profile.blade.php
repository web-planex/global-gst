@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">My Profile</h4>
        </div>
    </div>
    <div class="content">
        @include('inc.message2')
        <div class="row">
            <div class="col-lg-12">
                <div class="box card">
                    {!! Form::model($user,['url' => url('profile_update/'.$user->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true]) !!}
                        @csrf
                        <h3>Personal Detail</h3>
                        <hr>
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
                                <label for="email">Email *</label>
                                {!! Form::text('email', null, ['class' => 'form-control','id'=>'email']) !!}
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                    <h3 class="pt-4">Company Detail</h3>
                    <hr>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-12">
                            <label for="company_logo">Company Logo</label><br>
                            @if(isset($company))
                                <div id="imagePreview" style="background-image: url({{url($company['company_logo'])}});" class="form-control mt-2"></div>
                            @else
                                <div id="imagePreview" src="" class="form-control mt-2"></div>
                            @endif
                            <input id="uploadFile" type="file" name="company_logo" class="img" />
                            @if ($errors->has('company_logo'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_logo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="company_name">Company Name</label>
                            {!! Form::text('company_name', isset($company)?$company['company_name']:null, ['class' => 'form-control','id'=>'company_name']) !!}
                            @if ($errors->has('company_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="pan_no">Pan No</label>
                            {!! Form::text('pan_no', isset($company)?$company['pan_no']:null, ['class' => 'form-control','id'=>'pan_no']) !!}
                            @if ($errors->has('pan_no'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pan_no') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="gstin">GSTIN</label>
                            {!! Form::text('gstin', isset($company)?$company['gstin']:null, ['class' => 'form-control','id'=>'gstin']) !!}
                            @if ($errors->has('gstin'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('gstin') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="company_email">Company Email</label>
                            {!! Form::text('company_email', isset($company)?$company['company_email']:null, ['class' => 'form-control','id'=>'company_email']) !!}
                            @if ($errors->has('company_email'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="company_phone">Company Phone</label>
                            {!! Form::text('company_phone', isset($company)?$company['company_phone']:null, ['class' => 'form-control','id'=>'company_phone']) !!}
                            @if ($errors->has('company_phone'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('company_phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="website">Website</label>
                            {!! Form::text('website', isset($company)?$company['website']:null, ['class' => 'form-control','id'=>'website']) !!}
                            @if ($errors->has('website'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="street">Street</label>
                            {!! Form::text('street', isset($company)?$company['street']:null, ['class' => 'form-control','id'=>'street']) !!}
                            @if ($errors->has('street'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('street') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="city">City</label>
                            {!! Form::text('city', isset($company)?$company['city']:null, ['class' => 'form-control','id'=>'city']) !!}
                            @if ($errors->has('city'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="state">State</label>
                            {!! Form::text('state', isset($company)?$company['state']:null, ['class' => 'form-control','id'=>'state']) !!}
                            @if ($errors->has('state'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="pincode">Pincode</label>
                            {!! Form::text('pincode', isset($company)?$company['pincode']:null, ['class' => 'form-control','id'=>'pincode']) !!}
                            @if ($errors->has('pincode'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('pincode') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="country">Country</label>
                            {!! Form::text('country', isset($company)?$company['country']:null, ['class' => 'form-control','id'=>'country']) !!}
                            @if ($errors->has('country'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $("#uploadFile").on("change", function(){
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return;
                if (/^image/.test( files[0].type)){
                    var reader = new FileReader();
                    reader.readAsDataURL(files[0]);
                    reader.onloadend = function(){
                        $("#imagePreview").css("background-image", "url("+this.result+")");
                    }
                }
            });
        });

        $('#imagePreview').click(function(){
            $('#uploadFile').click();
        });
    </script>
@endsection
