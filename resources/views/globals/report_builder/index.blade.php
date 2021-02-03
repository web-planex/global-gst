@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
    </div>
    <div class="content">
        @include('inc.message2')
        <div class="row">
            <div class="col-lg-12">
                <div class="box card">
                    {!! Form::open(['url' => url($url),'method'=>'get', 'class' => 'form-horizontal','files'=>true,'id'=>'SearchForm']) !!}
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::text('start_date', $start_date, ['class' => 'form-control','id'=>'start_date', 'placeholder'=>'Start date']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::text('end_date', $end_date, ['class' => 'form-control','id'=>'end_date', 'placeholder'=>'End date']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" name="submit" value="submit" class="btn btn-primary mr-2"><i class="ti-search"></i></button>
                                <a href="{{url($url)}}"><button type="button" class="btn btn-danger mr-2">Clear</button></a>
                                <button type="submit" name="export" value="export" class="btn btn-info mr-2">Export Report</button>
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="row">
                        <div class="col-md-12">
                            <table id="totaltax" class="table table-hover">
                                <tr>
                                    <th style="width: 50%">TOTAL CGST</th>
                                    <td>@if($cgst != '-') <span style="font-family: Arial">₹</span> @endif {{$cgst}}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL SGST</th>
                                    <td>@if($sgst != '-') <span style="font-family: Arial">₹</span> @endif {{$sgst}}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL IGST</th>
                                    <td>@if($igst != '-') <span style="font-family: Arial">₹</span> @endif {{$igst}}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL CESS</th>
                                    <td>@if($cess != '-') <span style="font-family: Arial">₹</span> @endif {{$cess}}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL {{$sub_menu}} AMOUNT</th>
                                    <td>@if($total_amount != '-') <span style="font-family: Arial">₹</span> @endif {{$total_amount}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
