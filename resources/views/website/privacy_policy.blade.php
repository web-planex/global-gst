@extends('website.layouts.app')
@section('content')
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
                        <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                        <li class="nav-item"><a class="nav-link" href="#cantacts">Contact Us</a></li>
                        <li class="nav-item">
                            <img src="{{url('website/img/flag.png')}}" alt="">
                            <div class="callUp-box">
                                <b>Call Us</b>: +91-281-2331006, +91-9724382401
                                <p>Mon - Fri 10:00 AM - 7:30 PM</p>
                            </div>
                        </li>
                    </ul>
                    <a href="#" class="about_btn white_btn wow fadeInLeft" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInLeft;">Login</a>
                    <a href="#" class="about_btn sign_in_btn wow fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">Register</a>
                </div>
            </div>
        </nav>
    </header>

    <section id="privacy_policy" class="s_pricing_area sec_pad pb-0">
        <div class="container custom_container">
            <div class="sec_title mb_70">
                <h2 class="f_p f_size_30 l_height50 f_600 t_color3">Privacy Policy</h2>
                <p class="f_400 f_size_18 l_height34">
                    <strong>Webplanex GST Invoices</strong> provides generate the GST ready invoices for sales orders and its report. “the Service” to merchants who are running small or medium business to power their businesses. This Privacy Policy describes how personal information is collected, used, and shared when you use the software.
                </p>
                <p class="f_400 f_size_18 l_height34">
                    <strong>How Do We Use Your Personal Information?</strong><br>
                    We use the personal information we collect from you and your customers in order to provide the Service and to operate the App. Additionally, we use this personal information to: Communicate with you; Optimize or improve the App; and Provide you with information or advertising relating to our products or services.
                </p>
                <p class="f_400 f_size_18 l_height34">
                    <strong>Sharing Your Personal Information</strong><br>
                    We do not share your personal information with anybody.  We store your personal information to provide described app services only.
                </p>
                <p class="f_400 f_size_18 l_height34">
                    <strong>Business Data and Privacy</strong><br>
                    The User alone is responsible for maintaining the confidentiality of his/her username, password and other sensitive information. He/She is responsible for all activities that occur in his/her user account and he/she agrees to inform us immediately of any unauthorized use of their user account by email or by calling us on any of the numbers listed on website. We are not responsible for any loss or damage to his/her or to any third party incurred as a result of any unauthorized access and/or use of his/her user account, or otherwise. We are neither responsible for any kind of data loss as performing necessary backups on data is solely the User’s responsibility. Webplanex is not responsible for any kind of data discrepancy or any type of loss occurred due to data discrepancy/software issue.
                </p>
                <p class="f_400 f_size_18 l_height34">
                    <strong>Changes</strong><br>
                    Changes We may update this privacy policy from time to time in order to reflect, for example, changes to our practices or for other operational, legal or regulatory reasons.
                </p>
                <p class="f_400 f_size_18 l_height34">
                    <strong>Contact Us</strong><br>
                    Contact US for more information about our privacy practices, if you have questions, or if you would like to make a complaint, please contact us by e-mail at contact email id on website.
                </p>
            </div>
        </div>
    </section>
@endsection