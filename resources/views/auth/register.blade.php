@extends('layouts.app_admin')
@section('content')
    <style>
        .alert{
            margin-top: 1rem!important;
        }
    </style>
    <form class="form-horizontal form-material" id="RegisterForm" action="{{ route('register') }}" method="post">
        {{ csrf_field() }}
        <div class="text-center">
            <a href="{{url('/')}}" class="db"><img src="{{url('assets/images/logo_2.png')}}" alt="Home" /></a>
        </div>
        @include('inc.message')
        <h3 class="box-title m-t-20 m-b-0">Register Now</h3><small>Create your account and enjoy</small>
        <div class="form-group m-t-20">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="name"  placeholder="Name">
                @error('name')
                <span class="text-danger" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email"  placeholder="Email">
                @error('email')
                <span class="text-danger" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="company_name"  placeholder="Company Name">
                @error('company_name')
                <span class="text-danger" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="number" name="phone_number" placeholder="Phone Number" >
                @error('phone_number')
                <span class="text-danger" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
{{--        <div class="form-group ">--}}
{{--            <div class="col-xs-12">--}}
{{--                <input class="form-control" type="text" name="company_email"  placeholder="Company Email">--}}
{{--                @error('company_email')--}}
{{--                <span class="text-danger" role="alert" style="color: #a94442!important;">--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                </span>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password" id="password"  placeholder="Password">
                @error('password')
                <span class="text-danger" role="alert" style="color: #a94442!important;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password_confirmation"  placeholder="Confirm Password">
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
