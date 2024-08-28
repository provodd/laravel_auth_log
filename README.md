# Журнал авторизаций для Laravel

На базе пакета rappasoft/laravel-authentication-log

## Установка
- composer require Provodd/laravel-auth-log
- php artisan vendor:publish --provider="Provodd\LaravelAuthenticationLog\LaravelAuthenticationLogServiceProvider" --tag="authentication-log-migrations"
- php artisan migrate
- php artisan vendor:publish --provider="Provodd\LaravelAuthenticationLog\LaravelAuthenticationLogServiceProvider" --tag="authentication-log-views"
- php artisan vendor:publish --provider="Provodd\LaravelAuthenticationLog\LaravelAuthenticationLogServiceProvider" --tag="authentication-log-config"
- php artisan vendor:publish --provider="Provodd\LaravelAuthenticationLog\LaravelAuthenticationLogServiceProvider" --tag="authentication-log-translations"
- Добавить трейт AuthenticationLoggable в класс User 

## Команды
- User::find(1)->authentications;
- User::find(1)->lastLoginAt();
- User::find(1)->lastSuccessfulLoginAt();
- User::find(1)->lastLoginIp();
- User::find(1)->lastSuccessfulLoginIp();
- auth()->user()->previousLoginAt();
- auth()->user()->previousLoginIp();

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
