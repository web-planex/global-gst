@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">@if(isset($products)) Edit @else Add @endif Product</h4>
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
                            <label for="hsn_code">HSN Code<span class="text-danger">*</span></label>
                            {!! Form::text('hsn_code', null, ['class' => 'form-control','id'=>'hsn_code']) !!}
                            @if ($errors->has('hsn_code'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('hsn_code') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="sku">SKU <span class="text-danger">*</span></label>
                            {!! Form::text('sku', null, ['class' => 'form-control','id'=>'sku']) !!}
                            @if ($errors->has('sku'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('sku') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="price">Price<span class="text-danger">*</span></label>
                            {!! Form::number('price', null, ['class' => 'form-control','id'=>'price']) !!}
                            @if ($errors->has('price'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="memo">Description<span class="text-danger">*</span></label>
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
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

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

        $().ready(function() {
            $("#CompaniesForm").validate({
                rules: {
                    company_name: "required",
                    pan_no: "required",
                    gstin: "required",
                    company_email: "required",
                    company_phone: "required",
                    street: "required",
                    city: "required",
                    state: "required",
                    pincode: "required",
                    country: "required",
                },
                messages: {
                    company_name: "The company name field is required",
                    pan_no: "The pan number field is required",
                    gstin: "The gstin field is required",
                    company_email: "Please enter a valid email address",
                    company_phone: "The company phone field is required",
                    street: "The street field is required",
                    city: "The city field is required",
                    state: "The state field is required",
                    pincode: "The pincode field is required",
                    country: "The country field is required",
                }
            });
        });
    </script>
@endsection