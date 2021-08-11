@component('mail::message')
Email de Notificação para o Usuario - Não responder.

Suas informações de Perfil foram Atualizadas!

@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard'])
Seu Perfil
@endcomponent

Atenciosamente.<br>
{{ config('app.name') }}
@endcomponent
