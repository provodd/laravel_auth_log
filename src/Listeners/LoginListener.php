<?php

namespace Provodd\LaravelAuthenticationLog\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Provodd\LaravelAuthenticationLog\Services\FirstService;
use Provodd\LaravelAuthenticationLog\Notifications\NewDevice;
use Provodd\LaravelAuthenticationLog\Services\SecondService;
use Provodd\LaravelAuthenticationLog\Services\ThirdService;
use Provodd\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Provodd\LaravelAuthenticationLog\Traits\Locatable;

class LoginListener
{
    public Request $request;
    use Locatable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle($event): void
    {
        try {
            $listener = config('authentication-log.events.login', Login::class);

            if (!$event instanceof $listener) {
                return;
            }

            if ($event->user) {
                if (!in_array(AuthenticationLoggable::class, class_uses_recursive(get_class($event->user)))) {
                    return;
                }

                $ip = $this->request->ip();
                $user = $event->user;
                $userAgent = $this->request->userAgent();
                $known = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->whereLoginSuccessful(true)->first();
                $newUser = Carbon::parse($user->{$user->getCreatedAtColumn()})->diffInMinutes(Carbon::now()) < 1;

                $log = $user->authentications()->create([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'login_at' => now(),
                    'login_successful' => true,
                    'location' => $this->getLocation(),
                    'request_payload' => json_encode($this->request->all()),
                ]);

                if (!$known && !$newUser && config('authentication-log.notifications.new-device.enabled')) {
                    $newDevice = config('authentication-log.notifications.new-device.template') ?? NewDevice::class;
                    $user->notify(new $newDevice($log));
                }
            }
        } catch (\Exception $ex) {
            Log::channel()->error($ex->getLine() . ' ' . $ex->getFile() . ': ' . $ex->getMessage());
        }
    }
}
