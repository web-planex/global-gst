@extends('layouts.app')
@section('content')
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">@if(isset($payment_method)) Edit @else Add @endif Payment Method</h4>
    </div>
</div>
<div class="content">
    @include('inc.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                @if(isset($payment_method) && !empty($payment_method))
                    {!! Form::model($payment_method,['url' => url('payment-methods/'.$payment_method->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'PaymentMethodForm']) !!}
                @else
                    {!! Form::open(['url' => url('payment-methods'), 'class' => 'form-horizontal','files'=>true,'id'=>'PaymentMethodForm']) !!}
                @endif
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="method_name">Method Name <span class="text-danger">*</span></label>
                            {!! Form::text('method_name', null, ['class' => 'form-control','id'=>'method_name']) !!}
                            @if ($errors->has('method_name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('method_name') }}</strong>
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
    $(document).ready(function() {
        $("#PaymentMethodForm").validate({
            rules: {
                method_name: "required"
            },
            messages: {
                method_name: "The method name field is required"
            }
        });
    });
</script>
@endsection
