<x-mail::message>
# Email Change Request

Hi {{ $user->name }},

Welcome to {{ config('app.name')}}! This email confirms that your account email
address has been successfully updated to {{ $user->email }}.

You can now use this new address to log in, receive important notifications,
and manage your account.

Important: Be sure to update any saved login information or bookmarked links that might still use your old email address.

If you have any questions or encounter any issues with your new email address,
please don't hesitate to contact our support team.

We hope you continue to enjoy using {{ config('app.name') }}!

<x-mail::button :url="config('app.url')">
Go To Account
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
