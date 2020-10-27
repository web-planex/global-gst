@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="payees/create">
                    <button type="button" class="btn btn-info float-right mb-2">New Payee</button>
                </a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Payee</div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Type Id</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if($payees->count()>0)
                                    <?php $i=1;?>
                                    @foreach($payees as $list)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$list['name']}}</td>
                                            <td>{{$list['type']}}</td>
                                            <td>{{$list['type_id']}}</td>
                                            <td>Action</td>
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
@endsection
