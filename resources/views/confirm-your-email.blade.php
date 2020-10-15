@component('mail::message')
# Introduction

Try To Confirm Your Email

@component('mail::button', ['url' => route('confirm-email').'?token='.$user->confirm_token])
Confirm Your Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
