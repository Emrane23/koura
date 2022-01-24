@component('mail::message')
Hey 👋 ,

Nous vous informons que notre admin {{ $details['validation'] }} votre réservation.

Merci d'avoir utiliser notre application,<br>
{{ config('app.name') }}
@endcomponent
