<?php

namespace Provodd\LaravelAuthenticationLog\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Provodd\LaravelAuthenticationLog\Notifications\FailedLogin;
use Provodd\LaravelAuthenticationLog\Services\FirstService;
use Provodd\LaravelAuthenticationLog\Services\SecondService;
use Provodd\LaravelAuthenticationLog\Services\ThirdService;
use Provodd\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class FailedLoginListener
{
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle($event): void
    {
        $listener = config('authentication-log.events.failed', Failed::class);

        if (! $event instanceof $listener) {
            return;
        }

        if ($event->user) {
            if(! in_array(AuthenticationLoggable::class, class_uses_recursive(get_class($event->user)))) {
                return;
            }

            $ip = $this->request->ip();

            $ip_services = [FirstService::class, ThirdService::class, SecondService::class];
            foreach ($ip_services as $service) {
                if ($ip_data = $service::getData()) {
                    break;
                }
            }

            $log = $event->user->authentications()->create([
                'ip_address' => $ip,
                'user_agent' => $this->request->userAgent(),
                'login_at' => now(),
                'login_successful' => false,
                'location' => $ip_data,
                'request_payload' => json_encode($this->request->all()),
            ]);

            if (config('authentication-log.notifications.failed-login.enabled')) {
                $failedLogin = config('authentication-log.notifications.failed-login.template') ?? FailedLogin::class;
                $event->user->notify(new $failedLogin($log));
            }
        }
    }
}
