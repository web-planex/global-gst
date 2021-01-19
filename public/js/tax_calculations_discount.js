$(document).ready(function() {

    $("#discount_level").change(function(){
        var level = $(this).val();
        if(level == 1) {
            $(".discount-section").hide();
            $(".discount-line-section").show();
            $("#discount_type").val("");
            $("#discount").val("");
        } else {
            $(".discount-section").show();
            $(".discount-line-section").hide();
        }
        discountLevelChange();
    });

    $(document).on('change','.discount-type-items', function(){
        if($(this).val() == 1) {
            $(this).siblings('.discount-items').inputmask('decimal',{min:0, max:100});
        } else {
            $(this).siblings('.discount-items').inputmask('currency');
        }
    });

    $(document).on('keyup change','.rate-input',function(){
        var qty = $(this).parent('td').siblings('td').find('.quantity-input').val();
        if(qty == null || qty == '') {
            qty = 0;
        }
        var amount = $(this).val() * qty;
        $(this).parent('td').next('td').next('td').find('.amount-input').val(amount);
        $('.discount-items').trigger('change');
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
        $(this).parent('td').next('td').next('td').next('td').find('.amount-input').val(amount);
        if(val == 0 || val == '') {
            $(this).parent('td').next('td').find('.rate-input').val(0);
        }
        taxCalculation();
    });

    /*$(document).on('keyup change','.amount-input',function(){
        var qty = $(this).parent('td').prev('td').prev('td').prev('td').find('.quantity-input').val();
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
        $(this).parent('td').prev('td').prev('td').find('.rate-input').val(rate);
        taxCalculation();
    });*/

    $(document).on('keyup change', '.discount-items', function(){
        var discount_val = $(this).inputmask('unmaskedvalue');
        var dis_type = $(this).siblings('.discount-type-items').val(); // 1 => %, 2 => Rs.
        var quantity = $(this).parent('td').prev('td').prev('td').find('.quantity-input').val();
        var rate = $(this).parent('td').prev('td').find('.rate-input').val();
        if(isNaN(quantity)) {
            quantity = 0;
        }
        if(isNaN(rate)){
            rate = 0;
        }
        var amount = quantity * rate;
        var final_amount = amount;

        if(dis_type == 1 && discount_val != '' && discount_val != 0) {
            console.log(amount +" * "+ discount_val);
            var discount_amount = (amount * discount_val)  / 100;
            final_amount = amount - discount_amount;
        } else if(dis_type == 2 && discount_val != '' && discount_val != 0) {
            final_amount = amount - discount_val;
        }
        $(this).parent('td').next('td').find('.amount-input').val(final_amount.toFixed(2));
        taxCalculation();
    });

    $(document).on('change','.tax-input, #amounts_are', function(){
        if($('#amounts_are').val()=='out_of_scope'){
            $('.tax_column').each(function(){
                $(this).hide();
            });
        }else{
            $('.tax_column').each(function(){
                $(this).show();
            });
        }
        taxCalculation();
    });
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
    var discount_level = $("#discount_level").find(":selected").val();
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

function discountLevelChange(){
    $(".discount-type-items").each(function(){
        if($(this).val() == 1) {
            $(this).siblings('.discount-items').inputmask('decimal',{min:0, max:100});
        } else {
            $(this).siblings('.discount-items').inputmask('currency');
        }
    });
}
