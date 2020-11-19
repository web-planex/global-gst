@extends('layouts.app')
@section('content')
<style>
.tr-tax-lable {
    display:block;
    margin-top:10px;
    width:100%;
    padding:5px 0 !important
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
                <form id="formExpense" action="{{route('expense-insert')}}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-3 pull-right">
                            <label>Amounts are</label>
                            <select class="form-control amounts-are-select2" name="tax_type" id="amounts_are">
                                <option value="exclusive">Exclusive of Tax</option>
                                <option value="inclusive">Inclusive of Tax</option>
                                <option value="out_of_scope">Out of scope of Tax</option>
                            </select>
                            <div class="wrapper" id="wrp" style="display: none;">
                            <a href="#" id="type" class="font-weight-300" data-target="#mdl_Item" data-toggle="modal"><i class="fa fa-plus-circle"></i> Add New Vendor</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="payee">Payee <span class="text-danger">*</span></label>
                            {!! Form::select('payee', $payees, null, ['class' => 'form-control', 'id' => 'payee']) !!}
                            @if ($errors->has('payee'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payee') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="payment_account">Payment account <span class="text-danger">*</span></label>
                            {!! Form::select('payment_account', $payment_accounts, null, ['class' => 'form-control', 'id' => 'payment_account']) !!}
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
                            {!! Form::text('payment_date', null, ['class' => 'form-control','id'=>'payment_date']) !!}
                            @if ($errors->has('payment_date'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_date') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_method">Payment method</label>
                            {!! Form::select('payment_method', \App\Models\Globals\Expense::$payment_method, null, ['class' => 'form-control', 'id' => 'payment_method']) !!}
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
                                                    <tr class="itemTr">
                                                        <td>1</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="item_name[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="description[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control quantity-input" name="quantity[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control rate-input" name="rate[0]" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" min="0" class="form-control amount-input" name="amount[0]" required>
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
                                                        <td width='50%'><input type="text" value="" name="" class="form-control" readonly></td>
                                                    </tr>
                                                    <tr class="{{$tax['rate'].'_'.$tax['tax_name']}} hide">
                                                        <th width='50%'>{{$tax['rate'] / 2}}% SGST on Rs. <span id="label_2_{{$tax['rate'].'_'.$tax['tax_name']}}">0.00</span></th>
                                                        <td width='50%'><input type="text" value="" name="" class="form-control" readonly></td>
                                                    </tr>
                                                    @else
                                                    <tr class="{{$tax['rate'].'_'.$tax['tax_name']}} hide">
                                                        <th width='50%'>{{$tax['rate'].'% '.$tax['tax_name']}} on Rs. <span id="label_{{$tax['rate'].'_'.$tax['tax_name']}}">0.00</span></th>
                                                        <td width='50%'><input type="text" value="" name="" class="form-control" readonly></td>
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
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change', '#amounts_are',function(){
            //taxCalculation();
            taxCalculationNew();
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
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control quantity-input\" name=\"quantity["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control rate-input\" name=\"rate["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control amount-input\" name=\"amount["+numItems+"]\" required><span class=\"multi-error\"></span></td>";
            html += "<td>"+tax_input+"</td>";
            html += "<td><button type=\"button\" class=\"btn btn-danger btn-circle remove-line-item \"><i class=\"fa fa-times\"></i> </button></td>";
            html += "</tr>";
            $("#items_list_body").append(html);
        });

        $(document).on('keyup change','.rate-input',function(){
            var qty = $(this).parent('td').siblings('td').find('.quantity-input').val();
            var amount = $(this).val() * qty;
            $(this).parent('td').next('td').find('.amount-input').val(amount);
            //taxCalculation();
            taxCalculationNew();
        });

        $(document).on('keyup change','.quantity-input',function(){
            var rate = $(this).parent('td').next('td').find('.rate-input').val();
            var amount = $(this).val() * rate;
            $(this).parent('td').next('td').next('td').find('.amount-input').val(amount);
            if($(this).val() == 0) {
                $(this).parent('td').next('td').find('.rate-input').val(0);
            }
            //taxCalculation();
            taxCalculationNew();
        });

        $(document).on('keyup change','.amount-input',function(){
            var qty = $(this).parent('td').prev('td').prev('td').find('.quantity-input').val();
            var rate = $(this).val() / qty;
            $(this).parent('td').prev('td').find('.rate-input').val(rate);
            //taxCalculation();
            taxCalculationNew();
        });

        $(document).on('click', '.remove-line-item', function(){
            $(this).parents('.itemNewCheckTr').prev('.itemTr').remove();
            $(this).parents('.itemNewCheckTr').remove();
            var i = 2;
            $('.itemNewCheckTr').each(function(){
                $(this).children('td:first-child').html(i);
                i++;
            });
            //taxCalculation();
            taxCalculationNew();
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
            $('#subtotal').val('Rs. ' + amount.toFixed(2));

            $('.tax-label').html(amount.toFixed(2));
            return amount.toFixed(2);
        }

        function taxCalculationNew() {
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
                $('#total').val('Rs. '+ parseFloat(total).toFixed(2));
                $('#amount_before_tax').val(amount_before_tax);
                $('#tax_amount').val(tax.toFixed(2));
                $('#total_amount').val(parseFloat(total).toFixed(2));

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
            $('.amount-input').each(function(){
                var tax_text = $(this).parent('td').next('td').find('.tax-input').find(":selected").text();
                var amount = parseFloat($(this).val());
            });
            for(var a=0; a < tax_arr.length; a++) {
                $("."+tax_arr[a]).removeClass("hide");
            }
            console.log(tax_total_arr)
            for (var key in tax_total_arr) {
                var value = parseFloat(tax_total_arr[key]);
                var tax = key.split('_')[1];
                if(tax == 'GST') {
                    $("#label_1_"+key).html(value.toFixed(2));
                    $("#label_2_"+key).html(value.toFixed(2));
                } else {
                    $("#label_"+key).html(value.toFixed(2));
                }
                console.log(tax, value);
            }
        }

        function taxCalculation() {
            var subtotal = subTotal();
            var tax_str = $('.tax-input').find(":selected").text();
            var tax_rate = tax_str.substr(0, tax_str.indexOf('%'));
            var tax_text = $('.tax-input').find(":selected").text();
            var tax_raw_html = '<tr><th width="50%" colspan="2" class="tr-tax-lable">' + tax_text + ' on ' + subtotal + '</th>';
            var tax_type = $('#amounts_are').find(":selected").val();
            var tax = 0;
            var total = 0;
            var amount_before_tax = 0;
            
            if(tax_type == 'exclusive') {
                tax = subtotal * tax_rate / 100;
                var tax_raw_html = '<tr><th width="50%" colspan="2" class="tr-tax-lable">' + tax_text + ' on Rs. ' + parseFloat(subtotal).toFixed(2) + '</th>';
                amount_before_tax = parseFloat(subtotal).toFixed(2);
                total = parseFloat(subtotal) + parseFloat(tax);
            } else if(tax_type == 'inclusive') {
                tax = subtotal * tax_rate / (parseInt(100) + parseInt(tax_rate));
                var new_subtotal = parseFloat(subtotal) - parseFloat(tax);
                var tax_raw_html = '<tr><th width="50%" colspan="2" class="tr-tax-lable">' + tax_text + ' on Rs. ' + parseFloat(new_subtotal).toFixed(2) + '</th>';
                amount_before_tax = parseFloat(new_subtotal).toFixed(2);
                total = subtotal;
            }
            
            tax_raw_html += '<td width="50%" style="padding:10px 0 10px 15px;border:none;"><input type="text" class="form-control" name="tax-amount" value="Rs. ' + tax.toFixed(2) + '" readonly=""></td>';
            
            if(tax_type == 'out_of_scope') {
                tax = 0;
                tax_raw_html = '';
                amount_before_tax = parseFloat(subtotal).toFixed(2);
                total = subtotal;
            }
            $('#subtotal_row').siblings('tr').find('table').html(tax_raw_html);
            $('#total').val('Rs. '+ parseFloat(total).toFixed(2));
            $('#amount_before_tax').val(amount_before_tax);
            $('#tax_amount').val(tax.toFixed(2));
            $('#total_amount').val(parseFloat(total).toFixed(2));
        }

        $(document).on('change','.tax-input', function(){
            taxCalculationNew();
        });
        $('form.formExpense').validate();
    });
</script>
@endsection
