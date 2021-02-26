@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Change Password</h4>
        </div>
    </div>

    <x-emailverification/>

    <div class="content">
        @include('inc.message2')
        <div class="row">
            <div class="col-lg-12">
                <div class="box card">
                    {!! Form::model($user,['url' => url('update_password/'.$user->id),'method'=>'patch' ,'id'=>'passwordForm', 'class' => 'form-horizontal','files'=>true]) !!}
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="old_password">Old Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="old_password" class="form-control" >
                            @error('old_password')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6"></div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="password">New Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" class="form-control" >
                            @error('password')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-6"></div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" >
                            @error('password_confirmation')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" id="submit" name="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@section('page_confirmation_script')
<script src="{{asset('js/page_confirmation_script.js')}}"></script>
@endsection
@endsection
