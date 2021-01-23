@extends('layouts.app')
@section('content')
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor"><i class="fa fa-envelope"></i>&nbsp;Email Template</h4>
    </div>
</div>
<div class="content">
    @include('inc.message2')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                <h4 class="card-title font-16">{{$template['name']}} Email Template Content</h4>
                @error('body')
                    <span class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                {!! Form::model($template,['url' => route('update-email-template',['slug'=>$template['slug']]),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'formEmailTemplate']) !!}
                {!! Form::textarea('body', $template['body'], ['class' => 'form-control', 'id' => 'message_body', 'rows'=>'10', 'cols'=>'130']) !!}
                <div class="form-row mt-2">
                    <div class="from-group col-md-12">
                        <button type="submit" name="submit" id="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection