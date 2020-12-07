@extends('layouts.app')
@section('content')
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">@if(isset($payment_account)) Edit @else Add @endif Account</h4>
    </div>
</div>
<div class="content">
    @include('inc.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                @if(isset($payment_account) && !empty($payment_account))
                    {!! Form::model($payment_account,['url' => url('payment-account/addedit/'.$payment_account->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'signupSuppliersForm']) !!}
                @else
                    {!! Form::open(['url' => url('payment-account/addedit'), 'class' => 'form-horizontal','files'=>true,'id'=>'signupSuppliersForm']) !!}
                @endif
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="accountType">Account Type <span class="text-danger">*</span></label>
                            {!! Form::select('account_type', \App\Models\Globals\PaymentAccount::$account_type, null, ['class' => 'form-control', 'id' => 'accountType']) !!}
                            @if ($errors->has('account_type'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('account_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="detailType">Detail Type <span class="text-danger">*</span></label>
                            {!! Form::select('detail_type', \App\Models\Globals\PaymentAccount::$current_assets, null, ['class' => 'form-control', 'id' => 'detailType']) !!}
                            @if ($errors->has('detail_type'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('detail_type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
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
                            <label for="description">Description</label>
                            {!! Form::text('description', null, ['class' => 'form-control','id'=>'description']) !!}
                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="defaultTaxCode">Default Tax Code</label>
                            {!! Form::select('default_tax_code', $taxes, null, ['class' => 'form-control', 'id' => 'defaultTaxCode']) !!}
                            @if ($errors->has('default_tax_code'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('default_tax_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="balance">Balance</label>
                            {!! Form::number('balance', null, ['class' => 'form-control','id'=>'balance']) !!}
                            @if ($errors->has('balance'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('balance') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            <label for="as_of">As Of</label>
                            {!! Form::text('as_of', null, ['class' => 'form-control','id'=>'as_of']) !!}
                            @if ($errors->has('as_of'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('as_of') }}</strong>
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
<script type="text/javascript">
    $(document).ready(function(){
        var val = $('#detailType').find(":selected").text();
        $('#name').val(val);
        $('#detailType').on('change',function(){
            var val = $(this).find(":selected").text();
            $('#name').val(val);
        });

        $('#accountType').change(function(){
            var name = $(this).find(":selected").text();
            $.ajax({
                method: "POST",
                url: "{{ route('ajax-get-account-type') }}",
                data: { name: name }
            }).done(function(data) {
                $("#detailType").empty();
                    $("#detailType").append("<option value='"+i+"'>"+val+"</option>");
                });
                var val = $('#detailType').find(":selected").text();
                $('#name').val(val);
            });
        });
    });
</script>
@endsection
