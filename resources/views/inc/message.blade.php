@if (Session::has('message_404'))
<div class="alert alert-danger">{{ Session::get('message_404') }}</div>
@endif

@if (Session::has('error-message'))
<div class="alert alert-danger">{{ Session::get('error-message') }}</div>
@php session()->forget('error-message'); @endphp
@endif

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger">        
    <ul style="list-style: none;">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@php session()->forget('errors'); @endphp
@endif



@if (session()->has('success_message'))
<div class="alert alert-success">
    {{ session()->get('success_message') }}
    @php session()->forget('success_message'); @endphp
</div>
@endif

@if (session()->has('error_message'))
<div class="alert alert-danger">
    {{ session()->get('error_message') }}
</div>
@endif

