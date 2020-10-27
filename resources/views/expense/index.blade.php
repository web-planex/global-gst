@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="expense/create">
                    <button type="button" class="btn btn-info float-right mb-2">New Expense</button>
                </a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Expense</div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th>User</th>
                                <th>Payee</th>
                                <th>Payment Account Id</th>
                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Ref No</th>
                                <th>Category</th>
                                <th>Item</th>
                                <th>Action</th>
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
