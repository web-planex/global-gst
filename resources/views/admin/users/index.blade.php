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
        .swal2-popup #swal2-content {
            text-align: justify;
        }
    </style>
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            <div class="alert alert-info hide" id="payment_msg"></div>
            {!! Form::open(['url' => url('admin/users'),'method'=>'get', 'class' => 'form-horizontal','files'=>true,'id'=>'SearchForm']) !!}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'search', 'placeholder'=>'Search']) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                    <a href="{{url('admin/users')}}"><button type="button" class="btn btn-danger">Clear</button></a>
                </div>
            </div>
            {!! Form::close() !!}

            <div class="card">
                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3" id="bill_data">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Total Company</th>
                                <th>Status</th>
{{--                                <th>Action</th>--}}
                            </tr>
                            </thead>
                            @if($users->count()>0)
                                <tbody>
                                @php $i=1; @endphp
                                @foreach($users as $list)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$list['name']}}</td>
                                        <td>{{$list['email']}}</td>
                                        <td>{{$list['mobile']}}</td>
                                        <td>
                                            @php $total_company = \App\Models\Globals\CompanySettings::where('user_id',$list['id'])->count(); @endphp
                                            {{$total_company}}
                                        </td>
                                        <td class="col_status">
                                            @if($list['status']==1)
                                                <label class="label label-success">Active</label>
                                            @else
                                                <label class="label label-danger">Inactive</label>
                                            @endif
                                        </td>
{{--                                        <td>--}}
{{--                                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete User">--}}
{{--                                                <a class="dropdown-item" href="javascript:void(0)" onclick="delete_users({{$list['id']}})"><i class="fa fa-trash text-danger"></i></a>--}}
{{--                                            </span>--}}
{{--                                        </td>--}}
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                                </tbody>
                            @else
                                <tfoot>
                                <tr>
                                    <td colspan="6" align="center">No records found!</td>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-md-6 pl-4">
                        Showing {{$users->firstItem()}} to {{$users->lastItem()}} of {{$users->total()}} entries
                    </div>
                    <div class="col-md-6 pr-4">
                        @include('inc.pagination', ['paginator' => $users])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript'>
        function delete_users(user_id){
            Swal.fire({
                title: 'Do you want to delete this?',
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#01c0c8",
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                window.location.href = '{{url("admin/users/delete")}}/'+user_id;
            }
        })
        }
    </script>
@endsection
