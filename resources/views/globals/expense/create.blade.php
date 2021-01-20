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
    #formExpense .select2 {width: 100%!important;}
</style>
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">@if(isset($expense)) Edit @else Add @endif Expense</h4>
    </div>
</div>
<div class="content">
    @include('inc.message2')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                @if(isset($expense) && !empty($expense))
                    {!! Form::model($expense,['url' => url('expense/update/'.$expense->id),'method'=>'patch' ,'class' => 'form-horizontal','files'=>true,'id'=>'formExpense']) !!}
                @else
                    {!! Form::open(['url' => url('expense/insert'), 'class' => 'form-horizontal','files'=>true,'id'=>'formExpense']) !!}
                @endif
                    @csrf
                    <div class="form-row">
                        <div class="from-group mb-3 col-md-6">
                            <label for='status'>Status <span class="text-danger">*</span></label>
                            {!! Form::select('status', [null => 'Select Status'] + \App\Models\Globals\Expense::$expense_status, null, ['class' => 'form-control amounts-are-select2', 'id' => 'status']) !!}
                            @error('status')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="payee">Payee / Vendors <span class="text-danger">*</span></label>
                            {!! Form::select('payee', $payees, isset($expense)&&!empty($expense)?$expense['payee_id']:null, ['class' => 'form-control amounts-are-select2', 'id' => 'payee']) !!}
                            <div class="wrapper" id="wrp" style="display: none;">
                                <a href="javascript:;" id="type" class="font-weight-300" onclick="OpenUserTypeModal()"><i class="fa fa-plus-circle"></i> Add New</a>
                            </div>
                            @error('payee')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-4">
                            <label for="expense_date">Expense date <span class="text-danger">*</span></label>
                            {!! Form::text('expense_date', isset($expense)&&!empty($expense)?date('d-m-Y',strtotime($expense['expense_date'])):date('d-m-Y'), ['class' => 'form-control','id'=>'expense_date']) !!}
                            @error('expense_date')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_method">Payment method</label>
                            {!! Form::select('payment_method', \App\Models\Globals\Expense::$payment_method, null, ['class' => 'form-control amounts-are-select2', 'id' => 'payment_method']) !!}
                            @error('payment_method')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="ref_no">Ref no.</label>
                            {!! Form::text('ref_no', null, ['class' => 'form-control','id'=>'ref_no']) !!}
                            @error('ref_no')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row" style="flex-direction:row-reverse">
                        <div class="form-group mb-3 col-md-3 pull-right">
                            <label>Amounts are</label>
                            <select class="form-control amounts-are-select2" name="tax_type" id="amounts_are">
                                <option value="exclusive" @if(isset($expense) && $expense['tax_type']==1)) selected @endif>Exclusive of Tax</option>
                                <option value="inclusive" @if(isset($expense) && $expense['tax_type']==2)) selected @endif>Inclusive of Tax</option>
                                <option value="out_of_scope" @if(isset($expense) && $expense['tax_type']==3)) selected @endif>Out of scope of Tax</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="m-b-0 text-white">Item Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="gstinvoice-table-data">
                                        <div class="table-responsive data-table-gst-box pb-3">
                                            <table class="table table-hover">
                                                <thead>
                                                    <th width="3%">#</th>
                                                    <th width="35%">Expense Type <span class="text-danger">*</span></th>
                                                    <th width="20%">Note</th>
                                                    <!--<th width="13%">HSN Code <span class="text-danger">*</span></th>
                                                    <th width="10%">QTY <span class="text-danger">*</span></th>
                                                    <th width="14%">Rate <span class="text-danger">*</span></th>-->
                                                    <th width="14%">Amount <span class="text-danger">*</span></th>
                                                    <th width="25%" class="tax-column" @if(isset($expense['tax_type']) && $expense['tax_type']==3) style="display: none;" @endif>Tax <span class="text-danger">*</span></th>
                                                    <th width="4%">&nbsp;</th>
                                                </thead>
                                                <tbody id="items_list_body">
                                                @php $i=1; @endphp
                                                @if(!empty($expense_items))
                                                    @foreach($expense_items as $item)
                                                        @if($i > 1)
                                                            <tr class="itemTr"></tr>
                                                        @endif
                                                        <tr class="{{$i > 1 ? 'itemNewCheckTr' : 'itemTr'}}">
                                                            <td>{{$i}}</td>
                                                            <td id="pro_list">
                                                                <select name="expense_type[]" id="expense_type_{{$i}}" class="form-control ex-type expense_type_edit amounts-are-select2" data-id="{{$i}}" required="">
                                                                    @foreach($expense_types as $expense_type)
                                                                         <option value="{{$expense_type['id']}}" @if($expense_type['id'] == $item['expense_type_id']) selected @endif>{{$expense_type['name']}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="wrapper" id="prowrp{{$i}}" style="display: none;">
                                                                    <a href="javascript:;" class="font-weight-300 add-new-prod-link" data-id="expense_type_{{$i}}" onclick="OpenExpenseTypeModal('expense_type_{{$i}}')"><i class="fa fa-plus-circle"></i> Add New</a>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" cols="5" name="note[]">{{$item['note']}}</textarea>
                                                            </td>
                                                            {{--<td>
                                                                <input type="text" class="form-control hsn_code_input" name="hsn_code[]" value="{{$item['hsn_code']}}">
                                                            </td>
                                                            <td>
                                                                <input type="number" min="1" class="form-control quantity-input floatTextBox" name="quantity[]" value="{{$item['quantity']}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" min="0" class="form-control rate-input floatTextBox" name="rate[]" value="{{$item['rate']}}">
                                                            </td>--}}
                                                            <td>
                                                                <input type="text" min="0" class="form-control amount-input floatTextBox" name="amount[]" value="{{$item['amount']}}">
                                                            </td>
                                                            <td class="tax-column" id="taxes" @if($expense['tax_type']==3) style='display: none;' @endif>
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
                                                        <td>1</td>
                                                        <td id="pro_list">
                                                            <!--<input type="text" class="form-control" name="item_name[0]" required>-->
                                                            <select name="expense_type[0]" id="expense_type" class="form-control ex-type amounts-are-select2" required="">
                                                                @foreach($expense_types as $expense_type)
                                                                    <option value="{{$expense_type['id']}}">{{$expense_type['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="wrapper" id="prowrp" style="display: none;">
                                                                <a href="javascript:;" id="type2" data-id="expense_type" class="font-weight-300 add-new-prod-link" onclick="OpenExpenseTypeModal('expense_type')"><i class="fa fa-plus-circle"></i> Add New</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" cols="5" name="note[]"></textarea>
                                                        </td>
                                                        {{-- <td>
                                                            <input type="text" class="form-control hsn_code_input" name="hsn_code[0]" id="hsn_code_0" value="{{$first_product['hsn_code']}}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" min="1" value="1" class="form-control quantity-input floatTextBox" name="quantity[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control rate-input floatTextBox" id="rate_0"  name="rate[0]" value="{{$first_product['price']}}" required>
                                                        </td> --}}
                                                        <td>
                                                            <input type="text" min="0" class="form-control amount-input floatTextBox" name="amount[0]" required>
                                                        </td>
                                                        <td class="tax-column" id="taxes">
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
                                                {{--<tr>
                                                    <th>Discount Type</th>
                                                    <td>
                                                        <select name="discount_type" id="discount_type" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="1" @if(isset($expense['discount_type']) && $expense['discount_type'] == '1') selected @endif>Percentage (%)</option>
                                                            <option value="2" @if(isset($expense['discount_type']) && $expense['discount_type'] == '2') selected @endif>Flat (Rs.)</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Amount</th>
                                                    <td>{!! Form::text('discount', null, ['class' => 'form-control','id'=>'discount']) !!}</td>
                                                </tr>--}}
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
                                                    <i class="fa fa-paperclip"></i>&nbsp;<label for="memo">Receipt</label>
                                                    <div class="form-group mb-0 border p-2">
                                                        {!! Form::file('files', ['class' => 'mb-2 border-0', 'id'=> 'files']) !!}
                                                        @if(isset($expense) && !empty($expense['files']) && file_exists($expense['files']))
                                                            @if(in_array($expense['file_ext'],['jpg','jpeg','png','bmp']) )
                                                                <br><img src="{{url($expense['files'])}}" class="img-thumbnail" style=" width: 150px;" id="attachment_file">
                                                                <div class="button-group mt-2" id="attachment_div">
                                                                    <button type="button" class="btn btn-sm btn-circle btn-primary" data-magnify="gallery" data-src="{{url($expense['files'])}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></button>
                                                                    <a href="{{url($expense['files'])}}" download>
                                                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></button>
                                                                    </a>
                                                                    <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" id="delete_attachment" onclick="deleteAttachment({{$expense['id']}})"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                            @else
                                                                <br><button class="btn btn-link" type="button" id="attachment_file"><i class="fas fa-file-alt fa-5x"></i></button>
                                                                <div class="button-group mt-2" id="attachment_div">
                                                                    @if(!in_array($expense['file_ext'],['xlsx','xls','csv']))
                                                                        <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#attachmentModal" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></button>
                                                                    @endif
                                                                    <a href="{{url($expense['files'])}}" download>
                                                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></button>
                                                                    </a>
                                                                    <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" id="delete_attachment" onclick="deleteAttachment({{$expense['id']}})"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                                <div id="attachmentModal" class="modal fade bs-example-modal-lg" role="dialog">
                                                                    <div class="modal-dialog modal-xl">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">{{$expense['file_name']}}</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                @if(!in_array($expense['file_ext'],['xlsx','xls','csv']))
                                                                                    <iframe src="{{url($expense['files'])}}" height="400px" width="100%"></iframe>
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
                                                                <strong>{{$message}}</strong>
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

<!--PAYEE MODEL USER TYPE SELECTION-->
<div class="modal fade bs-example-modal-sm" id="UserTypeModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Select User Type</h4>
                <button type="button" class="close" onclick="CloseUserModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-0">
                    @foreach(\App\Models\Globals\Expense::$user_type as $key2 =>$value2)
                        <div class="col-md-12">
                            <div class="custom-control custom-radio mb-2">
                                {!! Form::radio('user_type', $key2, null, ['class' => 'custom-control-input user_type', 'id'=>'user_'.$key2]) !!}
                                <label for="user_{{$key2}}" class="custom-control-label"> {{$value2}}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!--SUPPLIERS MODAL-->
@include('globals.expense.suppliers_modal')

<!--EMPLOYEES MODAL-->
@include('globals.expense.employee_modal')

<!--CUSTOMERS MODAL-->
@include('globals.expense.customer_modal')

<!--PAYMENT ACCOUNT MODAL-->
@include('globals.expense.payment_account_modal')

<!--PRODUCT MODAL-->
@include('globals.expense.product_model')

<!--PRODUCT MODAL-->
@include('globals.expense.expense_type_modal')

@section('page_confirmation_script')
    <script src="{{asset('js/page_confirmation_script.js')}}"></script>
@stop

<script type="text/javascript">
    @if(isset($expense) && !empty($expense))
        $(document).ready(function(){
            $('.expense_type_edit').on('select2:open',function(){
                var id = $(this).data('id');
                $("#select2-expense_type_"+id+"-results").siblings('div').remove();
                $("#select2-expense_type_"+id+"-results").parent('span').prepend("<div class='select2-results__option'>" + jQuery('#prowrp'+id).html() + "</div>");
            });
            if($('#discount_type').find(":selected").val() == '1') {
                $('#discount').inputmask("percentage");
                $('#discount').parent('td').siblings('th').html('Discount Percentage');
            } else if($('#discount_type').find(":selected").val() == '2') {
                $('#discount').inputmask("currency");
                $('#discount').parent('td').siblings('th').html('Discount Amount');
            }
        });
    @else
        $(document).ready(function(){
            setTimeout(function(){
                $('.ex-type').trigger('change');
            },500);
        });
    @endif

    function OpenUserTypeModal(){
        $('#UserTypeModal').modal('show');
        $('#payee').select2('close');
    }

    function CloseUserModal(){
        $('#UserTypeModal').modal('hide');
        $('.user_type').each(function(){
            $(this).prop('checked',false);
        });
    }

    function OpenPaymentAccountModal(){
        $('#PaymentAccountModal').modal('show');
        $('#payment_account').select2('close');
    }

    function OpenExpenseTypeModal(selectID){
        $('#ExpenseTypeModal').modal('show');
        $('#'+selectID).select2('close');
    }

    $('.user_type').change(function(){
       var user_type = $(this).val();
       $('#UserTypeModal').modal('hide');
       if(user_type==1){
           $('#SuppliersModal').modal('show');
       }else if(user_type==2){
           $('#EmployeeModal').modal('show');
       }else{
           $('#CustomersModal').modal('show');
       }
       $('.user_type').each(function(){
            $(this).prop('checked',false);
       });
    });

    $(document).ready(function() {

        Inputmask.extendDefaults({
            'removeMaskOnSubmit': true
        });

        $(document).on('click', '.add-new-prod-link', function(){
            dropdown_id = $(this).data('id');
        });
        //$('.amount-input').inputmask('decimal');
        //$('.rate-input').inputmask('decimal');
        //$('#discount').inputmask('percentage');
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

        $("#formExpense").validate({
            rules: {
                expense_date: "required",
                status: "required",
            },
            messages: {
                expense_date: "The expense date field is required",
                status: "The status field is required",
            }
        });

        $("#SuppliersForm").validate({
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
            },
            normalizer: function(value) {
                return $.trim(value);
            },
            submitHandler:function(){
                var data = $('#SuppliersForm').serialize();
                $.ajax({
                    url: '{{url('ajax/payees-store')}}',
                    type: 'POST',
                    data:  {'data':data,'user_type':1},
                    success: function (result) {
                        optionValue = result['id'];
                        optionText = result['name'];
                        $('#payee').append(`<option value="${optionValue}">${optionText}</option>`);
                        $('#payee').val(optionValue).change();
                        $('#SuppliersModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#SuppliersForm")[0].reset();
                    }
                });
            }
        });

        $("#EmployeesForm").validate({
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
                billing_street: "required",
                billing_city: "required",
                billing_state: "required",
                billing_pincode: "required",
                // billing_country: "required",
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
                billing_street: "The billing street field is required",
                billing_city: "The billing city field is required",
                billing_state: "The billing state field is required",
                billing_pincode: "The billing pincode field is required",
                // billing_country: "The billing country field is required",
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
                var data1 = $('#EmployeesForm').serialize();
                $.ajax({
                    url: '{{url('ajax/payees-store')}}',
                    type: 'POST',
                    data:  {'data':data1,'user_type':2},
                    success: function (result) {
                        optionValue = result['id'];
                        optionText = result['name'];
                        $('#payee').append(`<option value="${optionValue}">${optionText}</option>`);
                        $('#payee').val(optionValue).change();
                        $('#EmployeeModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#EmployeesForm")[0].reset();
                    }
                });
            }
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
                        $('#payee').append(`<option value="${optionValue}">${optionText}</option>`);
                        $('#payee').val(optionValue).change();
                        $('#CustomersModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#CustomersForm")[0].reset();
                    }
                });
            }
        });

        $("#PaymentAccountForm").validate({
            rules: {
                name: "required",
                balance: "required",
            },
            messages: {
                name: "The name field is required",
                balance: "The balance field is required",
            },
            normalizer: function(value) {
                return $.trim(value);
            },
            submitHandler:function(){
                var data3 = $('#PaymentAccountForm').serialize();
                $.ajax({
                    url: '{{url('ajax/payment-account-store')}}',
                    type: 'POST',
                    data: {'data':data3},
                    success: function (result) {
                        optionValue = result['id'];
                        optionText = result['name'];
                        $('#payment_account').append(`<option value="${optionValue}">${optionText}</option>`);
                        $('#payment_account').val(optionValue).change();
                        $('#PaymentAccountModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#PaymentAccountForm")[0].reset();
                    }
                });
            }
        });

        $("#ExpenseTypeForm").validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "The name field is required"
            },
            normalizer: function(value) {
                return $.trim(value);
            },
            submitHandler:function(){
                var data2 = $('#ExpenseTypeForm').serialize();
                $.ajax({
                    url: '{{route('expense-type-store')}}',
                    type: 'POST',
                    data: {'data':data2},
                    success: function (result) {
                        optionValue = result['id'];
                        optionText = result['name'];
                        $('.ex-type').append(`<option value="${optionValue}">${optionText}</option>`);
                        $('#ExpenseTypeModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#ExpenseTypeForm")[0].reset();
                        $('#'+dropdown_id+' option:last').attr("selected", "selected");
                        $('.ex-type').trigger('change');
                    }
                });
            }
        });
    });

    $(document).ready(function(){
        var flg = 0;
        var flg2 = 0;
        var flg3 = 0;
        $('#payee').on("select2:open", function() {
            flg++;
            if (flg == 1) {
                $this_html = jQuery('#wrp').html();
                $(".select2-results").prepend("<div class='select2-results__option'>" +
                $this_html + "</div>");
            }
        });

        $('#payment_account').on("select2:open", function() {
            flg2++;
            if (flg2 == 1) {
                $this_html2 = jQuery('#wrp2').html();
                $(".select2-results").last().prepend("<div class='select2-results__option'>" +
                    $this_html2 + "</div>");
            }
        });

        $('#expense_type').on("select2:open", function() {
            flg3++;
            if (flg3 == 1) {
                $this_html = jQuery('#prowrp').html();
                $(".select2-results").prepend("<div class='select2-results__option'>" + $this_html + "</div>");
            }
        });

        $("#addItem").click(function() {
            var numItems = $('.itemTr').length;
            var i = numItems + 1;
            var tax_type = $('#amounts_are').find(":selected").val();
            var row = $("<tr>").addClass("itemTr");
            var expense_type = "<select name=\"expense_type["+numItems+"]\" id=\"expense_type"+i+"\" class='expense_type ex-type form-control amounts-are-select3' required>";
            /*Expense Type Get*/
            $.ajax({
                url: '{{route('get-expense-type')}}',
                type: 'POST',
                data: {'data': 0},
                success: function (result) {
                    var j;
                    for(j=0; j<result['expense_type'].length; j++ ){
                        expense_type += "<option value='"+result['expense_type'][j]['id']+"'>"+result['expense_type'][j]['name']+"</option>";
                    }
                    expense_type += "</select>";

                    $("#items_list_body").append(row);
                    var tax_input = $('#taxes').html();

                    var html = "<tr class=\"itemNewCheckTr\">";
                    html += "<td>" + i + "</td>";
                    html += "<td>" + expense_type +
                        "<div class=\"wrapper\" id=\"prowrp"+i+"\" style=\"display: none;\">"+
                        "<a href=\"javascript:;\" class=\"font-weight-300 add-new-prod-link\" data-id=\"expense_type"+i+"\" onclick=\"OpenExpenseTypeModal('expense_type"+i+"')\"><i class=\"fa fa-plus-circle\"></i> Add New</a>"+
                        "</div>"+
                        "</td>";
                    html += "<td><textarea class='form-control' name='note[]' cols='5'></textarea></td>";
                    html += "<td><input type=\"text\" min=\"0\" class=\"form-control amount-input floatTextBox\" name=\"amount["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
                    if(tax_type == 'out_of_scope') {
                        html += "<td class='tax-column hide'><select class='form-control tax-input' name=\"taxes["+numItems+"]\">@foreach($taxes as $tax) @if($tax['is_cess'] == 0)<option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name']}}</option> @else <option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option> @endif @endforeach</select></td>";
                    } else {
                        html += "<td class='tax-column'><select class='form-control tax-input' name=\"taxes["+numItems+"]\">@foreach($taxes as $tax) @if($tax['is_cess'] == 0)<option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name']}}</option> @else <option value=\"{{$tax['id']}}\">{{$tax['rate'].'% '.$tax['tax_name'] . ' + '.$tax['cess'].'% CESS'}}</option> @endif @endforeach</select></td>";
                    }
                    html += "<td><button type=\"button\" class=\"btn btn-danger btn-circle btn-sm remove-line-item \"><i class=\"fa fa-times\"></i> </button></td>";
                    html += "</tr>";
                    $("#items_list_body").append(html);
                    $(".floatTextBox").inputFilter(function(value) {
                        return /^-?\d*[.,]?\d*$/.test(value);
                    });

                    $('#expense_type'+i).on('select2:open',function(){
                        $("#select2-expense_type"+i+"-results").siblings('div').remove();
                        $("#select2-expense_type"+i+"-results").parent('span').prepend("<div class='select2-results__option'>" + jQuery('#prowrp'+i).html() + "</div>");
                    });

                    $('.amounts-are-select3').select2();
                    //$('.ex-type').trigger('change')
                }
            });
        });

        $(document).on('keyup change','.rate-input',function(){
            var qty = $(this).parent('td').siblings('td').find('.quantity-input').val();
            if(qty == null || qty == '') {
                qty = 0;
            }
            var amount = $(this).val() * qty;
            $(this).parent('td').next('td').find('.amount-input').val(amount);
            taxCalculation();
        });

        $(document).on('keyup change','.quantity-input',function(){
            var rate = $(this).parent('td').next('td').find('.rate-input').val();
            var val = $(this).val();
            if(rate == null || rate == '') {
                rate = 0;
            }
            if(val == null || val == '') {
                val = 0;
            }
            var amount = val * rate;
            $(this).parent('td').next('td').next('td').find('.amount-input').val(amount);
            if(val == 0 || val == '') {
                $(this).parent('td').next('td').find('.rate-input').val(0);
            }
            taxCalculation();
        });

        $(document).on('keyup change','.amount-input',function(){
            var qty = $(this).parent('td').prev('td').prev('td').find('.quantity-input').val();
            var val = $(this).val();
            if(qty == null || qty == '') {
                qty = 0;
            }
            if(val == null || val == '') {
                val = 0;
            }
            var rate = val / qty;
            if(isNaN(rate)) {
                rate = 0;
            }
            $(this).parent('td').prev('td').find('.rate-input').val(rate);
            taxCalculation();
        });

        $(document).on('click', '.remove-line-item', function(){
            $(this).parents('.itemNewCheckTr').prev('.itemTr').remove();
            $(this).parents('.itemNewCheckTr').remove();
            var i = 2;
            $('.itemNewCheckTr').each(function(){
                $(this).children('td:first-child').html(i);
                i++;
            });
            taxCalculation();
        });

        $(document).on('change','.tax-input, #amounts_are', function(){
            taxCalculation();
        });
        $(document).on('change','#amounts_are', function(){
            var val = $(this).val();
            if(val == 'out_of_scope') {
                $('.tax-column').hide();
            } else {
                $('.tax-column').show();
            }
        });
        $('form.formExpense').validate();
    });

    function subTotal() {
        amount = 0;
        $('.amount-input').each(function(){
            var val = $(this).val();
            if(val == null || val == '') {
                val = 0;
            }
            amount += parseFloat(val);
        });

        var tax_type = $('#amounts_are').find(":selected").val();
        var final_amount = 0;
        if(tax_type == 'exclusive') {
            final_amount = amount;
        } else if(tax_type == 'inclusive') {
            var total_tax_amount = getTotalTax();
            final_amount = parseFloat(amount) - parseFloat(total_tax_amount);
        } else {
            final_amount = amount;
        }
        $('#subtotal').val('Rs. ' + final_amount.toFixed(2));

        $('.tax-label').html(final_amount.toFixed(2));
        return final_amount.toFixed(2);
    }

    function getTotalTax() {
        total_tax_amount = 0;
        $('.tax-input-row').each(function() {
            var val = $(this).val();
            if(!$(this).parent('td').parent('tr').hasClass('hide')){
                val = val.replace('Rs. ','');
                if(val == null || val == '') {
                    val = 0;
                }
                total_tax_amount += parseFloat(val);
            }
        });
        return total_tax_amount;
    }

    function taxCalculation() {

        var subtotal = subTotal();
        var tax_type = $('#amounts_are').find(":selected").val();
        var tax = 0;
        var total = 0;
        var amount_before_tax = 0;

        var tax_arr = [];
        var tax_total_arr = [];
        var i = 0;

        var discount_type = $('#discount_type').val();

        $('.tax-input').find('option').each(function() {
            var str = $(this).filter(":selected").text();
            var opt = $(this).text();
            var opt_str = opt.replace("% ", "_").replace(" + ","+").replace(" ", "_").replace("%", "");
            var tax_str = str.replace("% ", "_").replace(" + ","+").replace(" ", "_").replace("%", "");
            var is_cess = false;
            var cess_arr = [];
            if (tax_str.indexOf('CESS') > -1) {
                is_cess = true;
                cess_arr = tax_str.split("+");
            }
            var amount = 0;
            amount = $(this).parent('select').parent('td').prev('td').find('.amount-input').val();

            if(cess_arr.length > 0 && is_cess) {
                for(var r=0;r < cess_arr.length;r++){
                    tax_str = cess_arr[r];
                    var opt1_str = opt_str.substr(0, opt_str.indexOf('+'));
                    var opt2_str = opt_str.split('+').pop();
                    var tax_name = tax_str.split('_').pop();
                    var tax_rate = tax_str.substr(0, tax_str.indexOf('_'));
                    var tax_raw_html = '';
                    var tax_id = $(this).val();
                    if(tax_str != '') {
                        var tax_hidden = 0;
                        tax_hidden += parseFloat(amount);
                        $("#id_"+ tax_str).val(tax_hidden);
                    }

                    var cls_opt_str1 = "." + opt1_str;
                    var cls_opt_str2 = "." + opt2_str;

                    $(cls_opt_str1).addClass("hide");
                    $(cls_opt_str2).addClass("hide");

                    if(tax_str != '' && tax_str !=  null) {
                        tax_arr[i] = tax_str;
                        if(tax_total_arr.hasOwnProperty(tax_str)) {
                            tax_total_arr[tax_str] += parseFloat(amount);
                        } else {
                            tax_total_arr[tax_str] = parseFloat(amount);
                        }
                        i++;
                    }
                }
            } else {
                var tax_name = tax_str.split('_').pop();
                var tax_rate = tax_str.substr(0, tax_str.indexOf('_'));
                var tax_raw_html = '';
                var tax_id = $(this).val();

                if(tax_str != '') {
                    var tax_hidden = 0;
                    tax_hidden += parseFloat(amount);
                    $("#id_"+ tax_str).val(tax_hidden);
                }
                if (opt_str.indexOf('CESS') > -1) {
                    var opt_str2 = opt_str.substr(0, opt_str.indexOf('+'));
                    opt_str = opt_str.split('+').pop();
                    $('.'+opt_str2).addClass("hide");
                }
                var cls_opt_str = "." + opt_str;
                $(cls_opt_str).addClass("hide");
                if(tax_str != '' && tax_str !=  null) {
                    tax_arr[i] = tax_str;
                    if(tax_total_arr.hasOwnProperty(tax_str)) {
                        tax_total_arr[tax_str] += parseFloat(amount);
                    } else {
                        tax_total_arr[tax_str] = parseFloat(amount);
                    }
                    i++;
                }
            }
        });
        $('.amount-input').each(function() {
            var tax_text = $(this).parent('td').next('td').find('.tax-input').find(":selected").text();
            var amount = parseFloat($(this).val());
        });

        if(tax_type != 'out_of_scope') {
            for(var a=0; a < tax_arr.length; a++) {
                $("."+tax_arr[a]).removeClass("hide");
            }
        }

        for (var key in tax_total_arr) {

            var value = parseFloat(tax_total_arr[key]);
            var tax = key.split('_')[1];
            var tax_rate = key.substr(0, key.indexOf('_'));
            var tax_amount = 0;

            if(tax == 'GST') {
                if(tax_type == 'exclusive') {
                    var tax_rate_gst = tax_rate / 2;
                    if(isNaN(value)) {
                        value=0;
                    }
                    $("#label_1_"+key).html(value.toFixed(2));
                    $("#label_2_"+key).html(value.toFixed(2));
                    tax_amount = value * tax_rate_gst / 100;
                    amount_before_tax = parseFloat(subtotal).toFixed(2);
                    if(isNaN(tax_amount)) {
                        tax_amount=0;
                    }
                    $("#input_1_"+key).val("Rs. "+tax_amount.toFixed(2));
                    $("#input_2_"+key).val("Rs. "+tax_amount.toFixed(2));
                } else if(tax_type == 'inclusive') {
                    var tax_rate_gst = tax_rate / 2;
                    tax_amount = value * tax_rate / (parseInt(100) + parseInt(tax_rate));
                    var new_value = parseFloat(value) - parseFloat(tax_amount);
                    if(isNaN(new_value)) {
                        new_value=0;
                    }
                    amount_before_tax = parseFloat(new_value).toFixed(2);
                    $("#label_1_"+key).html(new_value.toFixed(2));
                    $("#label_2_"+key).html(new_value.toFixed(2));
                    var new_tax_value = tax_amount / 2;
                    if(isNaN(new_tax_value)) {
                        new_tax_value=0;
                    }
                    $("#input_1_"+key).val("Rs. "+new_tax_value.toFixed(2));
                    $("#input_2_"+key).val("Rs. "+new_tax_value.toFixed(2));
                }
            } else {
                if(tax_type == 'exclusive') {
                    tax_amount = value * tax_rate / 100;
                    amount_before_tax = parseFloat(subtotal).toFixed(2);
                    if(isNaN(value)) {
                        value=0;
                    }
                    $("#label_"+key).html(value.toFixed(2));
                } else if(tax_type == 'inclusive') {
                    tax_amount = value * tax_rate / (parseInt(100) + parseInt(tax_rate));
                    var new_value = parseFloat(value) - parseFloat(tax_amount);
                    if(isNaN(new_value)) {
                        new_value=0;
                    }
                    amount_before_tax = parseFloat(new_value).toFixed(2);
                    $("#label_"+key).html(new_value.toFixed(2));
                }
                if(isNaN(tax_amount)) {
                    tax_amount=0;
                }
                $("#input_"+key).val("Rs. "+tax_amount.toFixed(2));
            }
        }
        var total_tax = getTotalTax();
        if(tax_type == 'exclusive') {
            total = parseFloat(subtotal) + parseFloat(total_tax);
        } else if(tax_type == 'inclusive') {
            subtotal = subTotal();
            amount_before_tax = parseFloat(subtotal);
            total = parseFloat(subtotal) + parseFloat(total_tax);
        } else {
            total_tax = 0;
            amount_before_tax = parseFloat(subtotal).toFixed(2);
            total = parseFloat(subtotal);
        }
        if(discount_type != '') {
            if(discount_type == '1'){
                var percentage = $('#discount').inputmask('unmaskedvalue');
                var percentage_amount = (total * percentage) / 100;
                total = total - percentage_amount;
            } else if(discount_type == '2'){
                var discount = $('#discount').inputmask('unmaskedvalue');
                total = total - discount;
            }
        }

        $('#total').val('Rs. '+ parseFloat(total).toFixed(2));
        $('#amount_before_tax').val(amount_before_tax);
        $('#tax_amount').val(total_tax.toFixed(2));
        $('#total_amount').val(parseFloat(total).toFixed(2));
    }

    @if(isset($expense) && !empty($expense))
        $(document).ready(function(){
            taxCalculation();
        });

    function deleteAttachment(aid){
        Swal.fire({
            title: 'Are you want to delete this receipt?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
            $.ajax({
                url: '{{url('ajax/expense_delete_attachment')}}',
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
    @endif

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
</script>
@endsection
