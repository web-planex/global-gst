@extends('layouts.app')
@section('content')
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">@if(isset($payment_terms)) Edit @else Add @endif Payment Terms</h4>
    </div>
</div>
<div class="content">
    @include('inc.message2')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                @if(isset($payment_terms) && !empty($payment_terms))
                    {!! Form::model($payment_terms,['url' =>url('payment-terms/'.$payment_terms->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'PaymentTermsForm']) !!}
                @else
                    {!! Form::open(['url' => url('payment-terms'), 'class' => 'form-horizontal','files'=>true,'id'=>'PaymentTermsForm']) !!}
                @endif
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="terms_name">Terms Name <span class="text-danger">*</span></label>
                            {!! Form::text('terms_name', null, ['class' => 'form-control','id'=>'terms_name']) !!}
                            @if ($errors->has('terms_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('terms_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="terms_days">Terms Days</label>
                            {!! Form::number('terms_days', null, ['class' => 'form-control','id'=>'terms_days']) !!}
                            @if ($errors->has('terms_days'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('terms_days') }}</strong>
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
        $(document).ready(function() {
            $("#PaymentTermsForm").validate({
                rules: {
                    terms_name: "required",
                    terms_days: "required"
                },
                messages: {
                    terms_name: "The terms name field is required",
                    terms_days: "The terms days field is required"
                }
            });
        });
    </script>
@endsection
