@extends('layouts.app_admin')
@section('content')
    <form class="form-horizontal form-material" id="adminloginform" method="post" action="{{ route('admin-login-post') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="admin">
        <div class="text-center">
            <a href="{{url('/')}}" class="db"><img src="{{url('assets/images/logo_2.png')}}" alt="Home" /></a>
        </div>
        <h3 class="box-title m-t-40 m-b-0">Login Now</h3><small>Create your session and enjoy</small>
        @include('inc.message2')
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
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>
    </form>
@endsection
