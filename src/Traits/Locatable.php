<?php

namespace Provodd\LaravelAuthenticationLog\Traits;

use Provodd\LaravelAuthenticationLog\Services\FirstService;
use Provodd\LaravelAuthenticationLog\Services\SecondService;
use Provodd\LaravelAuthenticationLog\Services\ThirdService;

trait Locatable
{

    protected function getLocation()
    {
        $ip_data = null;
        if (config('authentication-log.use_ip_services')) {
            $ip_services = [FirstService::class, ThirdService::class, SecondService::class];
            foreach ($ip_services as $service) {
                if ($ip_data = $service::getData()) {
                    break;
                }
            }
        }
        return $ip_data;
    }

}