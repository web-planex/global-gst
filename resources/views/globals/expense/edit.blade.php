@extends('layouts.app')
@section('content')

<div class="row page-titles">
    <div class="col-sm-6 align-self-center">
        <h4 class="text-themecolor">Edit Expense</h4>
    </div>
</div>
<div class="content">
    @include('inc.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="box card">
                <form action="{{route('expense-update',$expense['id'])}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-3 pull-right">
                            <label>Amounts are</label>
                            <select class="form-control" name="tax_type" id="amounts_are">
                                <option value="exclusive" {{$expense['tax_type'] == 1 ? 'selected' : ''}}>Exclusive of Tax</option>
                                <option value="inclusive" {{$expense['tax_type'] == 2 ? 'selected' : ''}}>Inclusive of Tax</option>
                                <option value="out_of_scope" {{$expense['tax_type'] == 3 ? 'selected' : ''}}>Out of scope of Tax</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="payee">Payee <span class="text-danger">*</span></label>
                            {!! Form::select('payee', $payees, $expense['payee_id'], ['class' => 'form-control', 'id' => 'payee']) !!}
                            @if ($errors->has('payee'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payee') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="payment_account">Payment account <span class="text-danger">*</span></label>
                            {!! Form::select('payment_account', $payment_accounts, $expense['payment_account_id'], ['class' => 'form-control', 'id' => 'payment_account']) !!}
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
                            {!! Form::text('payment_date', date('d-m-Y',strtotime($expense['payment_date'])), ['class' => 'form-control','id'=>'payment_date']) !!}
                            @if ($errors->has('payment_date'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_date') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="payment_method">Payment method</label>
                            {!! Form::select('payment_method', \App\Models\Globals\Expense::$payment_method, $expense['payment_method'], ['class' => 'form-control', 'id' => 'payment_method']) !!}
                            @if ($errors->has('payment_method'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payment_method') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="ref_no">Ref no.</label>
                            {!! Form::text('ref_no', $expense['ref_no'], ['class' => 'form-control','id'=>'ref_no']) !!}
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
                                                    <th width="28%">Item Name</th>
                                                    <th width="28%">Description</th>
                                                    <th width="10%">QTY</th>
                                                    <th width="13%">Rate</th>
                                                    <th width="13%">Amount</th>
                                                    <th width="5%">&nbsp;</th>
                                                </thead>
                                                <tbody id="items_list_body">
                                                    @php $i=1; @endphp
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
                                                            <input type="number" min="0" class="form-control quantity-input" name="quantity[]" value="{{$item['quantity']}}">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" class="form-control rate-input" name="rate[]" value="{{$item['rate']}}">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" class="form-control amount-input" name="amount[]" value="{{$item['amount']}}">
                                                        </td>
                                                        <td>
                                                            @if($i>1)
                                                            <button type="button" class="btn btn-danger btn-circle remove-line-item"><i class="fa fa-times"></i></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <table class="table table-hover" style="width: 40%;float: right;">
                                                <tr>
                                                    <th>Tax</th>
                                                    <td>
                                                        <select id="taxes" class="form-control tax-input" name="taxes">
                                                            @foreach($taxes as $tax)
                                                            <option value="{{$tax['id']}}">{{$tax['rate'].'% '.$tax['tax_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="subtotal_row">
                                                    <th width="50%">Subtotal</th>
                                                    <td width="50%">
                                                        <input type="text" class="form-control" id="subtotal" readonly="" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-bottom: 0;padding-top: 0;">
                                                        <table width="100%"><tr></tr></table>
                                                    </td>
                                                </tr>
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
                    <button type="submit" name="submit" class="btn btn-default btn-lg btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        taxCalculation();
        $(document).on('change','#amounts_are',function(){
            taxCalculation();
        });

        $("#addItem").click(function () {
            var numItems = $('.itemTr').length;
            var i = numItems + 1;

            var row = $("<tr>").addClass("itemTr");

            $("#items_list_body").append(row);

            var html = "<tr class=\"itemNewCheckTr\">";
            html += "<td>" + i + "</td>";
            html += "<td><input type=\"text\" class=\"form-control\" name=\"item_name[]\"></td>";
            html += "<td><input type=\"text\" class=\"form-control\" name=\"description[]\"></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control quantity-input\" name=\"quantity[]\"></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control rate-input\" name=\"rate[]\"></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control amount-input\" name=\"amount[]\"></td>";
            html += "<td><button type=\"button\" class=\"btn btn-danger btn-circle remove-line-item \"><i class=\"fa fa-times\"></i> </button></td>";
            html += "</tr>";
            $("#items_list_body").append(html);
        });

        $(document).on('keyup change','.rate-input',function(){
            var qty = $(this).parent('td').siblings('td').find('.quantity-input').val();
            var amount = $(this).val() * qty;
            $(this).parent('td').next('td').find('.amount-input').val(amount);
            taxCalculation(this)
        });

        $(document).on('keyup change','.quantity-input',function(){
            var rate = $(this).parent('td').next('td').find('.rate-input').val();
            var amount = $(this).val() * rate;
            $(this).parent('td').next('td').next('td').find('.amount-input').val(amount);
            if($(this).val() == 0) {
                $(this).parent('td').next('td').find('.rate-input').val(0);
            }
            taxCalculation();
        });

        $(document).on('keyup change','.amount-input',function(){
            var qty = $(this).parent('td').prev('td').prev('td').find('.quantity-input').val();
            var rate = $(this).val() / qty;
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

        function taxCalculation() {
            var subtotal = subTotal();
            var tax_rate = $('.tax-input').find(":selected").val();
            var tax_text = $('.tax-input').find(":selected").text();
            var tax_raw_html = '<tr><th width="50%" colspan="2" style="display:block;margin-top:10px;width:100%;padding:0;border:none;">' + tax_text + ' on ' + subtotal + '</th>';
            var tax_type = $('#amounts_are').find(":selected").val();
            var tax = 0;
            var total = 0;
            var amount_before_tax = 0;
            if(tax_type == 'exclusive') {
                tax = subtotal * tax_rate / 100;
                var tax_raw_html = '<tr><th width="50%" colspan="2" style="display:block;margin-top:10px;width:100%;padding:0;border:none;">' + tax_text + ' on Rs. ' + parseFloat(subtotal).toFixed(2) + '</th>';
                amount_before_tax = parseFloat(subtotal).toFixed(2);
                total = parseFloat(subtotal) + parseFloat(tax);
            } else if(tax_type == 'inclusive') {
                tax = subtotal * tax_rate / (parseInt(100) + parseInt(tax_rate));
                var new_subtotal = parseFloat(subtotal) - parseFloat(tax);
                var tax_raw_html = '<tr><th width="50%" colspan="2" style="display:block;margin-top:10px;width:100%;padding:0;border:none;">' + tax_text + ' on Rs. ' + parseFloat(new_subtotal).toFixed(2) + '</th>';
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
            taxCalculation();
        });
    });
</script>
@endsection
