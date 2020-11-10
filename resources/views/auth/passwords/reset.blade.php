@extends('layouts.app_admin')
@section('content')
    @include('inc.message')
    <form class="form-horizontal form-material" id="resetpasswordform" action="{{ route('password.request') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="text-center">
            <a href="javascript:void(0)" class="db"><img src="{{url('assets/images/logo-light-icon_old.png')}}" alt="Home" /></a>
        </div>
        <h3 class="box-title m-t-40 m-b-0">Reset Password</h3><small>Change your password here</small>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email" required="" placeholder="Email">
                @if ($errors->has('email'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password" required="" placeholder="Password">
                @if ($errors->has('password'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" type="password" name="password_confirmation" required="" placeholder="Confirm Password">
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset Password</button>
            </div>
        </div>
    </form>
@endsection
