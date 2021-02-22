<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
                <a href="{{route('home-page')}}" target="_blank">
                    <img src="{{url('assets/images/logo_2.png')}}" alt="" width="auto" height="50" style="max-height:50px;"/>
                </a>
            @endif
        </a>
    </td>
</tr>
