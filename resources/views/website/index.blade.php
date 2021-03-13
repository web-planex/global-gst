@extends('website.layouts.app')
@section('content')
    <!-- Begin Home Banner -->
    <section id="home" class="agency_banner_area bg_color agency_banner_area-pdng-btm">
        <img class="banner_shap" src="{{url('website/img/home4/banner_bg.png')}}" alt="">
        <div class="container custom_container">
            <div class="row">
                <div class="col-lg-5 d-flex align-items-center">
                    <div class="agency_content">
                        <h2 class="f_700 t_color3 mb_40 wow fadeInLeft" data-wow-delay="0.3s">GST Invoicing Solutions for Small and Medium businesses.</h2>
                        <p class="f_400 l_height28 wow fadeInLeft" data-wow-delay="0.4s">Create GST Invoices, Credit Notes, Estimates, Purchase Bills and useful Reports for GSTR-1, GSTR-2 and GSTR-3B returns.</p>
                        <div class="action_btn d-flex align-items-center mt_60">
                            @auth
                            <a href="{{url('/dashboard')}}" class="btn_hover agency_banner_btn wow fadeInLeft" data-wow-delay="0.5s">Dashboard</a>
                            @else
                            <a href="{{url('/register')}}" class="btn_hover agency_banner_btn wow fadeInLeft" data-wow-delay="0.5s" onclick="gtag_report_conversion_signup({{url('/register')}})">Join Now</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 text-right">
                    <img class="protype_img wow fadeInRight" data-wow-delay="0.3s" src="{{url('website/img/home4/banner_img.png')}}" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- End Home Banner -->

    <!-- Begin Customers -->
    <section class="container sec_pad">
        <div class="sec_title text-center">
            <h2 class="f_p f_size_30 l_height50 f_600 t_color3">Some of our Prestigious Customers</h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="partner_logo border-0">
                    <div class="p_logo_item wow fadeInLeft" data-wow-delay="0.2s">
                        <a href="javascript:void(0);"><img src="{{url('website/img/home3/mtr-logo.jpg')}}" alt=""></a>
                    </div>
                    <div class="p_logo_item wow fadeInLeft" data-wow-delay="0.3s">
                        <a href="javascript:void(0);"><img src="{{url('website/img/home3/sri-sri-logo.jpg')}}" alt=""></a>
                    </div>
                    <div class="p_logo_item wow fadeInLeft" data-wow-delay="0.4s">
                        <a href="javascript:void(0);"><img src="{{url('website/img/home3/2407-logo.jpg')}}" alt=""></a>
                    </div>
                    <div class="p_logo_item wow fadeInLeft" data-wow-delay="0.5s">
                        <a href="javascript:void(0);"><img src="{{url('website/img/home3/snitch-logo.jpg')}}" alt=""></a>
                    </div>
                    <div class="p_logo_item wow fadeInLeft" data-wow-delay="0.6s">
                        <a href="javascript:void(0);"><img src="{{url('website/img/home3/the-june-shop-logo.jpg')}}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Customers -->

    <!-- Begin Features -->
    <section id="features" class="agency_featured_area bg_color">
        <div class="container">
            <h2 class="f_size_30 f_600 t_color3 l_height40 text-center wow fadeInUp" data-wow-delay="0.3s">Features</h2>
            <div class="features_info">
                <img class="dot_img" src="{{url('website/img/home4/dot.png')}}" alt="">
                <div class="row agency_featured_item flex-row-reverse">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInRight" data-wow-delay="0.4s">
                            <img class="img-fluid" src="{{url('website/img/home4/work1.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pr_70 pl_70 wow fadeInLeft" data-wow-delay="0.6s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon01.png')}}" alt="">
                            <h3>GST Ready Invoices</h3>
                            <p>Generate nice, clear and professional GST ready Invoices. Set your own branding like Company Logo, Authorised signatory, Company address, Support number and Terms note.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item agency_featured_item_two">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInLeft" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work2.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pl_100 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon02.png')}}" alt="">
                            <h3>Invoice Templates</h3>
                            <p>Clear and Professional invoice template. You can always change the invoice template according to your requirements.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item flex-row-reverse agency_featured_item_img-three">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInRight" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work3.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pr_70 pl_70 wow fadeInLeft" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon3.png')}}" alt="">
                            <h3>Manage Products/Services and HSN</h3>
                            <p>Add your existing Products/Services with parameters like title, Sale price, SKU code, HSN code etc. You can also do bulk upload of your products into the system.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item agency_featured_item_three">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInLeft" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work4.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pl_100 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon4.png')}}" alt="">
                            <h3>Generate Estimates / Quotations</h3>
                            <p>Create your Estimates and email it to your Customers. Convert your estimates into the Sales GST Invoice with a simple click.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item flex-row-reverse agency_featured_item_img-three">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInRight" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work5.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pr_70 pl_70 wow fadeInLeft" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon5.png')}}" alt="">
                            <h3>Manage Suppliers / Customers</h3>
                            <p>Put onboard your customers as well as the suppliers and use them while creating Quotation, Sales GST Invoices, Purchase Bills etc...</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item agency_featured_item_three">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInLeft" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work6.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pl_100 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon6.png')}}" alt="">
                            <h3>Purchases Bills and Expenses</h3>
                            <p>Manage your business’s regular expenses and Purchase Bills. Purchase Bill is important in GSTR-2 return.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item flex-row-reverse">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInRight" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work7.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pr_70 pl_70 wow fadeInLeft" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon7.png')}}" alt="">
                            <h3>Credit Notes</h3>
                            <p>Generate and issue credit notes to your B2B customers. The software will generate automated Credit Note upon GST Invoice cancellation.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item agency_featured_item_three">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInLeft" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work8.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pl_100 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon8.png')}}" alt="">
                            <h3>Manage Multiple Companies</h3>
                            <p>Do you have multiple companies? Do not worry! with a single application, you can create GST Invoices for all your companies merely by using single account access.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item flex-row-reverse agency_featured_item_nine">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInRight" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work9.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pr_70 pl_70 wow fadeInLeft" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon9.png')}}" alt="">
                            <h3>Customer Emails and Templates</h3>
                            <p>Send your Estimates, GST Invoices and Credit Notes through email to your customers. Personalize your email templates for each email action.</p>
                        </div>
                    </div>
                </div>
                <div class="row agency_featured_item agency_featured_item_ten">
                    <div class="col-lg-6">
                        <div class="agency_featured_img text-right wow fadeInLeft" data-wow-delay="0.3s">
                            <img class="img-fluid" src="{{url('website/img/home4/work10.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="agency_featured_content pl_100 wow fadeInRight" data-wow-delay="0.5s">
                            <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                            <img class="number" src="{{url('website/img/home4/icon10.png')}}" alt="">
                            <h3>Useful Reports</h3>
                            <p>GST filling is made very simple and easy with the available sales and purchase reports.</p>
                        </div>
                    </div>
                </div>
                <div class="dot-box-pattern dot middle_dot"><span class="dot1"></span><span class="dot2"></span></div>
            </div>
        </div>
    </section>
    <!-- End Features -->

    <!-- Begin Pricing -->
    <section id="pricing" class="s_pricing_area sec_pad">
        <div class="container custom_container">
            <div class="sec_title text-center mb_70">
                <h2 class="f_p f_size_30 l_height50 f_600 t_color3">Pricing</h2>
                <p class="f_400 f_size_18 l_height34">A cost effective GST Invoicing Solutions for Small and Medium businesses. </p>
            </div>
            <div class="row mb_30">
                <div class="col-lg-4 col-sm-6">
                    <div class="s_pricing-item">
                        <img class="shape_img" src="{{url('website/img/saas/price_line1.png')}}" alt="">
                        <h5 class="f_p f_600 f_size_20 t_color mb-0 mt_40">STARTUP</h5>
                        <div class="price f_size_40 f_p f_700">Free <br><sub class="f_400 f_size_16"> &nbsp;</sub></div>
                        <ul class="list-unstyled mt_30">
                            <li>100 GST Invoices Per Month</li>
                            <li>Number Of GSTIN-1</li>
                            <li>Email Support</li>
                        </ul>
                        <a href="#" class="price_btn btn_hover mt_30">Choose This Plan</a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="s_pricing-item">
                        <img class="shape_img" src="{{url('website/img/saas/price_line2.png')}}" alt="">
                        <div class="tag_label">Popular</div>
                        <h5 class="f_p f_600 f_size_20 t_color mb-0 mt_40">MEDIUM</h5>
                        <div class="price f_size_40 f_p f_700">Free For 90 <sub class="f_400 f_size_16"> days.</sub></div>
                        <ul class="list-unstyled mt_30">
                            <li>600 GST Invoices Per Month</li>
                            <li>Number Of GSTIN-2</li>
                            <li>Call Support</li>
                        </ul>
                        <a href="#" class="price_btn btn_hover mt_30">Choose This Plan</a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="s_pricing-item">
                        <img class="shape_img" src="{{url('website/img/saas/price_line3.png')}}" alt="">
                        <h5 class="f_p f_600 f_size_20 t_color mb-0 mt_40">ADVANCED</h5>
                        <div class="price f_size_40 f_p f_700">Free For 90 <sub class="f_400 f_size_16"> days.</sub></div>
                        <ul class="list-unstyled mt_30">
                            <li>2400 GST Invoices Per Month</li>
                            <li>Number Of GSTIN-5</li>
                            <li>Call Support</li>
                        </ul>
                        <a href="#" class="price_btn btn_hover mt_30">Choose This Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Pricing -->

    <!-- Begin Contact Us -->
    <section id="contacts" class="contact_info_area sec_pad bg_color">
        <div class="container">
            <div class="sec_title text-center mb_70">
                <h2 class="f_p f_size_30 l_height50 f_600 t_color3">Contact Us</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 pr-0">
                    <div class="contact_info_item">
                        <h6 class="f_p f_size_20 t_color3 f_500 mb_20">Office Address</h6>
                        <p class="f_400 f_size_15">311-C, Iscon Mall, 150 ft. Ring Road, Rajkot 360005, Gujarat, India.</p>
                        <p class="f_400 f_size_15">Hours: Mon - Fri 10:00 AM - 7:30 PM</p>
                    </div>
                    <div class="contact_info_item">
                        <h6 class="f_p f_size_20 t_color3 f_500 mb_20">Contact Info</h6>
                        <p class="f_400 f_size_15"><span class="f_500 t_color3">Phone:</span> <a href="tel:3024437488">+91-281-2331006</a></p>
                        <p class="f_400 f_size_15"><span class="f_500 t_color3">Mobile:</span> <a href="tel:3024437488">+91-9724382401</a></p>
                        <p class="f_400 f_size_15"><span class="f_500 t_color3">Email:</span> <a href="mailto:info@webplanex.com"> info@webplanex.com</a></p>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="contact_form">
                        {!! Form::open(['url' => url('send_contact_mail'), 'class' => 'contact_form_box','files'=>true,'id'=>'contactForm']) !!}
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group text_box">
                                        {!! Form::text('name', null, ['placeholder' => 'Your Name','id'=>'name']) !!}
                                        @if ($errors->has('name'))
                                            <span class="error">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group text_box">
                                        {!! Form::text('email', null, ['placeholder' => 'Your Email','id'=>'email']) !!}
                                        @if ($errors->has('email'))
                                            <span class="text-danger">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group text_box">
                                        {!! Form::text('subject', null, ['placeholder' => 'Your Subject','id'=>'subject']) !!}
                                        @if ($errors->has('subject'))
                                            <span class="text-danger">
                                                {{ $errors->first('subject') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group text_box">
                                        {!! Form::textarea('message', null, ['cols'=>'30','rows'=>'10', 'placeholder' => 'Enter Your Message . . .','id'=>'message']) !!}
                                        @if ($errors->has('message'))
                                            <span class="text-danger">
                                                {{ $errors->first('message') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn_three">Send Message</button>
                        {!! Form::close() !!}
                        <div id="success">Your message succesfully sent!</div>
                        <div id="error">Opps! There is something wrong. Please try again</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Us -->

    <!-- Begin Testimonial -->
    <!-- <section class="agency_testimonial_area bg_color sec_pad">
        <div class="container">
            <h2 class="f_size_30 f_600 t_color3 l_height40 text-center mb_60">We've heard things like</h2>
            <div class="agency_testimonial_info">
                <div class="testimonial_slider owl-carousel">
                    <div class="testimonial_item text-center left">
                        <div class="author_img"><img src="img/home4/author_img.png" alt=""></div>
                        <div class="author_description">
                            <h4 class="f_500 t_color3 f_size_18">Lurch Schpellchek</h4>
                            <h6>UI/UX designer</h6>
                        </div>
                        <p>What a load of rubbish bits and bobs pear shaped owt to do with me bubble and squeak jolly good morish tinkety tonk old fruit, car boot my good sir buggered plastered cheeky David, haggle young delinquent say so I said bite your arm off easy peasy. Skive off it's all gone to pot buggered.</p>
                    </div>
                    <div class="testimonial_item text-center center">
                        <div class="author_img"><img src="img/home4/author_img.png" alt=""></div>
                        <div class="author_description">
                            <h4 class="f_500 t_color3 f_size_18">Lurch Schpellchek</h4>
                            <h6>UI/UX designer</h6>
                        </div>
                        <p>What a load of rubbish bits and bobs pear shaped owt to do with me bubble and squeak jolly good morish tinkety tonk old fruit, car boot my good sir buggered plastered cheeky David, haggle young delinquent say so I said bite your arm off easy peasy. Skive off it's all gone to pot buggered.</p>
                    </div>
                    <div class="testimonial_item text-center right">
                        <div class="author_img"><img src="img/home4/author_img.png" alt=""></div>
                        <div class="author_description">
                            <h4 class="f_500 t_color3 f_size_18">Lurch Schpellchek</h4>
                            <h6>UI/UX designer</h6>
                        </div>
                        <p>What a load of rubbish bits and bobs pear shaped owt to do with me bubble and squeak jolly good morish tinkety tonk old fruit, car boot my good sir buggered plastered cheeky David, haggle young delinquent say so I said bite your arm off easy peasy. Skive off it's all gone to pot buggered.</p>
                    </div>
                    <div class="testimonial_item text-center">
                        <div class="author_img"><img src="img/home4/author_img.png" alt=""></div>
                        <div class="author_description">
                            <h4 class="f_500 t_color3 f_size_18">Lurch Schpellchek</h4>
                            <h6>UI/UX designer</h6>
                        </div>
                        <p>What a load of rubbish bits and bobs pear shaped owt to do with me bubble and squeak jolly good morish tinkety tonk old fruit, car boot my good sir buggered plastered cheeky David, haggle young delinquent say so I said bite your arm off easy peasy. Skive off it's all gone to pot buggered.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <section class="action_area_three sec_pad">
        <div class="curved"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="action_content text-center">
                        <h2 class="f_600 f_size_30 l_height45 mb_40">Ready to enjoy GST Invoices and expenses?</h2>
{{--                        <a href="#" class="about_btn mr-2 wow fadeInLeft" data-wow-delay="0.3s">Just GST Invoices</a>--}}
                        @auth
                        <a href="{{url('/dashboard')}}" class="about_btn wow fadeInRight" data-wow-delay="0.4s">Dashboard</a>
                        @else
                        <a href="{{url('/register')}}" class="about_btn wow fadeInRight" data-wow-delay="0.4s" onclick="gtag_report_conversion_signup({{url('/register')}})">Create your FREE account!</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
endsection