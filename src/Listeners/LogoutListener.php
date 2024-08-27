<?php

namespace Provodd\LaravelAuthenticationLog\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Provodd\LaravelAuthenticationLog\Models\AuthenticationLog;
use Provodd\LaravelAuthenticationLog\Services\FirstService;
use Provodd\LaravelAuthenticationLog\Services\SecondService;
use Provodd\LaravelAuthenticationLog\Services\ThirdService;
use Provodd\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class LogoutListener
{
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle($event): void
    {
        $listener = config('authentication-log.events.logout', Logout::class);

        if (! $event instanceof $listener) {
            return;
        }

        if ($event->user) {
            if(! in_array(AuthenticationLoggable::class, class_uses_recursive(get_class($event->user)))) {
                return;
            }

            $user = $event->user;

            $ip = $this->request->ip();

            $userAgent = $this->request->userAgent();
            $log = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->orderByDesc('login_at')->first();

            $ip_services = [FirstService::class, ThirdService::class, SecondService::class];
            foreach ($ip_services as $service) {
                if ($ip_data = $service::getData()) {
                    break;
                }
            }

            if (! $log) {
                $log = new AuthenticationLog([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'location' => $ip_data
                ]);
            }

            $log->logout_at = now();

            $user->authentications()->save($log);
        }
    }
}
