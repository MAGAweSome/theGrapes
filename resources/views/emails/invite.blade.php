<x-mail::message>
# You've been invited!

You have been invited to register for The Grapes admin dashboard.

<x-mail::button :url="$inviteUrl">
Create your account
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
