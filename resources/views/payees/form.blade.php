<div class="form-group row">
    <label for="type" class="col-md-2 col-form-label">Type</label>
    <div class="col-md-5">
        <select name="type" class="form-control">
            @foreach(\App\Models\Globals\Payees::$type as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        @if ($errors->has('type'))
            <span class="text-danger">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
        @endif
    </div>
</div>

<!----------------Suppliers Form---------------->
<div class="row" id="suppliers">
    <div class="col-md-6">
        <div class="form-group row">
            <label for="type" class="col-md-3 col-form-label">First Name</label>
            <div class="col-md-9">
                <input type="text" name="first_name" class="form-control">
                @if ($errors->has('first_name'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <label for="type" class="col-md-3 col-form-label">Last Name</label>
            <div class="col-md-9">
                <input type="text" name="last_name" class="form-control">
                @if ($errors->has('last_name'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
