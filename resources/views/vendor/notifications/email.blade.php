@component('mail::message')
{{-- Greeting --}}

<?php
    $get_user_id = explode('verify/',$actionUrl);
    $get_id = explode('/',$get_user_id[1]);
    $user = \App\User::where('id',$get_id[0])->first();
?>

@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello ') {{$user['name'].'!'}}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset



<span class="break-all" style="color: #1575bf;"><strong style="color: #000000;">Or verify using link  :</strong> [{{ $displayableActionUrl }}]({{ $actionUrl }})</span>

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Salutation --}}
{{--@if (! empty($salutation))--}}
{{--{{ $salutation }}--}}
{{--@else--}}
{{--@lang('Regards'),<br>--}}
{{--{{ config('app.name') }}--}}
{{--@endif--}}

{{-- Subcopy --}}
{{--@isset($actionText)--}}
{{--@slot('subcopy')--}}
{{--@lang(--}}
{{--    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".--}}
{{--    'into your web browser:',--}}
{{--    [--}}
{{--        'actionText' => $actionText,--}}
{{--    ]--}}
{{--) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>--}}
{{--@endslot--}}
{{--@endisset--}}
@endcomponent
