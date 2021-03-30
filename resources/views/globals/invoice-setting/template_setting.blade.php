@extends('layouts.app')
@section('content')
    <style>
        .select-template-main .choose-template-list li a:before {
            background-image: url("{{url('assets/images/logo-light-icon-small.png')}}") !important;
        }
        li {cursor: pointer;}
    </style>
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor">Invoice Templates</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('inc.message')
            <div class="card">
                <div class="card-body">
                    <div class="select-template-main">
                        <div class="row clearfix">
                            <div class="col-md-5 col-lg-4">
                                <h1 class="template-heading">Colors</h1>
                                <ul class="color-listing">
                                    @foreach(\App\Models\Globals\CompanySettings::$invoice_color as $key => $val)
                                        <li onclick="SetInvoiceColor('{{$key}}')">
                                            <a class="@if($invoice_setting['color'] == $key) active @endif">
                                                <span class="template-color-circle template-color-{{$val}}">
                                                    @php $color_name = strtolower(str_replace(' ','-',$val)); @endphp
                                                    <img src="{{ url('assets/images/color-'.$color_name.'.png') }}" alt="{{$val}}" />
                                                </span>
                                                {{$val}} @if($invoice_setting['color'] == $key) <i class="ti-check"></i> @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="row custom-color-picker">
                                    <div class="col-md-12">
                                        <label>
                                            Custom Color
                                            @if(!in_array($invoice_setting['color'], array_keys(\App\Models\Globals\CompanySettings::$invoice_color)))
                                                &nbsp;<i class="ti-check"></i>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-8 col-xs-8">
                                        <div class="row">
                                        <input id="color-input" type="text" class="form-control jscolor {onFineChange:'setTextColor(this)'}" name="color" value="{{ $invoice_setting['color'] }}" />                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-4">
                                        <div class="row">
                                            <a id="btn_custom_color" onclick="SetInvoiceColor($('#color-input').val())" class="btn btn-default btn-block">Select</a>
                                        </div>
                                    </div>
                                </div>

                                <h1 class="template-heading tmp-head-dark">Templates</h1>

                                <ul class="choose-template-list">
                                    @foreach(\App\Models\Globals\CompanySettings::$template as $key2 => $val2)
                                        <li onclick="SetInvoiceView('{{$key2}}')">
                                            <a class="media-heading template-name @if($invoice_setting['pdf_template'] == $key2) active @endif">{{$val2}} @if($invoice_setting['pdf_template'] == $key2) <i class="ti-check"></i> @endif</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-7 col-lg-8 pdf-preview-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="template-heading pdf-preview-heading">Invoice Preview</h1>
                                    </div>
                                </div>
                                <div id="msg_loading" class="pdf-loading-msg" style="display: none;">Loading Preview
                                    <img src="{{url('images/ajax-load.gif')}}">
                                </div>
                                <div style="margin: 0px -10px;">
                                    <iframe id="invoice_iframe" src="{{url('upload/'.$user->id.'/company/invoice_template/sample_'.$invoice_setting['pdf_template'].'.pdf')}}" style="" width="100%" height="1000" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jscolor.min.js') }}"></script>
    <script type='text/javascript'>
        function setTextColor(picker) {
            $("#btn_custom_color").attr('href', '#');
        }
    </script>
    <script lang="javascript">
        $(function(){
            $('#invoice_iframe').on('load', function(){
                $('#msg_loading').hide();
                $('#invoice_iframe').show();
            });
        });

        function SetInvoiceColor(color) {
            $.ajax({
                url: "{{url('set_invoice_view')}}",
                type:'POST',
                data: {'color':color},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if(result == 1){
                        window.location.reload();
                    }else{
                        console.log(result);
                    }
                }
            });
        }

        function SetInvoiceView(view) {
            $.ajax({
                url: "{{url('set_invoice_view')}}",
                type:'POST',
                data: {'pdf_view':view},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if(result == 1){
                        window.location.reload();
                    }else{
                        console.log(result);
                    }
                }
            });
        }
    </script>
@endsection