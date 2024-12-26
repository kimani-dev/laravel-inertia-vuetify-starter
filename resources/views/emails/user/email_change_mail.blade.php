<v-mail::message>
# Your Email Address Has Been Changed

Hello {{ $data->name }},

We wanted to inform you that the email address associated with your {{config('app.name')}} account has been successfully updated
from {{ $data->previous_email }} to {{ $data->email }}.

If you did not request this change, please contact our support team immediately to secure your account.

Thank you for using {{config('app.name')}}!

Best Regards,<br>
{{ config('app.name') }}
</v-mail::message>