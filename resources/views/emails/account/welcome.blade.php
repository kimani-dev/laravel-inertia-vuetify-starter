<x-mail::message>
# Welcome to {{ config('app.name') }},

Hi {{ $user->name }},

Just wanted to drop you a quick line to officially welcome you to {{ config('app.name') }}!

We're thrilled to have you on board and excited for you to explore all the possibilities that {{ config('app.name') }} has to offer.

@if ($password)
Your account has been created and you can log in using the following credentials:
<br>
-Email: {{ $user->email }}
<br>
 -Password: {{ $password }}
@endif
    
If you have any questions or need assistance, don't hesitate to reach out to our friendly support team at support@gmail.com.

We're here to help you make the most of your {{ config('app.name') }} experience!

Happy exploring!

<x-mail::button :url="route('login')">
    Login to your account
</x-mail::button>

Best regards,

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
