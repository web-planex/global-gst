<div class="modal fade" id="PaymentTermsModal" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Payment Term</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="PaymentTermsForm" action="" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row" id="Customers">
                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="terms_name" class="col-md-12 col-form-label">Terms Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::text('terms_name', null, ['class' => 'form-control','id'=>'terms_name','placeholder'=>'Net 0']) !!}
                                    @error('terms_name')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3 row">
                                <label for="terms_days" class="col-md-12 col-form-label">Number of Days <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    {!! Form::number('terms_days', null, ['class' => 'form-control','id'=>'terms_days','min'=>'1']) !!}
                                    @error('terms_days')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="CustomerBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
