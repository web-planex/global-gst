@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Expense</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a href="expense/create" class="btn sync-orders-btn waves-effect waves-light btn-warning">New Expense</a>
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
                                    <th>User</th>
                                    <th>Payee</th>
                                    <th>Payment Account Id</th>
                                    <th>Payment Date</th>
                                    <th>Payment Method</th>
                                    <th>Ref No</th>
                                    <th>Category</th>
                                    <th>Item</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($expense->count()>0)
                                @foreach($expense as $list)
                                    <tr>
                                        <td>{{$list['id']}}</td>
                                        <td>{{$list['payee_id']}}</td>
                                        <td>{{$list['payment_account_id']}}</td>
                                        <td>{{$list['payment_date']}}</td>
                                        <td>{{$list['payment_method']}}</td>
                                        <td>{{$list['ref_no']}}</td>
                                        <td>{{$list['expense_category_id']}}</td>
                                        <td>{{$list['item_id']}}</td>
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