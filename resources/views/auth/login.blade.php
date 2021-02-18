@extends('layouts.app_admin')
@section('content')

    <form class="form-horizontal form-material" id="loginform" method="post" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="text-center">
            <a href="{{url('/')}}" class="db"><img src="{{url('assets/images/logo_2.png')}}" alt="Home" /></a>
        </div>
        <h3 class="box-title m-t-40 m-b-0">Login Now</h3><small>Create your session and enjoy</small>
        <div class="form-group m-t-20">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email" required="" placeholder="Email">
                @if ($errors->has('email'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password" required="" placeholder="Password">
                @if ($errors->has('password'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <div class="d-flex no-block align-items-center">
                    <div class="ml-auto">
                        <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fas fa-lock m-r-5"></i> Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                <div class="social">
                    <a href="{{ url('auth/google') }}">
                        <button type="button" class="btn btn-googleplus"> <i aria-hidden="true" class="fab fa-google-plus-g pr-4"></i> <span>Login with Google</span> </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                Don't have an account? <a href="{{url('register')}}" class="text-primary m-l-5"><b>Register Here</b></a>
            </div>
        </div>
    </form>

    <form class="form-horizontal" id="recoverform" action="{{ route('password.email') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group ">
            <div class="col-xs-12">
                <h3>Recover Password</h3>
                <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email" id="recover_email" placeholder="Email">
                <span class="text-danger hide" id="recover_email_msg"></span>
                @if ($errors->has('recover_email'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('recover_email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" id="forgot_password_btn_132" type="submit">Reset</button>
            </div>
        </div>

        <span class="text-danger hide" id="email_link"></span>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="d-flex no-block align-items-center">
                    <div class="ml-auto">
                        <a href="javascript:void(0)" id="to-login" class="text-muted">Back To Login</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection