<div class="modal fade bs-example-modal-sm" id="ExpenseTypeModal" tabindex="-1" role="dialog" aria-labelledby="ExpenseTypeModalLabel">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ExpenseTypeModalLabel">Add Expense Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="ExpenseTypeForm" action="" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="form-group mb-12 col-md-12">
                            <label for="name">Name<span class="text-danger">*</span></label>
                            {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
                            @error('name')
                                <span class="text-danger">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-12 col-md-12">
                            <label for="description">Description</label>
                            {!! Form::textarea('description', null, ['class' => 'form-control','id'=>'description','placeholder'=>'Max 500 Characters','maxlength'=>'500','cols'=>'5','style'=>'height:85px']) !!}
                        </div>
                        <div class="form-group col-md-12 mb-0">
                            <button type="submit" id="ExpenseTypeBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
