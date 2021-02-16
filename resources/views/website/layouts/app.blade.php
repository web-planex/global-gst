<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{url('website/img/favicon.png')}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GST Invoices</title>
    <link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/bootstrap-selector/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/themify-icon/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/elagent/style.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/animation/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/owl-carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/magnify-pop/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/nice-select/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('website/vendors/scroll/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/responsive.css') }}">
    <script src="{{ asset('website/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jquery.validate.js') }}"></script>
    <style>
        .err-msg{color: #dc3545!important}
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="104">
<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="animation-preloader">
            <div class="spinner"></div>
            <div class="txt-loading">
                <span data-text-preloader="G" class="letters-loading">G</span>
                <span data-text-preloader="S" class="letters-loading">S</span>
                <span data-text-preloader="T" class="letters-loading">T</span>
                <span data-text-preloader="I" class="letters-loading">I</span>
                <span data-text-preloader="N" class="letters-loading">N</span>
                <span data-text-preloader="V" class="letters-loading">V</span>
                <span data-text-preloader="O" class="letters-loading">O</span>
                <span data-text-preloader="I" class="letters-loading">I</span>
                <span data-text-preloader="C" class="letters-loading">C</span>
                <span data-text-preloader="E" class="letters-loading">E</span>
                <span data-text-preloader="S" class="letters-loading">S</span>
            </div>
            <p class="text-center">Loading</p>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="body_wrapper">
    <header class="header_area">
        <nav class="navbar navbar-expand-lg menu_one menu_four">
            <div class="container custom_container p0">
                <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('website/img/logo.png')}}"  alt="logo"></a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu_toggle">
                        <span class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                        <span class="hamburger-cross">
                            <span></span>
                            <span></span>
                        </span>
                    </span>
                </button>
                <div class="collapse navbar-collapse top-header-section" id="navbarSupportedContent">
                    <ul class="navbar-nav menu pl_120 mr-auto ml-auto">
                        @if($menu=='Home')
                            <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                            <li class="nav-item"><a class="nav-link" href="#contacts">Contact Us</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link active" href="{{url('/')}}/#home">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{url('/')}}/#features">Features</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{url('/')}}/#pricing">Pricing</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{url('/')}}/#contacts">Contact Us</a></li>
                        @endif

                        <li class="nav-item">
                            <img src="{{url('website/img/flag.png')}}" alt="">
                            <div class="callUp-box">
                                <b>Call Us</b>: +91-281-2331006, +91-9724382401
                                <p>Mon - Fri 10:00 AM - 7:30 PM</p>
                            </div>
                        </li>
                    </ul>
                    <a href="{{url('/login')}}" class="about_btn white_btn wow fadeInLeft" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">Login</a>
                    <a href="{{url('/register')}}" class="about_btn sign_in_btn wow fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">Register</a>
                </div>
            </div>
        </nav>
    </header>

@yield('content')

    <footer class="footer_area footer_area_four f_bg footer-default">
        <div class="footer_top">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-12">
                        <div class="f_widget company_widget">
                            <a href="#" class="f-logo"><img src="{{url('website/img/logo.png')}}" srcset="{{url('website/img/logo2x.png 2x')}}" alt=""></a>
                            <div class="f_widget about-widget pl_40">
                                <ul class="list-unstyled f_list">
                                    @if($menu=='Home')
                                        <li><a href="#home">Home</a></li>
                                        <li><a href="#features">Features</a></li>
                                        <li><a href="#pricing">Pricing</a></li>
                                        <li><a href="#contacts">Contact Us</a></li>
                                    @else
                                        <li><a href="{{url('/')}}/#home">Home</a></li>
                                        <li><a href="{{url('/')}}/#features">Features</a></li>
                                        <li><a href="{{url('/')}}/#pricing">Pricing</a></li>
                                        <li><a href="{{url('/')}}/#contacts">Contact Us</a></li>
                                    @endif
                                </ul>
                                <ol class="list-unstyled f_list">
                                    <li class="mt-0"><a href="{{url('/terms-and-conditions')}}">Terms & Conditions</a></li>
                                    <li class="mt-0"><a href="{{url('/privacy-policy')}}">Privacy Policy</a></li>
                                </ol>
                            </div>
                            <div class="f_social_icon marginNone mb-3">
                                <a target="_blank" href="https://www.facebook.com/WebPlanexPVTLTD" class="ti-facebook" title="Facebook"></a>
                                <a target="_blank" href="https://twitter.com/webplanex" class="ti-twitter-alt" title="Twitter"></a>
                                <a target="_blank" href="https://www.linkedin.com/company/webplanex" class="ti-linkedin" title="LinkedIn"></a>
                            </div>
                            <p>© <script>document.write(new Date().getFullYear());</script> <a href="https://www.webplanex.com/" target="_blank" title="AWARD WINNING WEB AND MOBILE APPS. DESIGN &amp; DEVELOPMENT">WebPlanex</a>, All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{--<script src="{{ asset('website/js/jquery-3.2.1.min.js') }}"></script>--}}
<script src="{{ asset('website/js/propper.js') }}"></script>
<script src="{{ asset('website/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('website/vendors/bootstrap-selector/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('website/vendors/wow/wow.min.js') }}"></script>
<script src="{{ asset('website/vendors/sckroller/jquery.parallax-scroll.js') }}"></script>
<script src="{{ asset('website/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('website/vendors/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('website/vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('website/vendors/isotope/isotope-min.js') }}"></script>
<script src="{{ asset('website/vendors/magnify-pop/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('website/js/plugins.js') }}"></script>
<script src="{{ asset('website/vendors/scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('website/js/main.js') }}"></script>
<script id="sbinit" src="{{ asset('supportboard/js/main.js') }}"></script>

@if($menu =='Home')
    <script>
        if ($(".navbar-nav > li > a, footer ul li a").length > 0) {
            $(".navbar-nav > li > a, footer ul li a").on("click", function (e) {
                e.preventDefault();
                $("html, body").animate({scrollTop: $($(this).attr("href")).offset().top + "px"}, 1600, "swing");
            });
        }
        history.pushState("", document.title, window.location.pathname);


        //Contact Mail Form
        $(document).ready(function() {
            $("#contactForm").validate({
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    subject: "required",
                    message: "required"
                },
                messages: {
                    name: "The name field is required",
                    email:{
                        required: 'The email field is required',
                        email: 'Please enter a valid email address'
                    },
                    subject: "The subject field is required",
                    message: "The message field is required"
                },
                normalizer: function(value) {
                    return $.trim(value);
                },
                submitHandler:function(){
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var subject = $('#subject').val();
                    var message = $('#message').val();

                    SendMail(name, email, subject, message);
                }
            });
        });

        function SendMail(name, email, subject, message) {
            $.ajax({
                url: '{{url('send_contact_mail')}}',
                type: 'POST',
                data: {'name':name,'email':email,'subject':subject,'message':message,'_token': "{{ csrf_token() }}",},
                success: function (result) {
                    $('#name').val('');
                    $('#email').val('');
                    $('#subject').val('');
                    $('#message').val('');
                    if(result == 0){
                        $('#success').hide();
                        $('#error').hide().html('Opps! There is something wrong. Please try again').fadeIn('slow').delay(5000).hide(1);
                    }else{
                        $('#error').hide();
                        $('#success').hide().html('Your message succesfully sent!').fadeIn('slow').delay(5000).hide(1);
                    }
                }
            });
        }
    </script>
@endif
</body>
</html>