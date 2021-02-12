@extends('layouts.app')
@section('content')
<style>
    .tr-tax-lable {
        display:block;
        margin-top:10px;
        width:100%;
        padding:5px 0 !important;
        border:none;
    }
    .btn-circle.btn-sm, .btn-group-sm>.btn-circle.btn {
        width: 30px;
        height: 30px;
        padding: 4px 5px!important;
    }
    .discount-type-items {
        height: 36px;
        border: 1px solid #e9ecef;
    }
    td.discount-line-section {
        display: flex;
        align-self: center;
    }
    .discount-line-section input.form-control.discount-items {
        border-radius: .25rem 0 0 .25rem;
        border-right: 0;
    }
    .discount-line-section input.form-control.discount-items:focus {
        outline: none;
        border-color: #e9ecef;
    }
    .discount-line-section select.discount-type-items {
        border-radius: 0 .25rem .25rem 0;
        border: 1px solid #e9ecef;
        border-left: none;
        height: 38px;
    }
</style>
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">@if(isset($bill)) Edit @else New @endif {{$menu}}</h4>
    </div>
</div>
<div class="content">
    @include('inc.message2')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                @if(isset($bill) && !empty($bill))
                    {!! Form::model($bill,['url' => route('bills.update',['bill'=>$bill->id]),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'Billsform']) !!}
                @else
                    {!! Form::open(['url' => route('bills.store'),'method'=>'post' , 'class' => 'form-horizontal','files'=>true,'id'=>'Billsform']) !!}
                @endif
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-4">
                            <label for="bill_no">Bill # <span class="text-danger">*</span></label>
                            {!! Form::text('bill_no', isset($bill)&&!empty($bill)?$bill['bill_no']:null, ['class' => 'form-control','id'=>'bill_no']) !!}
                            @error('bill_no')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="customer">Payee / Vendor <span class="text-danger">*</span></label>
                            {!! Form::select('customer', $payees, isset($bill)&&!empty($bill)?$bill['payee_id']:null, ['class' => 'form-control amounts-are-select2', 'id' => 'customer']) !!}
                            <div class="wrapper" id="wrp" style="display: none;">
                                <a href="javascript:;" id="type" class="font-weight-300" onclick="OpenUserTypeModal()"><i class="fa fa-plus-circle"></i> Add New</a>
                            </div>
                            @error('customer')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="bill_date">Bill Date <span class="text-danger">*</span></label>
                            {!! Form::text('bill_date', isset($bill)&&!empty($bill)?date('d-m-Y',strtotime($bill['bill_date'])):null, ['class' => 'form-control','id'=>'bill_date']) !!}
                            @error('bill_date')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group mb-3 col-md-4">
                            <label for="due_date">Due Date <span class="text-danger">*</span></label>
                            <input type="hidden" id="due_date_hidden" value="{{isset($bill)&&!empty($bill)?date('Y-m-d',strtotime($bill['due_date'])):date('Y-m-d')}}" />
                            {!! Form::text('due_date', isset($bill)&&!empty($bill)?date('d-m-Y',strtotime($bill['due_date'])):date('d-m-Y'), ['class' => 'form-control','id'=>'due_date']) !!}
                            @error('due_date')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                            {!! Form::select('payment_method', $payment_method, isset($bill)&&!empty($bill)?$bill['payment_method']:null, ['class' => 'form-control amounts-are-select2', 'id' => 'payment_method']) !!}
                            @error('payment_method')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_terms">Payment Terms</label>
                            <select name="payment_terms" class="form-control ex-payment-terms amounts-are-select2" id="payment_terms">
                                <option data-days="0" value="">Due on Receipt</option>
                                @foreach ($payment_terms as $payment_term)
                                <option @if(isset($bill)&&$bill['payment_term_id']==$payment_term['id']) selected @endif data-days="{{$payment_term['terms_days']}}" value="{{$payment_term['id']}}">{{$payment_term['terms_name']}}</option>
                                @endforeach
                            </select>
                            <div class="wrapper" id="wrp_terms" style="display: none;">
                                <a href="javascript:;" class="font-weight-300" onclick="OpenPaymentTermsModal()"><i class="fa fa-plus-circle"></i> Add New</a>
                            </div>
                            @error('payment_terms')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <h4 class="col-form-label m-b-0 text-white">Item Details</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group mb-0 row">
                                                <label for="discount_level" class="col-4 col-form-label text-right text-white">Discount Level</label>
                                                <div class="col-8">
                                                    <select class="form-control discount-level-select2" name="discount_level" id="discount_level">
                                                        <option value="0" @if(isset($bill) && $bill['discount_level']==0) selected @endif>At transaction level</option>
                                                        <option value="1" @if(isset($bill) && $bill['discount_level']==1) selected @endif>At item level</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group mb-0 row">
                                                <label for="amounts_are" class="col-4 col-form-label text-right text-white">Amounts are</label>
                                                <div class="col-8">
                                                    <select class="form-control amounts-are-select2" name="tax_type" id="amounts_are">
                                                        <option value="exclusive" @if(isset($bill) && $bill['tax_type']==1) selected @endif>Exclusive of Tax</option>
                                                        <option value="inclusive" @if(isset($bill) && $bill['tax_type']==2) selected @endif>Inclusive of Tax</option>
                                                        <option value="out_of_scope" @if(isset($bill) && $bill['tax_type']==3) selected @endif>Out of scope of Tax</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="gstinvoice-table-data">
                                        <div class="table-responsive data-table-gst-box pb-3">
                                            <table class="table table-hover">
                                                <thead>
                                                <th width="13%">Product <span class="text-danger">*</span></th>
                                                <th width="14%">HSN Code <span class="text-danger">*</span></th>
                                                <th width="10%">QTY <span class="text-danger">*</span></th>
                                                <th width="12%">Rate <span class="text-danger">*</span></th>
                                                <th width="16%" style="display: none;" class="discount-line-section">Discount</th>
                                                <th width="13%">Amount <span class="text-danger">*</span></th>
                                                <th width="18%" class="tax_column @if(isset($bill)&&$bill['tax_type']==3) hide @endif">Tax <span class="text-danger">*</span></th>
                                                <th width="2%">&nbsp;</th>
                                                </thead>
                                                <tbody id="items_list_body">
                                                @php $i=1; @endphp
                                                @if(!empty($bill_items))
                                                    @foreach($bill_items as $item)
                                                        @if($i > 1)
                                                            <tr class="itemTr"></tr>
                                                        @endif
                                                        <tr class="{{$i > 1 ? 'itemNewCheckTr' : 'itemTr'}}">
                                                            <td id="pro_list">
                                                                <select name="product[]" id="product_select_{{$i}}" class="form-control ex-product product_select_edit amounts-are-select2" data-id="{{$i}}" style="width: 100%;" required="">
                                                                    @foreach($products as $pro)
                                                                        <option value="{{$pro['id']}}" @if($pro['id'] == $item['product_id']) selected @endif>{{$pro['title']}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="wrapper" id="prowrp{{$i}}" style="display: none;">
                                                                    <a href="javascript:;" class="font-weight-300 add-new-prod-link" data-id="product_select_{{$i}}" onclick="OpenProductModel('product_select_{{$i}}')"><i class="fa fa-plus-circle"></i> Add New</a>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control hsn_code_input" name="hsn_code[]" value="{{$item['hsn_code']}}">
                                                            </td>
                                                            <td>
                                                                <input type="number" min="1" class="form-control quantity-input floatTextBox" name="quantity[]" value="{{$item['quantity']}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" min="0" class="form-control rate-input floatTextBox" name="rate[]" value="{{$item['rate']}}">
                                                            </td>
                                                            <td style="display: none;" class="discount-line-section">
                                                                <input style="width: 65px" type="text" name="discount_items[]" value="{{$item['discount']}}" class="form-control discount-items">
                                                                <select name="discount_type_items[]" class="discount-type-items">
                                                                    <option value="1" @if($item['discount_type'] == 1)  selected @endif>%</option>
                                                                    <option value="2" @if($item['discount_type'] == 2)  selected @endif>Rs.</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" min="0" class="form-control amount-input floatTextBox" name="amount[]" value="{{$item['amount']}}" readonly>
                                                            </td>
                                                            <td id="taxes" class="tax_column @if(isset($bill)&&$bill['tax_type']==3) hide @endif">
                                                                <select id="taxes" class="form-control tax-input" name="taxes[]">
                                                                    @foreach($taxes as $tax)
                                                                        @if($tax['is_cess'] == 0)
                                                                            <option value="{{$tax['id']}}" @if(!empty($item['tax_id']) && $item['tax_id']==$tax['id'])) selected @endif>{{$tax['rate'].'% '.$tax['tax_name']}}</option>
                                                                        @else
                                                                            <option value="{{$tax['id']}}" @if(!empty($item['tax_id']) && $item['tax_id']==$tax['id'])) selected @endif>{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                @if($i>1)
                                                                    <button type="button" class="btn btn-danger btn-circle btn-sm remove-line-item"><i class="fa fa-times"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                @else
                                                    <tr class="itemTr">
                                                        <td id="pro_list">
                                                            <!--<input type="text" class="form-control" name="item_name[0]" required>-->
                                                            <select name="product[0]" id="product_select" class="form-control ex-product amounts-are-select2" style="width: 100%;" required="">
                                                                @foreach($products as $pro)
                                                                    <option value="{{$pro['id']}}">{{$pro['title']}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="wrapper" id="prowrp" style="display: none;">
                                                                <a href="javascript:;" id="type2" data-id="product_select" class="font-weight-300 add-new-prod-link" onclick="OpenProductModel('product_select')"><i class="fa fa-plus-circle"></i> Add New</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control hsn_code_input" name="hsn_code[0]" id="hsn_code_0" value="{{$first_product['hsn_code']}}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" min="1" value="1" class="form-control quantity-input floatTextBox" name="quantity[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control rate-input floatTextBox" id="rate_0"  name="rate[0]" value="{{$first_product['price']}}" required>
                                                        </td>
                                                        <td style="display: none;" class="discount-line-section">
                                                            <input style="width: 65px" type="text" name="discount_items[]" class="form-control discount-items">
                                                            <select name="discount_type_items[]" class="discount-type-items">
                                                                <option value="1">%</option>
                                                                <option value="2">Rs.</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control amount-input floatTextBox" name="amount[0]" readonly>
                                                        </td>
                                                        <td id="taxes" class="tax_column @if(isset($bill)&&$bill['tax_type']==3) hide @endif">
                                                            <select class="form-control tax-input" name="taxes[]" required>
                                                                @foreach($taxes as $tax)
                                                                    @if($tax['is_cess'] == 0)
                                                                        <option value="{{$tax['id']}}">{{$tax['rate'].'% '.$tax['tax_name']}}</option>
                                                                    @else
                                                                        <option value="{{$tax['id']}}">{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                            <table class="table table-hover" style="width: 40%;float: right;">
                                                <tr id="subtotal_row">
                                                    <th width="50%">Subtotal</th>
                                                    <td width="50%">
                                                        <input type="text" class="form-control text-right" id="subtotal" readonly="" />
                                                    </td>
                                                </tr>
                                                @foreach($all_tax_labels as $tax)
                                                    @php
                                                        $arr = explode("_", $tax, 2);
                                                        $rate = $arr[0];
                                                        $tax_name = $arr[1];
                                                    @endphp
                                                    @if($tax_name == 'GST')
                                                        <tr class="{{$rate.'_'.$tax_name}} hide">
                                                            <th width='50%'>{{$rate / 2}}% CGST on Rs. <span id="label_1_{{$rate.'_'.$tax_name}}">0.00</span></th>
                                                            <td width='50%'><input type="text" id="input_1_{{$rate.'_'.$tax_name}}" class="form-control tax-input-row text-right" readonly></td>
                                                        </tr>
                                                        <tr class="{{$rate.'_'.$tax_name}} hide">
                                                            <th width='50%'>{{$rate / 2}}% SGST on Rs. <span id="label_2_{{$rate.'_'.$tax_name}}">0.00</span></th>
                                                            <td width='50%'><input type="text" id="input_2_{{$rate.'_'.$tax_name}}" class="form-control tax-input-row text-right" readonly></td>
                                                        </tr>
                                                    @else
                                                        <tr class="{{$rate.'_'.$tax_name}} hide">
                                                            <th width='50%'>{{$rate.'% '.$tax_name}} on Rs. <span id="label_{{$rate.'_'.$tax_name}}">0.00</span></th>
                                                            <td width='50%'><input type="text" id="input_{{$rate.'_'.$tax_name}}" class="form-control tax-input-row text-right" readonly></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr class="discount-section">
                                                    <th>Discount Type</th>
                                                    <td>
                                                        <select name="discount_type" id="discount_type" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($bill['discount_type']) && $bill['discount_type'] == '1') selected @endif>Percentage (%)</option>
                                                            <option value="2" @if(isset($bill['discount_type']) && $bill['discount_type'] == '2') selected @endif>Flat (Rs.)</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr class="discount-section">
                                                    <th>Discount Amount</th>
                                                    <td>{!! Form::text('discount', null, ['class' => 'form-control','id'=>'discount']) !!}</td>
                                                </tr>
                                                <tr>
                                                    <th width="50%">Total</th>
                                                    <td width="50%"><input type="text" class="form-control text-right" id="total" readonly="" /></td>
                                                </tr>
                                            </table>
                                            <input type="hidden" name="amount_before_tax" id="amount_before_tax" />
                                            <input type="hidden" name="tax_amount" id="tax_amount" />
                                            <input type="hidden" name="total" id="total_amount" />
                                            <button type="button" id="addItem" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Lines</button>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group mb-0">
                                                    <label for="memo">Memo</label>
                                                    {!! Form::textarea('memo', null, ['class' => 'form-control','id'=>'memo','rows' => '3']) !!}
                                                    @error('memo')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <i class="fa fa-paperclip"></i>&nbsp;<label for="files">Receipt</label>
                                                    <div class="form-group mb-0 border p-2">
                                                        {!! Form::file('files', ['class' => 'mb-2 border-0', 'id'=> 'files']) !!}
                                                        @if(isset($bill) && !empty($bill['files']) && file_exists($bill['files']))
                                                            @if(in_array($bill['file_ext'],['jpg','jpeg','png','bmp']) )
                                                                <br><img src="{{url($bill['files'])}}" class="img-thumbnail" style=" width: 150px;" id="attachment_file">
                                                                <div class="button-group mt-2" id="attachment_div">
                                                                    <button type="button" class="btn btn-sm btn-circle btn-primary" data-magnify="gallery" data-src="{{url($bill['files'])}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></button>
                                                                    <a href="{{url($bill['files'])}}" download>
                                                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></button>
                                                                    </a>
                                                                    <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" id="delete_attachment" onclick="deleteAttachment({{$bill['id']}})"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                            @else
                                                                <br><button class="btn btn-link" type="button" id="attachment_file"><i class="fas fa-file-alt fa-5x"></i></button>
                                                                <div class="button-group mt-2" id="attachment_div">
                                                                    @if(!in_array($bill['file_ext'],['xlsx','xls','csv']))
                                                                        <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#attachmentModal" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></button>
                                                                    @endif
                                                                    <a href="{{url($bill['files'])}}" download>
                                                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></button>
                                                                    </a>
                                                                    <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" id="delete_attachment" onclick="deleteAttachment({{$bill['id']}})"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                                <div id="attachmentModal" class="modal fade bs-example-modal-lg" role="dialog">
                                                                    <div class="modal-dialog modal-xl">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">{{$bill['file_name']}}</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                @if(!in_array($bill['file_ext'],['xlsx','xls','csv']))
                                                                                    <iframe src="{{url($bill['files'])}}" height="400px" width="100%"></iframe>
                                                                                @endif
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div id="att_del_msg" class="text-danger text-bold"></div>
                                                        @endif
                                                        @error('files')
                                                            <br>
                                                            <span class="text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="submit" id="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<!--CUSTOMERS MODAL-->
@include('globals.invoice.customer_modal')

<!--Payment Terms Modal-->
@include('globals.bills.payment_terms_modal')

<!--PRODUCT MODAL-->
@include('globals.invoice.product_model')

@section('page_confirmation_script')
    <script src="{{asset('js/page_confirmation_script.js')}}"></script>
@endsection
@section('tax_calculations_discount')
    <script src="{{asset('js/tax_calculations_discount.js')}}"></script>
@endsection
<script type="text/javascript">
    @if(isset($bill) && !empty($bill))
        $(document).ready(function(){
            $('.product_select_edit').on('select2:open',function(){
                var id = $(this).data('id');
                $("#select2-product_select_"+id+"-results").siblings('div').remove();
                $("#select2-product_select_"+id+"-results").parent('span').prepend("<div class='select2-results__option'>" + jQuery('#prowrp'+id).html() + "</div>");
            });
            if($('#discount_type').find(":selected").val() == '1') {
                $('#discount').inputmask("percentage");
                $('#discount').parent('td').siblings('th').html('Discount Percentage');
            } else if($('#discount_type').find(":selected").val() == '2') {
                $('#discount').inputmask("currency");
                $('#discount').parent('td').siblings('th').html('Discount Amount');
            }
            setTimeout(function(){
                $('#discount_level').trigger('change');
            },500);
            taxCalculation();
        });
    @else
        $(document).ready(function(){
            setTimeout(function(){
                $('.ex-product').trigger('change');
            },500);
        });
    @endif

    function OpenUserTypeModal(){
        $('#CustomersModal').modal('show');
        $('#customer').select2('close');
    }

    function CloseUserModal(){
        $('#CustomersModal').modal('hide');
    }

    function OpenProductModel(selectID){
        $('#ProductModal').modal('show');
        $('#'+selectID).select2('close');
    }

    function OpenPaymentTermsModal(){
        $('#PaymentTermsModal').modal('show');
        $('#payment_terms').select2('close');
    }

    $(document).ready(function() {

        Inputmask.extendDefaults({
            'removeMaskOnSubmit': true
        });

        $(document).on('click', '.add-new-prod-link', function(){
            dropdown_id = $(this).data('id');
        });

        $('#discount_type').change(function(){
            if($(this).val() == '1') {
                $('#discount').inputmask("percentage");
                $('#discount').parent('td').siblings('th').html('Discount Percentage');
            } else {
                $('#discount').inputmask("currency");
                $('#discount').parent('td').siblings('th').html('Discount Amount');
            }
            taxCalculation();
        });

        $('#discount').on('keyup change', function(){
            taxCalculation();
        });

        $("#CustomersForm").validate({
            rules: {
                first_name: "required",
                last_name: "required",
                display_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                mobile: "required",
                street: "required",
                city: "required",
                state: "required",
                pincode: "required",
                // country: "required",
                gender: "required",
                hire_date: "required",
                billing_name: "required",
                billing_phone: "required",
                billing_street: "required",
                billing_city: "required",
                billing_state: "required",
                billing_pincode: "required",
                // billing_country: "required",
                shipping_name: "required",
                shipping_phone: "required",
                shipping_street: "required",
                shipping_city: "required",
                shipping_state: "required",
                shipping_pincode: "required",
                // shipping_country: "required",
            },
            messages: {
                first_name: "The firstname field is required",
                last_name: "The lastname field is required",
                display_name: {
                    required: "The displayname field is required",
                },
                email: "Please enter a valid email address",
                mobile: "The mobile field is required",
                street: "The street field is required",
                city: "The city field is required",
                state: "The state field is required",
                pincode: "The pincode field is required",
                // country: "The country field is required",
                gender: "The gender field is required",
                hire_date: "The hire date field is required",
                billing_name: "The billing name field is required",
                billing_phone: "The billing phone field is required",
                billing_street: "The billing street field is required",
                billing_city: "The billing city field is required",
                billing_state: "The billing state field is required",
                billing_pincode: "The billing pincode field is required",
                // billing_country: "The billing country field is required",
                shipping_name: "The shipping name field is required",
                shipping_phone: "The shipping phone field is required",
                shipping_street: "The shipping street field is required",
                shipping_city: "The shipping city field is required",
                shipping_state: "The shipping state field is required",
                shipping_pincode: "The shipping pincode field is required",
                // shipping_country: "The shipping country field is required",
            },
            normalizer: function(value) {
                return $.trim(value);
            },
            submitHandler:function(){
                var data2 = $('#CustomersForm').serialize();
                $.ajax({
                    url: '{{url('ajax/payees-store')}}',
                    type: 'POST',
                    data: {'data':data2,'user_type':3},
                    success: function (result) {
                        optionValue = result['id'];
                        optionText = result['name'];
                        $('#customer').append(`<option value="${optionValue}">${optionText}</option>`);
                        $('#customer').val(optionValue).change();
                        $('#CustomersModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#CustomersForm")[0].reset();
                        getEmail($('#customer').val());
                    }
                });
            }
        });

        $("#ProductForm").validate({
            rules: {
                title: "required",
                price: "required",
                sale_price: "required",
                status: "required",
            },
            messages: {
                title: "The title field is required",
                price: "The price field is required",
                sale_price: "The sale price field is required",
                status: "The status field is required",
            },
            normalizer: function(value) {
                return $.trim(value);
            },
            submitHandler:function(){
                var data2 = $('#ProductForm').serialize();
                $.ajax({
                    url: '{{url('ajax/product-store')}}',
                    type: 'POST',
                    data: {'data':data2},
                    success: function (result) {
                        optionValue = result['id'];
                        optionText = result['name'];
                        $('.ex-product').append(`<option value="${optionValue}">${optionText}</option>`);
                        $('#ProductModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#ProductForm")[0].reset();
                        $('#'+dropdown_id+' option:last').attr("selected", "selected");
                        $('.ex-product').trigger('change');
                    }
                });
            }
        });

        $("#PaymentTermsForm").validate({
            rules: {
                terms_name: "required",
                terms_days: "required"
            },
            messages: {
                terms_name: "Enter a valid term name.",
                terms_days: "Enter a valid number of days."
            },
            normalizer: function(value) {
                return $.trim(value);
            },
            submitHandler:function(){
                var data2 = $('#PaymentTermsForm').serialize();
                $.ajax({
                    url: '{{route('payment-terms-store')}}',
                    type: 'POST',
                    data: {'data':data2},
                    success: function (result) {
                        optionValue = result['id'];
                        optionText = result['terms_name'];
                        optionDays = result['terms_days'];
                        $('.ex-payment-terms').append(`<option data-days="${optionDays}" value="${optionValue}">${optionText}</option>`);
                        $('#PaymentTermsModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#PaymentTermsForm")[0].reset();
                        $('.ex-payment-terms option:last').attr("selected", "selected");
                    }
                });
            }
        });
    });

    $(document).ready(function(){
        var flg = 0;
        var flg2 = 0;
        var flg3 = 0;
        $('#customer').on("select2:open", function() {
            flg++;
            if (flg == 1) {
                $this_html = jQuery('#wrp').html();
                $(".select2-results").prepend("<div class='select2-results__option'>" +
                $this_html + "</div>");
            }
        });

        $('#product_select').on("select2:open", function() {
            flg3++;
            if (flg3 == 1) {
                $this_html = jQuery('#prowrp').html();
                $(".select2-results").prepend("<div class='select2-results__option'>" + $this_html + "</div>");
            }
        });

        $('#payment_terms').on("select2:open", function() {
            flg2++;
            if (flg2 == 1) {
                $this_html = jQuery('#wrp_terms').html();
                $(".select2-results").prepend("<div class='select2-results__option'>" +
                $this_html + "</div>");
            }
        });

        $("#addItem").click(function() {
            var numItems = $('.itemTr').length;
            var i = numItems + 1;
            var tax_type = $('#amounts_are').find(":selected").val();
            var discount_level = $("#discount_level").find(":selected").val();
            var row = $("<tr>").addClass("itemTr");
            var product_select = "<select name=\"product["+numItems+"]\" id=\"product_select"+i+"\" class='product_select ex-product form-control amounts-are-select3' style=\"width: 100%;\" required>";
            /*Product Get*/
            $.ajax({
                url: '{{url('ajax/get_product')}}',
                type: 'POST',
                data: {'data': 0},
                success: function (result) {
                    var j;
                    for(j=0; j<result['products'].length; j++ ){
                        product_select += "<option value='"+result['products'][j]['id']+"'>"+result['products'][j]['title']+"</option>";
                    }
                    product_select += "</select>";

                    $("#items_list_body").append(row);
                    var tax_input = $('#taxes').html();
                    var products = $('#pro_list').html();
                    var html = "<tr class=\"itemNewCheckTr\">";
                    var discount_field_style = "";
                    if(discount_level == 0) {
                        discount_field_style = "style=display:none;";
                    }
                    //html += "<td>" + i + "</td>";
                    html += "<td>" + product_select +
                        "<div class=\"wrapper\" id=\"prowrp"+i+"\" style=\"display: none;\">"+
                        "<a href=\"javascript:;\" class=\"font-weight-300 add-new-prod-link\" data-id=\"product_select"+i+"\" onclick=\"OpenProductModel('product_select"+i+"')\"><i class=\"fa fa-plus-circle\"></i> Add New</a>"+
                        "</div>"+
                        "</td>";
                    html += "<td><input type=\"text\" class=\"form-control hsn_code_input\" name=\"hsn_code["+numItems+"]\" id=\"hsn_code_"+numItems+"\" value='{{$first_product['hsn_code']}}' required><span class=\"multi-error\"></span></td>";
                    html += "<td><input type=\"number\" min=\"1\" value=\"1\" class=\"form-control quantity-input floatTextBox\" name=\"quantity["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
                    html += "<td><input type=\"text\" min=\"0\" class=\"form-control rate-input floatTextBox\" id=\"rate_"+numItems+"\" name=\"rate["+numItems+"]\" value='{{$first_product['price']}}' required><span class=\"multi-error\"></span></td>";
                    html += "<td "+discount_field_style+" class='discount-line-section'>";
                    html += "<input style='width: 65px' type='text' name='discount_items[]' class='form-control discount-items'>";
                    html += "<select name='discount_type_items[]' class='discount-type-items'>";
                    html += "<option value='1'>%</option><option value='2'>Rs.</option></select></td>";
                    html += "<td><input type=\"text\" min=\"0\" class=\"form-control amount-input floatTextBox\" name=\"amount["+numItems+"]\" readonly><span class=\"multi-error\"></span></td>";
                    {{--html += "<td><select class='form-control tax-input' name=\"taxes["+numItems+"]\">@foreach($taxes as $tax) <option value='{{$tax['id']}}'>{{$tax['rate'].'% '.$tax['tax_name']}}</option> @endforeach</select></td>";--}}
                    if(tax_type == 'out_of_scope') {
                        html += "<td class='tax_column hide'><select class='form-control tax-input' name=\"taxes["+numItems+"]\">@foreach($taxes as $tax) @if($tax['is_cess'] == 0)<option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name']}}</option> @else <option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option> @endif @endforeach</select></td>";
                    } else {
                        html += "<td class='tax_column'><select class='form-control tax-input' name=\"taxes["+numItems+"]\">@foreach($taxes as $tax) @if($tax['is_cess'] == 0)<option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name']}}</option> @else <option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option> @endif @endforeach</select></td>";
                    }
                    html += "<td><button type=\"button\" class=\"btn btn-danger btn-sm btn-circle remove-line-item \"><i class=\"fa fa-times\"></i> </button></td>";
                    html += "</tr>";
                    $("#items_list_body").append(html);
                    $(".floatTextBox").inputFilter(function(value) {
                        return /^-?\d*[.,]?\d*$/.test(value);
                    });

                    $('#product_select'+i).on('select2:open',function(){
                        $("#select2-product_select"+i+"-results").siblings('div').remove();
                        $("#select2-product_select"+i+"-results").parent('span').prepend("<div class='select2-results__option'>" + jQuery('#prowrp'+i).html() + "</div>");
                    });

                    $('.amounts-are-select3').select2();
                    $('#product_select'+i).trigger('change');
                    $(".discount-type-items").each(function(){
                        if($(this).val() == 1) {
                            $(this).siblings('.discount-items').inputmask('decimal',{min:0, max:100});
                        } else {
                            $(this).siblings('.discount-items').inputmask('currency');
                        }
                    });
                }
            });
        });

        $(document).on('change','.ex-product',function(){
              var pid = $(this) .val();
              var that = $(this);
              $.ajax({
               url: '{{url('ajax/get_product')}}',
               type: 'POST',
               data:  {'data':pid},
               success: function (result) {
                    //$(that).parent('td').next('td').find('.description_input').val(result['description']);
                    $(that).parent('td').next('td').find('.hsn_code_input').val(result['hsn_code']);
                    $(that).parent('td').next('td').next('td').next('td').find('.rate-input').val(result['price']);
                    $(that).parent('td').next('td').next('td').next('td').find('.rate-input').trigger('change');
               }
           });
        });

        $(document).on('click', '.remove-line-item', function(){
            $(this).parents('.itemNewCheckTr').prev('.itemTr').remove();
            $(this).parents('.itemNewCheckTr').remove();
            /*var i = 2;
            $('.itemNewCheckTr').each(function(){
                $(this).children('td:first-child').html(i);
                i++;
            });*/
            taxCalculation();
        });

        $("#payment_terms").change(function(){
            var due_date = $("#bill_date").val();
            var days = $(this).find(":selected").data('days');
            if(days != 0) {
                var parts = due_date.split('-');
                var new_date = new Date(parts[2], parts[1] - 1, parts[0]);
                var final_date = addDays(new_date.toDateString(),days);
                $("#due_date").val(formatDate(final_date));
            } else {
                var bill_date = $("#bill_date").val();
                $("#due_date").val(bill_date);
            }
        });

        $("#bill_date").change(function(){
            var due_date = $(this).val();
            var days = $("#payment_terms").find(":selected").data('days');
            if(days != 0) {
                var parts = due_date.split('-');
                var new_date = new Date(parts[2], parts[1] - 1, parts[0]);
                // var new_date = new Date(due_date);
                var final_date = addDays(new_date.toDateString(),days);
                $("#due_date").val(formatDate(final_date));
            } else {
                var bill_date = $(this).val();
                $("#due_date").val(bill_date);
            }
        });

        $('form.formInvoice').validate();
    });

    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        return [day, month, year].join('-');
    }
    
    function deleteAttachment(aid){
        Swal.fire({
            title: 'Do you want to delete this receipt?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
            $.ajax({
                url: '{{url('ajax/bill_delete_attachment')}}',
                type: 'POST',
                data: {'data':aid},
                success: function (result) {
                    $('[data-toggle="tooltip"]').tooltip("hide");
                    $('#attachment_file').remove();
                    $('#attachment_div').remove();
                    $('#att_del_msg').hide().html('Receipt deleted!').fadeIn('slow').delay(5000).hide(1);
                }
            });
        }
    })
    }

    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));

    $(".floatTextBox").inputFilter(function(value) {
        return /^-?\d*[.,]?\d*$/.test(value);
    });

    function getEmail(cid) {
        $.ajax({
            url: '{{url('ajax/getEmail')}}',
            type: 'POST',
            data: {'data':cid},
            success: function (result) {
                $('#customer_email').val(result);
            }
        });
    }
</script>
@endsection
