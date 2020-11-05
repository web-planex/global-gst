@extends('layouts.app_admin')
@section('content')
    <form class="form-horizontal form-material" id="loginform" action="{{ route('register') }}" method="post">
        {{ csrf_field() }}
        <div class="text-center">
            <a href="javascript:void(0)" class="db"><img src="{{url('assets/images/logo-light-icon_old.png')}}" alt="Home" /></a>
        </div>
        <h3 class="box-title m-t-40 m-b-0">Register Now</h3><small>Create your account and enjoy</small>
        <div class="form-group m-t-20">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="name" required="" placeholder="Name">
                @error('name')
                <span class="invalid-feedback" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email" required="" placeholder="Email">
                @error('email')
                <span class="invalid-feedback" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password" required="" placeholder="Password">
                @error('password')
                <span class="help-block" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password_confirmation" required="" placeholder="Confirm Password">
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Register</button>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                <p>Already have an account? <a href="{{url('login')}}" class="text-info m-l-5"><b>Login Here</b></a></p>
            </div>
        </div>
    </form>
@endsection
