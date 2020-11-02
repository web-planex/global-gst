@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Payees</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{url('payees/create')}}" class="btn sync-orders-btn waves-effect waves-light btn-warning">New Payees</a>
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
                                <th style="width: 30%">Name</th>
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
                                        <td>@if($list['type']==1) Suppliers @elseif($list['type']==2) Employees @else Customers @endif</td>
                                        <td>
                                            <div class="btn-group table-icons-box" role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Update Payee"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:;" class="btn btn-white px-0 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="Delete Payee" onclick="delete_report_records({{$list['id']}});"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
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
                    window.location.href= '{{url('payees/delete')}}/'+report_id;
                }
            })
        }
    </script>

@endsection
