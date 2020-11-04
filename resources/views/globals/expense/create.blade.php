@extends('layouts.app')
@section('content')

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
                <form action="{{route('payment-account-insert')}}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-3 pull-right">
                            <label>Amounts are</label>
                            <select class="form-control" id="amounts_are">
                                <option value="exclusive">Exclusive of Tax</option>
                                <option value="inclusive">Inclusive of Tax</option>
                                <option value="out_of_scope">Out of scope of Tax</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="payee">Payee *</label>
                            {!! Form::select('payee', $payees, null, ['class' => 'form-control', 'id' => 'payee']) !!}
                            @if ($errors->has('payee'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('payee') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="payment_account">Payment account *</label>
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
                            <label for="payment_date">Payment date *</label>
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
                            <label for="red_no">Ref no.</label>
                            {!! Form::text('red_no', null, ['class' => 'form-control','id'=>'red_no']) !!}
                            @if ($errors->has('red_no'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('red_no') }}</strong>
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
                                                    <th width="23%">Item Name</th>
                                                    <th width="23%">Description</th>
                                                    <th width="9%">QTY</th>
                                                    <th width="13%">Rate</th>
                                                    <th width="13%">Amount</th>
                                                    <th width="15%">Tax</th>
                                                </thead>
                                                <tbody id="items_list_body">
                                                    <tr class="itemTr">
                                                        <td>1</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="item_name[]">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="description[]">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" class="form-control quantity-input" name="quantity[]">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" class="form-control rate-input" name="rate[]">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" class="form-control amount-input" name="amount[]">
                                                        </td>
                                                        <td>
                                                            <select id="taxes" class="form-control tax-input" name="taxes[]">
                                                                @foreach($taxes as $tax)
                                                                <option value="{{$tax['rate']}}">{{$tax['rate'].'% '.$tax['tax_name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
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
                                                <tr>
                                                    <td colspan="2">
                                                        <table><tr></tr></table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="50%">Total</th>
                                                    <td width="50%">&nbsp;</td>
                                                </tr>
                                            </table>
                                            <button type="button" id="addItem" class="btn btn-primary btn-sm">Add Lines</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','#amounts_are',function(){
            tax_type = $(this).find(":selected").val();
        });
        
        $("#addItem").click(function () {
            var numItems = $('.itemTr').length;
            var i = numItems + 1;

            var row = $("<tr>").addClass("itemTr");

            $("#items_list_body").append(row);
            var tax_options = $('#taxes').html();
            var html = "<tr class=\"itemNewCheckTr\">";
            html += "<td>" + i + "</td>";
            html += "<td><input type=\"text\" class=\"form-control\" name=\"item_name[]\"></td>";
            html += "<td><input type=\"text\" class=\"form-control\" name=\"description[]\"></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control quantity-input\" name=\"quantity[]\"></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control rate-input\" name=\"rate[]\"></td>";
            html += "<td><input type=\"number\" min=\"0\" class=\"form-control amount-input\" name=\"amount[]\"></td>";
            html += "<td><select class=\"form-control tax-input\" name=\"taxes[]\">"+tax_options+"</select></td>";
            html += "</tr>";
            $("#items_list_body").append(html);
        });

        $(document).on('change','.rate-input',function(){
            var qty = $(this).parent('td').siblings('td').find('.quantity-input').val();
            var amount = $(this).val() * qty;
            $(this).parent('td').next('td').find('.amount-input').val(amount);
            taxCalculation(this)
        });

        $(document).on('change','.quantity-input',function(){
            var rate = $(this).parent('td').next('td').find('.rate-input').val();
            var amount = $(this).val() * rate;
            $(this).parent('td').next('td').next('td').find('.amount-input').val(amount);
            subTotal();
            taxCalculation(this)
        });

        $(document).on('change','.amount-input',function(){
            var qty = $(this).parent('td').prev('td').prev('td').find('.quantity-input').val();
            var rate = $(this).val() / qty;
            $(this).parent('td').prev('td').find('.rate-input').val(rate);
            subTotal();
            taxCalculation(this)
        });

        function subTotal() {
            amount = 0;
            $('.amount-input').each(function(){
                amount += parseInt($(this).val());
            });
            $('#subtotal').val(amount.toFixed(2));
            
            $('.tax-label').html(amount.toFixed(2));
            return amount.toFixed(2);
        }
        
        function taxCalculation(ele) {
            var subtotal = subTotal();
            var tax_rate = $(ele).parent('td').next('td').next('td').find('select').find(":selected").val();
            var tax_text = $(ele).parent('td').next('td').next('td').find('select').find(":selected").text();
            var tax_raw_html = '<tr><td>' + tax_text + ' on ' + subtotal + '</td>';
            var tax_type = $('#amounts_are').find(":selected").val();
            
            var tax = 0;
            
            if(tax_type == 'exclusive') {
                tax = subtotal * tax_rate / 100;
            } else if(tax_type == 'inclusive') {
                tax = subtotal * tax_rate / (100 + tax_rate);
            }
            tax_raw_html += '<td>' + tax + '</td>';
            $('#subtotal_row').siblings('tr').find('table').html(tax_raw_html);
        }

        $(document).on('change','.tax-input', function(){
            var tax = $(this).val();
        });
    });
</script>
@endsection
