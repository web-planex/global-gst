@extends('admin.layout.app')
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
                    {!! Form::model($user,['url' => url('admin/profile_update/'.$user->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true]) !!}
                        @csrf
                        <div class="form-row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                {!! Form::text('email', null, ['class' => 'form-control','id'=>'email']) !!}
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="email">Password <span class="text-danger"></span></label>
                                <input class="form-control" type="password" name="password" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <button type="submit" id="submit" name="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection