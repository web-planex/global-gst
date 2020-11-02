<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gst App</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
     <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.css') }}" />
      <style type="text/css">
      #multiselect_left > option {
          padding: 0.5px!important;
      }
      #multiselect_right > option {
          padding: 0.5px!important;
      }
      .gst-app-dropdown-menu {
        list-style: none;
         margin: 0;
          padding: 15px 3.2rem 0 3.2rem;
              text-align: right;
      }
      .gst-app-dropdown-menu li {
          display: inline-block;
          background: #fff;
          box-shadow: 0 0 0 1px rgba(63,63,68,0.05), 0 1px 3px 0 rgba(63,63,68,0.15);
          padding: 8px 15px;
          border-radius: 3px;
      }
      .gst-app-dropdown-menu li.open {
          background: -webkit-linear-gradient(#6371c7, #5563c1);
          background: -o-linear-gradient(#6371c7, #5563c1);
          background: linear-gradient(#6371c7, #5563c1);

      }
      .gst-app-dropdown-menu li.open > a.nav-link {
        color: #fff;
      }
      .gst-app-dropdown-menu li .dropdown-menu {
        min-width: 100%;
        border-radius: 0 0 3px 3px;
        border: none;
        padding: 10px 15px;
      }
      .gst-app-dropdown-menu li .dropdown-menu a {
        margin: 5px 0;
      }
      </style>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <div id="app">
      <ul class="gst-app-dropdown-menu">
        @guest
{{--          <li class="nav-item">--}}
{{--              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--          </li>--}}
      @else
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }} <span class="caret"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('admin-logout') }}" method="POST" style="display: none;">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </form>
              </div>
          </li>
      @endguest
    </ul>
     <p>&nbsp;</p>
        <div class="container-fluid">
        <div class="white-box">
        @auth
          <nav class="navbar navbar-default">
              <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item @if(Route::currentRouteName() == 'home' ) active @endif"><a href="{{ url('home/')}}">HOME</a></li>
                        <li class="nav-item @if(Route::currentRouteName() == 'check-invoice-numbers' ) active @endif"><a href="{{ url('check-invoice-numbers/') }}">Check Invoice Numbers</a></li>
                        <li class="nav-item @if(Route::currentRouteName() == 'check-null-orders' ) active @endif"><a href="{{ url('check-null-orders/') }}">Check Null Orders</a></li>
                        <li class="nav-item @if(Route::currentRouteName() == 'update-gst-hsn' ) active @endif"><a href="{{ url('update-gst-hsn/') }}">Update GST% For Collections</a></li>
                        <li class="nav-item @if(Route::currentRouteName() == 'store-credits' ) active @endif"><a href="{{ url('store-credits/') }}">Store Credits</a></li>
                        <li class="nav-item @if(Route::currentRouteName() == 'extra-charge' ) active @endif"><a href="{{ url('extra-charge/') }}">Extra Charge</a></li>
                        <li class="nav-item @if(Route::currentRouteName() == 'custom-plan' ) active @endif"><a href="{{ url('custom-plan/') }}">Custom Plan</a></li>
                    </ul>
               </div>
           </nav>
       @endauth
                @yield('content')
            </div>
            <p>&nbsp;</p>
            <hr/>
            <p class="text-center">&copy; 2019 WebPlanex. All Rights Reserved.</p>
    </div>
   </div>
    <script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
   $('.sync_from_order_date').datepicker({
          todayHighlight: true ,
          format: 'dd-mm-yyyy',
          autoclose: true
       });
  tinymce.init({
        menubar: false,
        selector: 'textarea.description',
        toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  });
</script>
</body>
</html>
