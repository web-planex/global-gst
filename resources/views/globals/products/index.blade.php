@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Products / Services</h4>
        </div>
        <div class="col-sm-6 text-right">
                <a href="{{url('products/create')}}" class="float-right">
                <button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            <div class="alert alert-info hide" id="import_msg"></div>
            {!! Form::open(['url' => url('products'),'method'=>'get', 'class' => 'form-horizontal','files'=>true,'id'=>'SearchForm']) !!}
                <div class="row">
                   <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'sf_name', 'placeholder'=>'Search']) !!}
                        </div>
                    </div>
                   <div class="col-md-6">
                        <button type="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                        <a href="{{url('products')}}"><button type="button" class="btn btn-danger mr-2">Clear</button></a>
                        <a href="{{url('products/export_product')}}"><button type="button" class="btn btn-info mr-2">Export Product</button></a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ImportProduct">Import Product</button>
                    </div>
                    <div class="col-md-3">
                        <div class="pull-right dropleft custom-column-display">
                            <a href="javascript:;" class="btn" data-toggle="dropdown" title="Settings" aria-expanded="false">
                                <i class="fas fa-cog" style="font-size:20px;margin-top: 8px;"></i>
                            </a>
                            <div class="dropdown-menu chk-column-container">
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
                </div>
            {!! Form::close() !!}
            <div class="card">
                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3" id="pro_list">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col_title">Title</th>
                                    <th class="col_hsn_code">HSN / SAC Code</th>
                                    <th class="col_sku">SKU</th>
                                    <th class="col_purchase_price">Purchase Price</th>
                                    <th class="col_sale_price">Sale Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if($products->count()>0)
                                <tbody>
                                <?php $i=1;?>
                                @foreach($products as $list)
                                    <tr>
                                        <td class="col_title">{{$list['title']}}</td>
                                        <td class="col_hsn_code">{{$list['hsn_code']}}</td>
                                        <td class="col_sku">{{$list['sku']}}</td>
                                        <td class="col_purchase_price">{{$list['price']}}</td>
                                        <td class="col_sale_price">{{$list['sale_price']}}</td>
                                        <td>
                                            <div class="btn-group table-icons-box" role="group" aria-label="Basic example">
                                                <a href="{{url('products/'.$list['id'].'/edit')}}" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Update"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:;" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="delete_report_records({{$list['id']}});"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                @endforeach
                            </tbody>
                            @else
                                <tfoot>
                                    <tr>
                                        <td colspan="7" align="center">No records found!</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                        <div class="fixed-table-pagination">
                            <div class="float-right pagination mr-3">
                                @include('inc.pagination', ['paginator' => $products])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ImportProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="ImportForm" method="post" class="form-horizontal" enctype="multipart/form-data" style="margin-bottom: 12px">
                    <div class="modal-header">
                        <h4 class="modal-title font-bold-500 font-16 text-primary" id="tooltipmodel">Import Product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="import_csv" class="mb-2 border-0" id="import">
                        <label id="import-error" class="error err-msg hide" for="import"></label>
                    </div>
                    <div class="modal-footer" style="display: block">
                        <a href="{{url('sample_import_product/sample.csv')}}" download><button type="button" class="btn btn-info float-left"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Download Sample CSV File</button></a>
                        <button type="submit" class="btn btn-primary float-right" id="import_btn"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp;Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type='text/javascript'>
        function delete_report_records(report_id){
            Swal.fire({
                title: 'Do you want to delete this?',
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#01c0c8",
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                window.location.href= '{{url('products/delete')}}/'+report_id;
            }
        })
        }

        $(document).ready(function (e) {
            $(document).on('click', '.custom-column-display .dropdown-menu', function (e) {
                e.stopPropagation();
            });
            var checkbox_cookie_arr = [];
            var exp_cookie_json_str = getCookie('productColumns');

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
                setCookie("productColumns", json_str, 365);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#ImportForm').submit(function(e) {
                var element = $('#import').val();
                if(element == ""){
                    $('#import-error').html("The import file filed is required.");
                    $('#import-error').removeClass('hide');
                    return false;
                }else{
                    var fileExtension = ['csv'];
                    if ($.inArray($('#import').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        $('#import-error').html("Please select only CSV file.");
                        $('#import-error').removeClass('hide');
                        return false;
                    }
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type:'POST',
                        url: "{{ url('products/import')}}",
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                           $('#import_msg').html('Product imported successfully.');
                           $('#import_msg').removeClass('hide');
                           $('#ImportProduct').modal('toggle');
                           $("#pro_list").load(location.href + " #pro_list");
                        }
                    });
                }
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
    </script>
@endsection
