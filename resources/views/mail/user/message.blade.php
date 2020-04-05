@component('mail::message')
# Новое сообщение в заявке №{{$application->id}}
------
# Пользователь
**Email:** {{$application->user->email}}

------
# Заявка
**Тема:** {{$application->subject}}

**Сообщение:** {{$application->messages->last()->message}}

------
@component('mail::button', ['url' => route('mail-login', [
            'auth_token' => $token->token,
            'application' => $application->id
            ])])
Перейти к заявке
@endcomponent
@endcomponent
