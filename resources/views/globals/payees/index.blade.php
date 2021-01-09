@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Payees / Vendors</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{url('payees/create')}}" class="float-right">
                <button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            {!! Form::open(['url' => url('payees'),'method'=>'get', 'class' => 'form-horizontal','files'=>true,'id'=>'SearchForm']) !!}
                <div class="row">
                           <div class="col-md-3">
                                <div class="form-group">
                                        {!! Form::text('search', isset($search)&&!empty($search)?$search:null, ['class' => 'form-control','id'=>'sf_name', 'placeholder'=>'Search']) !!}
                                </div>
                            </div>
                    
                            <div class="col-md-3">
                                <div class="form-group">
                                        {!! Form::select('type',[''=>'Select Type']+ \App\Models\Globals\Payees::$type, $select_user_type, ['class' => 'form-control', 'id'=>'type_selection']) !!}
                                </div>
                            </div>

                           <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                                    <a href="{{url('payees')}}"><button type="button" class="btn btn-danger">Clear</button></a>
                            </div>
                </div>                
             {!! Form::close() !!}
            <div class="card">
                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 30%">Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($payees->count()>0)
                                <?php $i=1;?>
                                @foreach($payees as $list)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$list['name']}}</td>
                                        @if($list['type'] == 1)
                                        <td>{{$list['Suppliers']['email']}}</td>
                                        <td>{{$list['Suppliers']['mobile']}}</td>
                                        @elseif($list['type'] == 2)
                                        <td>{{$list['Employees']['email']}}</td>
                                        <td>{{$list['Employees']['mobile']}}</td>
                                        @else
                                        <td>{{$list['Customers']['email']}}</td>
                                        <td>{{$list['Customers']['mobile']}}</td>
                                        @endif
                                        <td>@if($list['type']==1) Suppliers @elseif($list['type']==2) Employees @else Customers @endif</td>
                                        <td>
                                            <div class="btn-group table-icons-box" role="group" aria-label="Basic example">
                                                <a href="{{url('/payees/edit/'.$list['id'])}}" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Update"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:;" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="delete_report_records({{$list['id']}});"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="fixed-table-pagination">
                            <div class="float-right pagination mr-3">
                                @include('inc.pagination', ['paginator' => $payees])
                            </div>
                        </div>
                    </div>
                </div>
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
                    window.location.href= '{{url('payees/delete')}}/'+report_id;
                }
            })
        }
    </script>

@endsection
