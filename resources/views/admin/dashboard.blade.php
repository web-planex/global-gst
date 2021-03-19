@extends('admin.layout.app')
@section('content')
    <div class="shopi-container">
        <div class="row page-titles">
            <div class="col-md-6 align-self-center">
                <h4 class="text-themecolor">Dashboard</h4>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-lg-3 col-md-6">
                <a href="{{url('admin/users')}}" class="text-dark">
                    <div class="card mr-1">
                        <div class="card-body">
                            <div class="d-flex no-block">
                                <div class="round align-self-center round-lg round-primary"><i class="fa fa-users"></i></div>
                                <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0">{{$total_users}}</h3>
                                    <h5 class="text-muted m-b-0">Users</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection