@component('mail::message')
Email de Notificação - Não responder.

Seu perfil foi criado!

@component('mail::button', ['url' => 'http://127.0.0.1:8000/Perfil'])
Seu Perfil
@endcomponent

Atenciosamente.<br>
{{ config('app.name') }}
@endcomponent
