<x-mail::message>
#  🎉 Welcome to {{ config('app.name') }} - Let's Get Started.

Hello {{ $data->name }},

Welcome to {{ config('app.name') }}! Your account has been set up by our team,
and you can now access the platform using the details below:

    Email: {{ $data->email }}
    Temporary Password: {{ $data->password }}

🔐 Important: For your security, we strongly recommend changing your password after your first login.
You can do this from your account settings once you're logged in.

If you run into any issues or have questions,
feel free to reach out to our support team at support@platform.com.

Thanks for joining us!

—

<x-mail::button :url="route('login')" color="primary">
    Login to your account
</x-mail::button>

The {{ config('app.name') }} Team
</x-mail::message>
