<div class="modal fade bs-example-modal-lg" id="PaymentAccountModal" tabindex="-1" role="dialog" aria-labelledby="PaymentAccountModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Payment Account</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="PaymentAccountForm" action="" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row" id="PaymentAccount">
                        <div class="form-group mb-3 col-md-6">
                            <label for="accountType">Account Type <span class="text-danger">*</span></label>
                            {!! Form::select('account_type', \App\Models\Globals\PaymentAccount::$account_type, null, ['class' => 'form-control', 'id' => 'accountType']) !!}
                            @if ($errors->has('account_type'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('account_type') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="detailType">Detail Type <span class="text-danger">*</span></label>
                            {!! Form::select('detail_type', \App\Models\Globals\PaymentAccount::$current_assets, null, ['class' => 'form-control', 'id' => 'detailType']) !!}
                            @if ($errors->has('detail_type'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('detail_type') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="description">Description</label>
                            {!! Form::text('description', null, ['class' => 'form-control','id'=>'description']) !!}
                            @if ($errors->has('description'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="defaultTaxCode">Default Tax Code</label>
                            {!! Form::select('default_tax_code', $all_taxes, null, ['class' => 'form-control', 'id' => 'defaultTaxCode']) !!}
                            @if ($errors->has('default_tax_code'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('default_tax_code') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            <label for="balance">Balance <span class="text-danger">*</span></label>
                            {!! Form::number('balance', null, ['class' => 'form-control','id'=>'balance']) !!}
                            @if ($errors->has('balance'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('balance') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            <label for="as_of">As Of</label>
                            {!! Form::text('as_of', null, ['class' => 'form-control','id'=>'as_of']) !!}
                            @if ($errors->has('as_of'))
                                <span class="text-danger">
                                <strong>{{ $errors->first('as_of') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="PaymentAccountBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var val = $('#detailType').find(":selected").text();
        $('#name').val(val);
        $('#detailType').on('change',function(){
            var val = $(this).find(":selected").text();
            $('#name').val(val);
        });

        $('#accountType').change(function(){
            var name = $(this).find(":selected").text();
            $.ajax({
                method: "POST",
                url: "{{ route('ajax-get-account-type') }}",
                data: { name: name }
            }).done(function(data) {
                $("#detailType").empty();
                $.each(data.response, function(i, val) {
                    $("#detailType").append("<option value='"+i+"'>"+val+"</option>");
                });
                var val = $('#detailType').find(":selected").text();
                $('#name').val(val);
            });
        });
    });
</script>
