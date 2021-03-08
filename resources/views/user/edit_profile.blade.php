@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">My Profile</h4>
        </div>
    </div>

    <x-emailverification/>

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
                                <label for="name">Name <span class="text-danger">*</span></label>
                                {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                {!! Form::text('email', null, ['class' => 'form-control','id'=>'email','disabled']) !!}
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                {!! Form::text('mobile', null, ['class' => 'form-control','id'=>'mobile']) !!}
                                @if ($errors->has('mobile'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('mobile') }}</strong>
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
@section('page_confirmation_script')
<script src="{{asset('js/page_confirmation_script.js')}}"></script>
@endsection
    <script>
        $(function(){
            $("#uploadFile").on("change", function(){
                var files = !!this.files ? this.files : [];
                var match = ["image/jpeg", "image/png", "image/jpg"];
                if (!((files[0].type == match[0]) || (files[0].type == match[1]) || (files[0].type == match[2]))){
                    $('#img_msg').html('<strong>Please Select A valid Image File</strong>');
                    $('#img_msg').addClass('show');
                    $('#img_msg').removeClass('hide');
                }else{
                    $('#img_msg').addClass('hide');
                    $('#img_msg').removeClass('show');
                }
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
