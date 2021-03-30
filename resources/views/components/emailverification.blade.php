@if(empty(\Illuminate\Support\Facades\Auth::user()->email_verified_at))
    <div class="card">
        <div class="card-body">
            <div class="alert alert-warning" role="alert">
                Before proceeding, please check your email for a verification link.
            </div>
            If you did not receive the email,
            <a href="https://gst.webplanex.com/resend-verification-email">
                <button type="button" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>.
            </a>
        </div>
    </div>
@endif