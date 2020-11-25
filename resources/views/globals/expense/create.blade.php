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
</style>
<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">Add Expense</h4>
    </div>
</div>
<div class="content">
    @include('inc.message')
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
                        <div class="form-group mb-3 col-md-3 pull-right">
                            <label>Amounts are</label>
                            <select class="form-control amounts-are-select2" name="tax_type" id="amounts_are">
                                <option value="exclusive" @if(isset($expense) && $expense['tax_type']==1)) selected @endif>Exclusive of Tax</option>
                                <option value="inclusive" @if(isset($expense) && $expense['tax_type']==2)) selected @endif>Inclusive of Tax</option>
                                <option value="out_of_scope" @if(isset($expense) && $expense['tax_type']==3)) selected @endif>Out of scope of Tax</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="payee">Payee <span class="text-danger">*</span></label>
                            {!! Form::select('payee', $payees, isset($expense)&&!empty($expense)?$expense['payee_id']:null, ['class' => 'form-control amounts-are-select2', 'id' => 'payee']) !!}
                            <div class="wrapper" id="wrp" style="display: none;">
                                <a href="javascript:;" id="type" class="font-weight-300" onclick="OpenUserTypeModal()"><i class="fa fa-plus-circle"></i> Add New</a>
                            </div>
                            @if ($errors->has('payee'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payee') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="payment_account">Payment account <span class="text-danger">*</span></label>
                            {!! Form::select('payment_account', $payment_accounts, isset($expense)&&!empty($expense)?$expense['payment_account_id']:null, ['class' => 'form-control amounts-are-select2', 'id' => 'payment_account']) !!}
                            <div class="wrapper" id="wrp2" style="display: none;">
                                <a href="javascript:;" id="type2" class="font-weight-300" onclick="OpenPaymentAccountModal()"><i class="fa fa-plus-circle"></i> Add New</a>
                            </div>
                            @if ($errors->has('payment_account'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_account') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_date">Payment date <span class="text-danger">*</span></label>
                            {!! Form::text('payment_date', isset($expense)&&!empty($expense)?date('d-m-Y',strtotime($expense['payment_date'])):null, ['class' => 'form-control','id'=>'payment_date']) !!}
                            @if ($errors->has('payment_date'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_date') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_method">Payment method</label>
                            {!! Form::select('payment_method', \App\Models\Globals\Expense::$payment_method, null, ['class' => 'form-control amounts-are-select2', 'id' => 'payment_method']) !!}
                            @if ($errors->has('payment_method'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_method') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="ref_no">Ref no.</label>
                            {!! Form::text('ref_no', null, ['class' => 'form-control','id'=>'ref_no']) !!}
                            @if ($errors->has('ref_no'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('ref_no') }}</strong>
                                </span>
                            @endif
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
                                            <table id="" class="table table-hover">
                                                <thead>
                                                    <th width="3%">#</th>
                                                    <th width="20%">Item Name <span class="text-danger">*</span></th>
                                                    <th width="20%">Description <span class="text-danger">*</span></th>
                                                    <th width="10%">QTY <span class="text-danger">*</span></th>
                                                    <th width="13%">Rate <span class="text-danger">*</span></th>
                                                    <th width="13%">Amount <span class="text-danger">*</span></th>
                                                    <th width="16%">Tax <span class="text-danger">*</span></th>
                                                    <th width="5%">&nbsp;</th>
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
                                                            <td>
                                                                <input type="text" class="form-control" name="item_name[]" value="{{$item['item_name']}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="description[]" value="{{$item['description']}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" min="0" class="form-control quantity-input floatTextBox" name="quantity[]" value="{{$item['quantity']}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" min="0" class="form-control rate-input floatTextBox" name="rate[]" value="{{$item['rate']}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" min="0" class="form-control amount-input floatTextBox" name="amount[]" value="{{$item['amount']}}">
                                                            </td>
                                                            <td id="taxes">
                                                                <select id="taxes" class="form-control tax-input" name="taxes[]">
                                                                    @foreach($taxes as $tax)
                                                                        <option value="{{$tax['id']}}" @if(!empty($item['tax_id']) && $item['tax_id']==$tax['id'])) selected @endif>{{$tax['rate'].'% '.$tax['tax_name']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                @if($i>1)
                                                                    <button type="button" class="btn btn-danger btn-circle remove-line-item"><i class="fa fa-times"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                @else
                                                    <tr class="itemTr">
                                                        <td>1</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="item_name[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="description[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control quantity-input floatTextBox" name="quantity[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control rate-input floatTextBox" name="rate[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control amount-input floatTextBox" name="amount[0]" required>
                                                        </td>
                                                        <td id="taxes">
                                                            <select class="form-control tax-input" name="taxes[]" required>
                                                                @foreach($taxes as $tax)
                                                                    <option value="{{$tax['id']}}">{{$tax['rate'].'% '.$tax['tax_name']}}</option>
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
                                                        <input type="text" class="form-control" id="subtotal" readonly="" />
                                                    </td>
                                                </tr>
                                                @foreach($taxes as $tax)
                                                    @if($tax['tax_name'] == 'GST')
                                                    <tr class="{{$tax['rate'].'_'.$tax['tax_name']}} hide">
                                                        <th width='50%'>{{$tax['rate'] / 2}}% CGST on Rs. <span id="label_1_{{$tax['rate'].'_'.$tax['tax_name']}}">0.00</span></th>
                                                        <td width='50%'><input type="text" id="input_1_{{$tax['rate'].'_'.$tax['tax_name']}}" class="form-control tax-input-row" readonly></td>
                                                    </tr>
                                                    <tr class="{{$tax['rate'].'_'.$tax['tax_name']}} hide">
                                                        <th width='50%'>{{$tax['rate'] / 2}}% SGST on Rs. <span id="label_2_{{$tax['rate'].'_'.$tax['tax_name']}}">0.00</span></th>
                                                        <td width='50%'><input type="text" id="input_2_{{$tax['rate'].'_'.$tax['tax_name']}}" class="form-control tax-input-row" readonly></td>
                                                    </tr>
                                                    @else
                                                    <tr class="{{$tax['rate'].'_'.$tax['tax_name']}} hide">
                                                        <th width='50%'>{{$tax['rate'].'% '.$tax['tax_name']}} on Rs. <span id="label_{{$tax['rate'].'_'.$tax['tax_name']}}">0.00</span></th>
                                                        <td width='50%'><input type="text" id="input_{{$tax['rate'].'_'.$tax['tax_name']}}" class="form-control tax-input-row" readonly></td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <th width="50%">Total</th>
                                                    <td width="50%"><input type="text" class="form-control" id="total" readonly="" /></td>
                                                </tr>
                                            </table>
                                            <input type="hidden" name="amount_before_tax" id="amount_before_tax" />
                                            <input type="hidden" name="tax_amount" id="tax_amount" />
                                            <input type="hidden" name="total" id="total_amount" />
                                            <button type="button" id="addItem" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Lines</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="submit" id="submit" class="btn btn-default btn-lg btn-primary">Submit</button>
{{--                </form>--}}
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


<script type="text/javascript">
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
                country: "required",
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
                country: "The country field is required",
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
                country: "required",
                gender: "required",
                hire_date: "required",
                billing_street: "required",
                billing_city: "required",
                billing_state: "required",
                billing_pincode: "required",
                billing_country: "required",
                shipping_street: "required",
                shipping_city: "required",
                shipping_state: "required",
                shipping_pincode: "required",
                shipping_country: "required",
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
                country: "The country field is required",
                gender: "The gender field is required",
                hire_date: "The hire date field is required",
                billing_street: "The billing street field is required",
                billing_city: "The billing city field is required",
                billing_state: "The billing state field is required",
                billing_pincode: "The billing pincode field is required",
                billing_country: "The billing country field is required",
                shipping_street: "The shipping street field is required",
                shipping_city: "The shipping city field is required",
                shipping_state: "The shipping state field is required",
                shipping_pincode: "The shipping pincode field is required",
                shipping_country: "The shipping country field is required",

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
                country: "required",
                gender: "required",
                hire_date: "required",
                billing_street: "required",
                billing_city: "required",
                billing_state: "required",
                billing_pincode: "required",
                billing_country: "required",
                shipping_street: "required",
                shipping_city: "required",
                shipping_state: "required",
                shipping_pincode: "required",
                shipping_country: "required",
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
                country: "The country field is required",
                gender: "The gender field is required",
                hire_date: "The hire date field is required",
                billing_street: "The billing street field is required",
                billing_city: "The billing city field is required",
                billing_state: "The billing state field is required",
                billing_pincode: "The billing pincode field is required",
                billing_country: "The billing country field is required",
                shipping_street: "The shipping street field is required",
                shipping_city: "The shipping city field is required",
                shipping_state: "The shipping state field is required",
                shipping_pincode: "The shipping pincode field is required",
                shipping_country: "The shipping country field is required",
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
                        $('#PaymentAccountModal').modal('hide');
                        $('html, body').css('overflowY', 'auto');
                        $("#PaymentAccountForm")[0].reset();
                    }
                });
            }
        });
    });

    $(document).ready(function(){
        var flg = 0;
        var flg2 = 0;
        $('#payee').on("select2:open", function () {
            flg++;
            if (flg == 1) {
                $this_html = jQuery('#wrp').html();
                $(".select2-results").prepend("<div class='select2-results__option'>" +
                $this_html + "</div>");
            }
        });

        $('#payment_account').on("select2:open", function () {
            flg2++;
            if (flg2 == 1) {
                $this_html2 = jQuery('#wrp2').html();
                $(".select2-results").last().prepend("<div class='select2-results__option'>" +
                    $this_html2 + "</div>");
            }
        });

        $(document).on('change', '#amounts_are',function(){
            taxCalculation();
        });

        $("#addItem").click(function () {
            var numItems = $('.itemTr').length;
            var i = numItems + 1;

            var row = $("<tr>").addClass("itemTr");

            $("#items_list_body").append(row);
            var tax_input = $('#taxes').html();
            var html = "<tr class=\"itemNewCheckTr\">";
            html += "<td>" + i + "</td>";
            html += "<td><input type=\"text\" class=\"form-control\" name=\"item_name["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td><input type=\"text\" class=\"form-control\" name=\"description["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td><input type=\"text\" min=\"0\" class=\"form-control quantity-input floatTextBox\" name=\"quantity["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td><input type=\"text\" min=\"0\" class=\"form-control rate-input floatTextBox\" name=\"rate["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td><input type=\"text\" min=\"0\" class=\"form-control amount-input floatTextBox\" name=\"amount["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td>"+tax_input+"</td>";
            html += "<td><button type=\"button\" class=\"btn btn-danger btn-circle remove-line-item \"><i class=\"fa fa-times\"></i> </button></td>";
            html += "</tr>";
            $("#items_list_body").append(html);
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

        $(document).on('change','.tax-input', function(){
            taxCalculation();
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

        $('.tax-input').find('option').each(function() {
            var str = $(this).filter(":selected").text();
            var opt = $(this).text();
            var opt_str = opt.replace("% ", "_");
            var tax_str = str.replace("% ", "_");
            var amount = 0;
            amount = $(this).parent('select').parent('td').prev('td').find('.amount-input').val();

            var tax_name = tax_str.split('_').pop();
            var tax_rate = tax_str.substr(0, tax_str.indexOf('_'));
            var tax_raw_html = '';
            var tax_id = $(this).val();
            if(tax_str != '') {
                var tax_hidden = 0;
                tax_hidden += parseFloat(amount);
                $("#id_"+ tax_str).val(tax_hidden);
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

        $('#total').val('Rs. '+ parseFloat(total).toFixed(2));
        $('#amount_before_tax').val(amount_before_tax);
        $('#tax_amount').val(total_tax.toFixed(2));
        $('#total_amount').val(parseFloat(total).toFixed(2));
    }

    @if(isset($expense) && !empty($expense))
        $(document).ready(function(){
            taxCalculation();
        });
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
