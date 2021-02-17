<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
    <title>Gst App</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/dist/css/pages/login-register-lock.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/style.min.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--Validation Jquery File-->
    <script src="{{ asset('assets/dist/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jquery.validate.js') }}"></script>
    <style>
        .error{color: #ff0000;}
    </style>
</head>
<body>
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">GST App</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper" class="login-register login-sidebar" style="background-image:url('{{url('assets/images/login-register.jpg')}}');">
    <div class="login-box card">
        <div class="card-body" style="overflow-y: scroll;">
            @yield('content')
        </div>
    </div>
</section>

<script src="{{ asset('assets/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        $('#to-login').on("click", function() {
            $("#loginform").slideDown();
            $("#recoverform").fadeOut();
        });

        $('#forgot_password_btn').click(function(){
            var email  = $('#recover_email').val();
            if(email == ""){
                $('#recover_email_msg').html('<strong>The email field is required</strong>');
                $('#recover_email_msg').removeClass('hide');
                $('#recover_email_msg').addClass('show');
            }else{
                $('#recover_email_msg').removeClass('show');
                $('#recover_email_msg').addClass('hide');

                $.ajax({
                    url: '{{url('/forgot_password')}}',
                    type: 'POST',
                    data: {'recover_email':email,'_token' : $('meta[name=csrf-token]').attr('content') },
                    success: function (result) {
                        if(result == 0){
                            $('#recover_email_msg').html('<strong>Invalid email! Please try again.</strong>');
                            $('#recover_email_msg').removeClass('hide');
                            $('#recover_email_msg').addClass('show');

                            $('#email_link').removeClass('show');
                            $('#email_link').addClass('hide');
                        }else{
                            $('#recover_email_msg').removeClass('show');
                            $('#recover_email_msg').addClass('hide');

                            $('#email_link').html('<strong>We were sent you link for reset password to your mail. Please check your mail.</strong>');
                            $('#email_link').removeClass('hide');
                            $('#email_link').addClass('show');

                            $('#recover_email').val('');
                        }
                    }
                });
            }
        });

        $(document).ready(function() {
            $("#loginform").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                },
                messages: {
                    email: {
                        required: "The email field is required",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "The password field is required",
                        minlength: "Your password must be at least 8 characters long"
                    },
                }
            });

            $("#adminloginform").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                },
                messages: {
                    email: {
                        required: "The email field is required",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "The password field is required",
                        minlength: "Your password must be at least 8 characters long"
                    },
                }
            });

            $("#recoverform").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    email: {
                        required: "The email field is required",
                        email: "Please enter a valid email address"
                    },
                }
            });

            $("#RegisterForm").validate({
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    company_name: "required",
                    phone_number: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: "The name field is required",
                    email: {
                        required: "The email field is required",
                        email: "Please enter a valid email address"
                    },
                    company_name: "The company name field is required",
                    phone_number: {
                        required: "The phone number field is required",
                        minlength: "Your phone number must be at least 10 digits long",
                        maxlength: "Your phone number maximum 10 digits only"
                    },
                    password: {
                        required: "The password field is required",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    password_confirmation: {
                        required: "The confirm password field is required",
                        minlength: "Your password must be at least 8 characters long",
                        equalTo: "Please enter the same password as above"
                    }
                }
            });
        });
    </script>
</body>
</html>