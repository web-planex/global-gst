@extends('layouts.app')
@section('content')
    <div class="row page-titles">
        <div class="col-sm-6 align-self-center">
            <h4 class="text-themecolor"><i class="fa fa-envelope"></i>&nbsp;Email Configurations</h4>
        </div>
    </div>

    <x-emailverification/>

    <div class="content">
        @include('inc.message2')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-3 mb-0">
                            <div class="col-md-12">
                                <h4>Below are the steps to configure for <strong>Gmail SMTP Server</strong></h4>
                                <ul>
                                    <li>Login to your Gmail account.</li>
                                    <li>Go to <a target="_blank" href="https://www.google.com/settings/security/lesssecureapps">https://www.google.com/settings/security/lesssecureapps</a> and Turn On this feature.</li>
                                    <li>Go to <a target="_blank" href="https://accounts.google.com/DisplayUnlockCaptcha">https://accounts.google.com/DisplayUnlockCaptcha</a> and click Continue.</li>
                                    <li>After adding all the below fields, click on the "Test Configuration" button. And when it displays the "Test Success" message then you will receive an email on your SMTP email address and your all emails will be sent through your SMTP server.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row mt-3 mb-0">
                            <div class="col-md-12">
                                {!! Form::open(['url' => url('configuration'), 'class' => 'form-horizontal','files'=>true,'id'=>'Configurationform']) !!}
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><strong>Common Configurations</strong></h4><br>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="from_email">From Email</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="from_email" name="from_email" value="{{ isset($emailConfiguration->from_email) ? $emailConfiguration->from_email : "" }}">
                                                    @if($errors->has('from_email'))
                                                        <span class="text-danger">{{ $errors->first('from_email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="from_name">From Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="from_name" name="from_name" value="{{ isset($emailConfiguration->from_name) ? $emailConfiguration->from_name : "" }}">
                                                    @if($errors->has('from_name'))
                                                        <span class="text-danger">{{ $errors->first('from_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <h4><strong> SMTP Configurations</strong></h4><br>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="smtp_host">SMTP Host</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="{{ isset($emailConfiguration->smtp_host) ? $emailConfiguration->smtp_host : "" }}">
                                                    @if($errors->has('smtp_host'))
                                                        <span class="text-danger">{{ $errors->first('smtp_host') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="smtp_username">SMTP Username</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="smtp_username" name="smtp_username" value="{{ (isset($emailConfiguration->smtp_username)  ) ? $emailConfiguration->smtp_username : "" }}">
                                                    @if($errors->has('smtp_username'))
                                                        <span class="text-danger">{{ $errors->first('smtp_username') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="smtp_password">SMTP Password</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="password" id="smtp_password" class="form-control" name="smtp_password" value="{{ isset($emailConfiguration->smtp_password) ? $emailConfiguration->smtp_password: "" }}">
                                                    @if($errors->has('smtp_password'))
                                                        <span class="text-danger">{{ $errors->first('smtp_password') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="smtp_port">SMTP Port</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="smtp_port" name="smtp_port" value="{{ isset($emailConfiguration->smtp_port) ? $emailConfiguration->smtp_port : "" }}">
                                                    @if($errors->has('smtp_port'))
                                                        <span class="text-danger">{{ $errors->first('smtp_port') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label>SMTP Security</label><br>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="smtp_security" id="smtp_encryption_none" value="none" class="custom-control-input" {{ (isset($emailConfiguration->smtp_security) && $emailConfiguration->smtp_security =="none") ? "checked" : ""  }}><br>
                                                        <label class="custom-control-label" for="smtp_encryption_none">None</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="smtp_security" value="tls" id="smtp_encryption_tls" class="custom-control-input" {{ (isset($emailConfiguration->smtp_security) && $emailConfiguration->smtp_security =="tls") ? "checked" : ""  }}><br>
                                                        <label class="custom-control-label" for="smtp_encryption_tls">TLS</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="smtp_security" value="ssl" id="smtp_encryption_ssl" class="custom-control-input" {{ (isset($emailConfiguration->smtp_security) &&  $emailConfiguration->smtp_security =="ssl") ? "checked" : ""  }}><br>
                                                        <label class="custom-control-label" for="smtp_encryption_ssl">SSL</label>
                                                    </div>
                                                    @if($errors->has('smtp_security'))
                                                        <span class="text-danger">{{ $errors->first('smtp_security') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="subject"></label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <a href="javascript:testConfiguration()" id="test_configuration" class="btn btn-success">Test Configuration</a>
                                                    <label for="subject" id="test-configuration" class="text-success ml-5"></label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-3 cb-label-right">
                                                    <label for="subject"></label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <button type="submit" class="btn btn-primary">Save Configuration</button>
                                                    <a href="{{url('reset_configuration')}}" class="btn btn-secondary">Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testConfiguration(){
            $('#test-configuration').html("");
            let smtp_host = $("input[name='smtp_host']").val();
            let smtp_port = $("input[name='smtp_port']").val();
            let from_email = $("input[name='from_email']").val();
            let from_name = $("input[name='from_name']").val();
            let smtp_security = $("input[name='smtp_security']:checked").val();
            let smtp_username = $("input[name='smtp_username']").val();
            let smtp_password = $("input[name='smtp_password']").val();
            $("#test_configuration").html('Checking...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '{{ url('test_configuration') }}',
                type: "POST",
                data: {
                    smtp_host: smtp_host,
                    smtp_port: smtp_port,
                    from_email: from_email,
                    from_name: from_name,
                    smtp_security: smtp_security,
                    smtp_username: smtp_username,
                    smtp_password: smtp_password
                },
                success: function(response) {
                    $("#test-configuration").removeClass("text-danger");
                    $("#test-configuration").addClass("text-success");
                    $('#test-configuration').html(response.message);
                    $("#test_configuration").html('Test Configuration');
                },
                error: function(xhr){
                    $("#test-configuration").removeClass("text-success");
                    $("#test-configuration").addClass("text-danger");
                    $('#test-configuration').html("Test Fail, Please check your setting.");
                    $("#test_configuration").html('Test Configuration');
                }
            });
        }
    </script>
@endsection