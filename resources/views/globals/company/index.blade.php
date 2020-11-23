@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Companies</h4>
        </div>
        <div class="col-sm-6 text-right">
                <a href="{{url('companies/create')}}" class="float-right">
                <button type="button" class="btn btn-info d-none d-lg-block"><i class="fa fa-plus-circle"></i> Create New</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 page-min-height">
            @include('inc.message')
            <div class="card">
                <div class="gstinvoice-table-data">
                    <div class="table-responsive data-table-gst-box pb-3">
                        <table id="myTable0" class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>GSTIN</th>
                                <th>Company Email</th>
                                <th>Company Phone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($companies->count()>0)
                                <?php $i=1;?>
                                @foreach($companies as $list)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$list['company_name']}}</td>
                                        <td>{{$list['gstin']}}</td>
                                        <td>{{$list['company_email']}}</td>
                                        <td>{{$list['company_phone']}}</td>
                                        <td>
                                            <div class="btn-group table-icons-box" role="group" aria-label="Basic example">
                                                <a href="{{url('companies/'.$list['id'].'/edit')}}" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Update"><i class="fas fa-edit"></i></a>
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
                                @include('inc.pagination', ['paginator' => $companies])
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
                title: 'Are you want to delete this?',
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#01c0c8",
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                window.location.href= '{{url('companies/delete')}}/'+report_id;
            }
        })
        }
    </script>

@endsection
