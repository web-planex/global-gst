@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">{{$menu}}</h4>
        </div>
    </div>

    <x-emailverification/>

    @include('inc.message2')
    <div class="row">
        <div class="col-lg-12">

            <div class="row mb-0">
                <!--COMPANY DETAILS SETTING-->
                <div class="col-lg-6">
                    <div class="card signature-image-bg">
                        <div class="card-header bg-primary">
                            <h4 class="m-b-0 text-white float-left">Standard Template</h4>
                            <h4 class="m-b-0 text-white text-right">
                                {!! Form::open(['url' => url('update-template'), 'class' => '','files'=>true]) !!}
                                    @csrf
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Sample_1_Modal">Preview</button>
                                    @if($invoice_setting['pdf_template']==1)
                                        <button type="button" class="btn btn-dark"><i class="fa fa-check"></i> Current Template</button>
                                    @else
                                        <input type="hidden" name="pdf_view" value="1">
                                        <button type="submit" class="btn btn-dark">Use This Template</button>
                                    @endif
                                {!! Form::close() !!}
                            </h4>
                        </div>
                        <div class="card-body">
                            <iframe src="{{url('assets/dist/sample_1.pdf')}}" height="400px" width="100%"></iframe>
                        </div>
                    </div>

                    <div id="Sample_1_Modal" class="modal fade bs-example-modal-lg" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Standard Template</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <iframe src="{{url('assets/dist/sample_1.pdf')}}" height="400px" width="100%"></iframe>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card signature-image-bg">
                        <div class="card-header bg-primary">
                            <h4 class="m-b-0 text-white float-left">Classic Template</h4>
                            <h4 class="m-b-0 text-white text-right">
                                {!! Form::open(['url' => url('update-template'), 'class' => '','files'=>true]) !!}
                                    @csrf
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Sample_2_Modal">Preview</button>
                                    @if($invoice_setting['pdf_template']==2)
                                        <button type="button" class="btn btn-dark"><i class="fa fa-check"></i> Current Template</button>
                                    @else
                                        <input type="hidden" name="pdf_view" value="2">
                                        <button type="submit" class="btn btn-dark">Use This Template</button>
                                    @endif
                                {!! Form::close() !!}
                            </h4>
                        </div>
                        <div class="card-body">
                            <iframe src="{{url('assets/dist/sample_2.pdf')}}" height="400px" width="100%"></iframe>
                        </div>
                    </div>

                    <div id="Sample_2_Modal" class="modal fade bs-example-modal-lg" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Classic Template</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <iframe src="{{url('assets/dist/sample_2.pdf')}}" height="400px" width="100%"></iframe>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
