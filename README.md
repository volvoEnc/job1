## Информация
Laravel 7.0 - требованя окружения соответствующие. 
В задании не точно сказано о том сколько менеджеров в прокете. В случае с созданием заявки, почта менеджера на которую придет уведомление указывается в .env файле.
Недоработал иконки, они работают только после установки пакетов npm и пересборки.
## Инструкция

- Выполните
```
composer install
```
- _Выполните (не обязательно)_
```
npm install
npm run dev
```
- Настройте .env файл
- Выполните миграции и сиды
```
php artisan migrate --seed
```
## Данные для входа
### Менеджер
**Email:** _manager@mail.ru_

**Пароль:** _12345_
### Пользователь
**Email:** _user@mail.ru_

**Пароль:** _54321_
