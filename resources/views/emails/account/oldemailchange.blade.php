<x-mail::message>
# Email Change Request

Hi {{ $user->name }},

This email is to confirm that your request to change your email address on {{ config('app.name')}} has been processed.
Your account is no longer associated with the address {{ $previousEmail}}.

Please note: It's important to update any bookmarks or saved login information you might have using the old email address.

If you did not initiate this email change, please contact our support team immediately
to secure your account.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
