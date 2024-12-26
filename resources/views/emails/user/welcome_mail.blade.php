<x-mail::message>
# Welcome to {{ config('app.name') }}! Your Account Details

Hello {{ $data->name }},

Welcome to System X! We're excited to have you on board. Below are your login details:
    Email: {{ $data->email }}
    Password: {{ $data->password }}

Please log in to your account and change your password as soon as possible for security purposes.

If you have any questions or need assistance, feel free to reach out to our support team.

<x-mail::button :url="route('login')" color="primary">
    Login to your account
</x-mail::button>

Best Regards,<br>
{{ config('app.name') }}
</x-mail::message>
