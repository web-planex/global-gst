<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{url('website/img/favicon.png')}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Webplanex: Free GST Invoice Software</title>
    @if(Route::current()->getName() == 'home-page')
    <meta name="description" content="GST Invoicing Software: Create and Send GST Ready invoices to your customers. Generate useful reports for GSTR returns.">
    <meta name="keywords" content="GST Invoice Software, GST Billing Software, Software for GST, GST Invoice India, GST Accounting Software, GST Billing Software Free, GST Return, Government Compliance GST Invoice Software">
    <meta name="classification" content="GST Invoice Software, Sales, Purchase and Bills management Software">
    @endif
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
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <script src="{{ asset('website/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jquery.validate.js') }}"></script>
    <style>
        .err-msg{color: #dc3545!important}
    </style>
    @if(Route::current()->getName() == 'home-page')
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '433834297851282');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=433834297851282&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-M9R6B6FV83"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-M9R6B6FV83');
    </script>
    <!-- End Global site tag (gtag.js) - Google Analytics -->
    
    <!-- Google Search Rating Code -->
    <script type=application/ld+json>
        {"@context": "http://www.schema.org" , "@type" : "product" , "brand"
        : "Webplanex Infotech PVT LTD." , "name" : "GST Invoice by Webplanex" , "image"
        : "https://gst.webplanex.com/website/img/logo.png" , "url"
        : "https://gst.webplanex.com/" , "offers" : {"@type": "Offer" , "availability"
        : "http://schema.org/InStock" , "price" : "0.00" , "priceCurrency" : "INR" }, "aggregateRating" : { "@type"
        : "AggregateRating" , "ratingValue" : "5.0" , "reviewCount" : "154" }, "description"
        : " GST Invoicing Software: Create and Send GST Ready invoices to your customers. Generate useful reports for GSTR returns "
        }
    </script>
    <!-- End Google Search Rating Code -->
    @endif

    <!-- Global site tag (gtag.js) - Google Ads: 1042132981 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-1042132981"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-1042132981');
    </script>

    <!--------------- Phone Snippet --------------->
    <script>
        gtag('config', 'AW-1042132981/Ntw5CIrtw_sBEPXf9vAD', {
            'phone_conversion_number': '09724382401'
        });
    </script>

    <script>
        window.addEventListener('load',function(){
            jQuery('[href="https://gst.webplanex.com/register"]:contains(Join Now)').click(function(){
                gtag('event', 'conversion', {'send_to': 'AW-1042132981/bzN1CI6874kCEPXf9vAD'});
            })
            jQuery('[href="https://gst.webplanex.com/register"]:contains(Register)').click(function(){
                gtag('event', 'conversion', {'send_to': 'AW-1042132981/WAA8CNq374kCEPXf9vAD'});
            })
        })
    </script>

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
                                <b>Call Us</b>: <a href="tel:+912812331006" style="color: #000000;"> +91-281-2331006</a>, <a href="tel:+919724382401" style="color: #000000;">+91-9724382401</a>
                                <p>Mon - Fri 10:00 AM - 7:30 PM</p>
                            </div>
                        </li>
                    </ul>
                    @auth
                    <a href="{{url('/dashboard')}}" class="about_btn sign_in_btn wow fadeInLeft" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">Dashboard</a>
                    @else
                    <a href="{{url('/login')}}" class="about_btn white_btn wow fadeInLeft" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">Login</a>
                    <a href="{{url('/register')}}" class="about_btn sign_in_btn wow fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;" onclick="gtag_report_conversion_signup({{url('/register')}})">Register</a>
                    @endauth
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
                            <a href="{{url('/')}}" class="f-logo"><img src="{{url('website/img/logo.png')}}" srcset="{{url('website/img/logo2x.png 2x')}}" alt=""></a>
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
                            <p>© <script>document.write(new Date().getFullYear());</script> <a href="https://www.webplanex.com/" target="_blank" title="AWARD WINNING WEB AND MOBILE APPS. DESIGN &amp; DEVELOPMENT">Webplanex Infotech PVT LTD</a>, All Rights Reserved.</p>
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
            $('#contact-btn').html('<i class="fa fa-spinner fa-spin mr-2"></i> Message Sending');
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
                        $('#contact-btn').html('Send Message');
                    }else{
                        $('#error').hide();
                        $('#success').hide().html('Your message successfully sent!').fadeIn('slow').delay(5000).hide(1);
                        $('#contact-btn').html('Send Message');
                    }
                    gtag_report_conversion('');
                }
            });
        }
    </script>

    <!---------------------FOR CONTACT--------------------->
    <!-- Event snippet for Contact Form conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
    <script>
        function gtag_report_conversion(url) {
            var callback = function () {
                if (typeof(url) != 'undefined') {
                    // window.location = url;
                }
            };
            gtag('event', 'conversion', {
                'send_to': 'AW-1042132981/C-rLCJWSo_YBEPXf9vAD',
                'event_callback': callback
            });
            return false;
        }
    </script>
@endif

<!---------------------FOR SIGNUP--------------------->
<!-- Event snippet for Sign-up conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
    function gtag_report_conversion_signup(url) {
        var callback = function () {
            if (typeof(url) != 'undefined') {
                window.location = url;
            }
        };
        gtag('event', 'conversion', {
            'send_to': 'AW-1042132981/WlZqCK_rw_sBEPXf9vAD',
            'event_callback': callback
        });
        return false;
    }
</script>

<!---------------------FOR CHAT--------------------->
<!-- Event snippet for Contact on Chat conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
    function gtag_report_conversion_chat(url) {
        url = "{{url('/')}}";
        var callback = function () {
            if (typeof(url) != 'undefined') {
                // window.location = url;
            }
        };
        gtag('event', 'conversion', {
            'send_to': 'AW-1042132981/sQJDCMrU1PsBEPXf9vAD',
            'event_callback': callback
        });
        return false;
    }
</script>
</body>
</html>