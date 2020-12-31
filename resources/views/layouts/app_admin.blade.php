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
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
    </script>
</body>
</html>
