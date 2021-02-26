@extends('layouts.app')
@section('content')
<div class="row page-titles">
    <div class="col-sm-12 align-self-center">
        <h4 class="text-themecolor">Download Estimate Zip files</h4>
    </div>
</div>

<x-emailverification/>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body page-min-height">
                @include('inc.message')
                <div class="row">
                    <div class="col-md-12">
                        <p>We got your request and your PDF can be downloaded from this page once process to generate selected PDF is completed. It may possible that your request comes in the queue if some other user requested bulk expenses before you. So keep checking this page and refresh after Some time to check the status of your request. Zip file will be available for single day, After it will be removed.</p>
                        <p><strong class="font-bold">Please wait for a while for a new request.</strong></p>
                    </div>
                    <div class="col-md-12 text-left mb-3">
                        <button id="refresh_page"  class="btn btn-success waves-effect waves-light" >Refresh</button>
                    </div>
                </div>
                @php date_default_timezone_set('Asia/Kolkata');
                $current_time = date('Y-m-d H:i:s');
                @endphp
                <div class="report-builder-table">
                    <div class="table-responsive">

                        <div class="tablesaw-table">
                            <table class="tablesaw no-wrap table-hover table" data-tablesaw-mode="stack">
                                <thead>
                                    <tr>
                                        <th>Date and Time</th>
                                        <th>Status</th>
                                        <th>Type</th> {{-- //Credit Note change --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($job_status == "Pending" || $job_status == "Processing")
                                    <tr>
                                        <td>{{$current_time}}</td>
                                        <td>
                                            @if($job_status == "Pending")
                                            Request Submitted
                                            @endif
                                            @if($job_status == "Processing")
                                            In Process
                                            @endif
                                        </td>
                                        <td>-</td>
                                        <td>-</td> {{-- //Credit Note change --}}
                                    </tr>
                                    @endif
                                    @if(count($zip_files) > 0)
                                    @foreach($zip_files as $zip_file)
                                    <tr>
                                        @php
                                        date_default_timezone_set('Asia/Kolkata');
                                        $zip_file_date = new DateTime($zip_file->created_at);
                                        $zip_file_date->setTimezone(new DateTimeZone('Asia/Kolkata'));
                                        $zip_file_date = $zip_file_date->format('d-m-Y H:i:s');
                                        @endphp

                                        <td>{{$zip_file_date}}</td>
                                        <td>Done</td>
                                        {{-- //Credit Note change --}}
                                        <td>
                                            @if($zip_file->zip_type == 1)
                                                Expense
                                            @elseif($zip_file->zip_type == 2)
                                                Sales Invoice
                                            @elseif($zip_file->zip_type == 3)
                                                CreditNote
                                            @else
                                                Estimate
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('/') }}/upload/{{$user_id}}/estimate/{{$zip_file->zip_name}}" class="btn waves-effect waves-light btn-success" target="_blank"><i class="fas fa-download"></i> Download</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        @if($job_status != "Pending" && $job_status != "Processing")
                                        <tr><td colspan="3">No Files Found </td></tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#refresh_page').on('click', function () {
            window.location.reload();
        });
    });
</script>
@endsection