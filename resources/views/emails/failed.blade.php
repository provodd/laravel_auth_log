@component('mail::message')
# @lang('Hello!')

@lang('There has been a failed login attempt to your :app account.', ['app' => config('app.name')])

> **@lang('Account:')** {{ $account->email }}<br/>
> **@lang('Time:')** {{ $time->translatedFormat('j F Y H:i') }}<br/>
> **@lang('IP Address:')** {{ $ipAddress }}<br/>
> **@lang('Browser:')** {{ $browser }}<br/>
@if ($location && isset($location['city']))
> **@lang('Location:')** {{ $location['city'] ?? __('Unknown City') }}, {{ $location['state'] ?? __('Unknown State') }}
@endif

@lang('If this was you, you can ignore this alert. If you suspect any suspicious activity on your account, please change your password.')

@lang('Regards,')<br/>
{{ config('app.name') }}
@endcomponent
