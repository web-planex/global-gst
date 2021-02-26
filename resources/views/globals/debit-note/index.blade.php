@extends('layouts.app')
@section('content')
<style>
@media (max-width: 767px) {
    .table-responsive .dropdown-menu {
        overflow-x: auto;
    }
}
@media (min-width: 768px) {
    .table-responsive {
        overflow-x: visible;
    }
}
</style>
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Debit Note</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{route('debit-notes.create')}}" class="float-right">
                <button type="button" class="btn btn-info  d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <x-emailverification/>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            {!! Form::open(['url' => route('debit-notes.index'),'method'=>'get', 'class' => 'form-horizontal top-heading-form-box','files'=>true,'id'=>'SearchForm']) !!}
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'search', 'placeholder'=>'Search']) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::text('start_date', $start_date, ['class' => 'form-control','id'=>'start_date', 'placeholder'=>'Start date']) !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::text('end_date', $end_date, ['class' => 'form-control','id'=>'end_date', 'placeholder'=>'End date']) !!}
                        </div>
                    </div>

                    {{--<div class="col-md-2">
                        <div class="form-group">
                            {!! Form::select('status', [''=>'All Status']+\App\Models\Globals\Invoice::$invoice_status, isset($status)&&!empty($status)?$status:null, ['class' => 'form-control amounts-are-select2', 'id' => 'status']) !!}
                        </div>
                    </div>--}}

                    <div class="col-md-2">
                       <button type="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                       <a href="{{route('debit-notes.index')}}"><button type="button" class="btn btn-danger">Clear</button></a>
                    </div>
                </div>
            {!! Form::close() !!}

            {!! Form::open(['url' => route('debit-note-multiple-pdf'),'class' => 'form-horizontal','files'=>true,'id'=>'MultiplePdfForm']) !!}
            <div class="card">
                <div class="results-top" style="margin: 0 5px;">
                    <div class="float-left">
                        <div class="action-on mt-1">
                            <div>Action on </div>
                            <div><span id="selected_unfulfilled_count">0</span> Selected</div>
                        </div>
                    </div>
                    <div class="col-left">
                        <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="tooltipmodel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title font-bold-500 font-16 text-primary" id="tooltipmodel">Bulk Debit Note Download</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <label><input type="radio" name="download_type" value="1" checked="checked"> Download selected debit notes as single PDF</label>
                                            <label><input type="radio" name="download_type" value="2"> Download selected debit notes as individual PDF</label>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Generate Debit Notes Zip"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" id="download_multi_debit_note" class="btn btn-success waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Debit Notes Zip"><i class="fas fa-cloud-download-alt"></i></a>
                    </div>
                    <div class="pull-right dropleft custom-column-display">
                        <a href="javascript:;" class="text-dark" data-toggle="dropdown" title="Settings" aria-expanded="false">
                            <i class="fas fa-cog" style="font-size:20px;margin-top: 8px;"></i>
                        </a>
                        <div class="dropdown-menu chk-column-container dropdownMenu-box">
                            @if(!empty($custom_column))
                                <div class="dropdown-item">Columns</div>
                                <div class="dropdown-divider"></div>
                                @foreach($custom_column as $column)
                                    <div class="dropdown-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" value="col_{{strtolower(str_replace(' ','_',$column))}}" class="custom-control-input custom-column-checkbox" id="{{$column}}" checked>
                                            <label class="custom-control-label" for="{{$column}}">{{$column}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3" id="invoice_data">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="all_checked">
                                            <label class="custom-control-label" for="all_checked"></label>
                                        </div>
                                    </th>
                                    <th class="col_debit_note_no">Debit Note No.</th>
                                    <th class="col_customer">Customer</th>
                                    <th class="col_debit_note_date">Debit Note Date</th>
                                    <th class="col_due_date">Due Date</th>
                                    <th class="col_total">Total</th>
                                    <th class="col_notes">Note</th>
                                    <th class="col_status">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if($debit_note->count()>0)
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($debit_note as $list)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="all_debit_note_check[]" value="{{$list['id']}}" class="custom-control-input all_debit_note_check" id="check_{{$list['id']}}">
                                                <label class="custom-control-label" for="check_{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                        <td class="col_debit_note_no">{{$list['debit_note_number']}}</td>
                                        <td class="col_customer">{{$list['Payee']['name']}}</td>
                                        <td class="col_debit_note_date">{{date('d F Y', strtotime($list['debit_note_date']))}}</td>
                                        <td class="col_due_date">{{date('d F Y', strtotime($list['due_date']))}}</td>
                                        <td class="col_total">{{$list['total']}}</td>
                                        <td class="col_notes">
                                            <input type="hidden" id="Notes_{{$list['id']}}" value="{{$list['notes']}}">
                                            @if(!empty($list['notes']) && strlen($list['notes']) > 25)
                                                <a href="javascript:void(0)" class="text-themecolor text-left" onclick="show_note({{$list['id']}})">
                                                    {{ substr($list['notes'], 0 ,25) }}...
                                                </a>
                                            @else
                                                {{ $list['notes'] }}
                                            @endif
                                        </td>
                                        <td class="col_status">
                                            @if($list['status']==1)
                                                <label class="label label-warning">Pending</label>
                                            @elseif($list['status']==2)
                                                <label class="label label-success">Paid</label>
                                            @elseif($list['status']==3)
                                                <label class="label label-danger">Void</label>
                                            @else
                                                <label class="label label-warning">Refund</label>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" onclick="javascript:window.location.href='{{route('debit-notes.edit',['debit_note'=>$list['id']])}}'" class="btn btn-secondary">Edit</button>
                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('debit-notes.edit',['debit_note'=>$list['id']])}}">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_debit_note_records({{$list['id']}})">Delete</a>
                                                    <a class="dropdown-item" target="_blank" href="{{route('download-debit-note-pdf',['id'=>$list['id'],'output'=>'print'])}}">Print</a>
                                                    @if(!empty($list['files']) && file_exists($list['files']))
                                                        <a class="dropdown-item" href="{{url($list['files'])}}" download>Download Receipt</a>
                                                    @endif
                                                    <!--<a class="dropdown-item" href="{{route('send-invoice-mail', ['id' => $list['id']])}}">Send Debit Note Email</a>-->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                            @else
                                <tfoot>
                                    <tr>
                                        <td colspan="9" align="center">No records found!</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-6 pl-4">
                        Showing {{$debit_note->firstItem()}} to {{$debit_note->lastItem()}} of {{$debit_note->total()}} entries
                    </div>
                    <div class="col-md-6 pr-4">
                        @include('inc.pagination', ['paginator' => $debit_note])
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

