@component('mail::message')
Hey 👋 ,

Votre compte a été bien créer, Vos cordonnées :<br>
Email: {{ $details['email'] }}<br>
Password: {{ $details['password'] }}<br>




Merci d'avoir utiliser notre application,<br>
{{ config('app.name') }}
@endcomponent
