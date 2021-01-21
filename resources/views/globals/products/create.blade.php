@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">@if(isset($products)) Edit @else Add @endif Product / Service</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(isset($products))
                        {!! Form::model($products,['url' => url('products/'.$products->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'ProductsForm']) !!}
                    @else
                        {!! Form::open(['url' => url('products'), 'class' => 'form-horizontal','files'=>true,'id'=>'ProductsForm']) !!}
                    @endif
                    <div class="row" id="Suppliers">
                        <div class="form-group mb-3 col-md-6">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            {!! Form::text('title', null, ['class' => 'form-control','id'=>'title']) !!}
                            @if ($errors->has('title'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="hsn_code">HSN / SAC Code<span class="text-danger"></span></label>
                            {!! Form::text('hsn_code', null, ['class' => 'form-control','id'=>'hsn_code']) !!}
                            @if ($errors->has('hsn_code'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('hsn_code') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="sku">SKU <span class="text-danger"></span></label>
                            {!! Form::text('sku', null, ['class' => 'form-control','id'=>'sku']) !!}
                            @if ($errors->has('sku'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('sku') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="unit">Unit <span class="text-danger"></span></label>
                            {!! Form::select('unit', [''=>'Select Unit']+\App\Models\Globals\Product::$unit, null, ['class' => 'form-control amounts-are-select2', 'id' => 'unit']) !!}
                            @if ($errors->has('unit'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('unit') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="price">Purchase Price<span class="text-danger">*</span></label>
                            {!! Form::number('price', null, ['class' => 'form-control','id'=>'price','step'=>'0.01']) !!}
                            @if ($errors->has('price'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="sale_price">Sale Price<span class="text-danger">*</span></label>
                            {!! Form::number('sale_price', null, ['class' => 'form-control','id'=>'sale_price','step'=>'0.01']) !!}
                            @if ($errors->has('sale_price'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('sale_price') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="memo">Description<span class="text-danger"></span></label>
                            {!! Form::textarea('description', null, ['class' => 'form-control','id'=>'description','rows' => '3']) !!}
                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <div class="row">
                                <label for="status" class="col-md-12">Status <span class="text-danger">*</span></label>
                                @foreach(\App\Models\Globals\Product::$status as $key2 =>$value2)
                                    <?php $checked = $key2 == 1 ?'checked':'';?>
                                    <div class="col-md-2">
                                        <div class="custom-control custom-radio mb-2">
                                            {!! Form::radio('status', $key2, $key2==1?true:null, ['class' => 'custom-control-input', 'id'=>'status_'.$key2]) !!}
                                            <label for="status_{{$key2}}" class="custom-control-label"> {{$value2}}</label>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($errors->has('status'))
                                    <span class="text-danger">
                                       <strong>{{ $errors->first('status') }}</strong>
                                   </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
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