<script type='text/javascript'>
    $(document).ready(function(){
        $(document).on('click', '.custom-column-display .dropdown-menu', function (e) {
            e.stopPropagation();
        });
        var checkbox_cookie_arr = [];
        var exp_cookie_json_str = getCookie('debitNoteColumns');

        if(exp_cookie_json_str != '') {
            checkbox_cookie_arr = JSON.parse(exp_cookie_json_str);
        }
        $('.chk-column-container').find('input:checkbox').each(function(){
            if(exp_cookie_json_str.includes($(this).val())) {
                $(this).prop("checked", false);
                $('.'+$(this).val()).addClass('hide');
            }
        });
        $('.custom-column-checkbox').on('click',function(){
            var class_name = $(this).val();
            if(!$(this).is(':checked')) {
                checkbox_cookie_arr.push(class_name);
            } else {
                var index = checkbox_cookie_arr.indexOf(class_name);
                if (index > -1) {
                    checkbox_cookie_arr.splice(index, 1);
                }
            }
            var json_str = JSON.stringify(checkbox_cookie_arr);
            $('.'+class_name).toggleClass('hide');
            setCookie("debitNoteColumns", json_str, 365);
        });

        $("#all_checked").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
            $('#selected_unfulfilled_count').html($('[name="all_debit_note_check[]"]:checked').length);
        });

        $('.all_debit_note_check').click(function(){
            if($('[name="all_debit_note_check[]"]:checked').length == {{$debit_note->count()}}){
                $('#all_checked').prop('checked',true);
            }else{
                $('#all_checked').prop('checked',false);
            }
            $('#selected_unfulfilled_count').html($('[name="all_debit_note_check[]"]:checked').length);
        });

        $('#download_multi_debit_note').click(function(){
        if($('[name="all_debit_note_check[]"]:checked').length == 0){
            Swal.fire("Select at least one debit note");
            return false;
        }
            $('#myModal').modal('show');
            return false;
        });
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function delete_debit_note_records(debit_note_id){
        Swal.fire({
            title: 'Do you want to delete this?',
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#01c0c8",
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = '{{url('debit-notes/delete')}}/'+debit_note_id;
            }
        })
    }

    function show_note(debit_id) {
        Swal.fire({
            title: 'Note',
            text: $('#Notes_'+debit_id).val()
        });
    }
</script>
@endsection