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
                                <th>Name</th>
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
                                        <td>{{$list['type']}}</td>
                                        <td>Action</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
