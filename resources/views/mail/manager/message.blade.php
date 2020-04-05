@component('mail::message')
# Новая сообщение в заявке №{{$application->id}}
------
# Заявка
**Тема:** {{$application->subject}}

**Сообщение:** {{$application->messages->last()->message}}
@endcomponent
