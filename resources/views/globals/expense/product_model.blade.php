<div class="modal fade bs-example-modal-lg" id="ProductModal" tabindex="-1" role="dialog" aria-labelledby="ProductModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="ProductForm" action="" method="POST" class="form-horizontal">
                    @csrf
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
                                    <div class="col-md-3">
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
                            <button type="submit" id="ProductBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
