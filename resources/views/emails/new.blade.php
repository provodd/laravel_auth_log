@component('mail::message')
# @lang('Hello!')

@lang('Your :app account logged in from a new device.', ['app' => config('app.name')])

> **@lang('Account:')** {{ $account->email }}<br/>
> **@lang('Time:')** {{ $time->translatedFormat('j F Y H:i') }}<br/>
@if (config('authentication-log.use_ip_services'))
> **@lang('IP Address:')** {{ $ipAddress }}<br/>
@endif
> **@lang('Browser:')** {{ $browser }}<br/>
@if ($location && isset($location['city']))
> **@lang('Location:')** {{ $location['city'] ?? __('Unknown City') }}, {{ $location['region'] ?? __('Unknown State') }}
@endif

@lang('If this was you, you can ignore this alert. If you suspect any suspicious activity on your account, please change your password.')

@lang('Regards,')<br/>
{{ config('app.name') }}
@endcomponent
