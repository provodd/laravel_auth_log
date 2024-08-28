<?php

namespace Provodd\LaravelAuthenticationLog\Services;

class FirstService extends AbstractService
{

    private static $url = 'http://ip-api.com/json/';

    public static function getData(): bool|ServiceDto
    {
        $response = @file_get_contents(self::$url);
        if ($response === false) return false;
        $response = json_decode($response);
        if (!isset($response->status) or $response->status !== 'success') return false;
        return self::toDto($response);
    }

    public static function toDto(mixed $response): ServiceDto
    {
        return new ServiceDto($response->country ?? null, $response->countryCode ?? null, $response->region ?? null, $response->city ?? null, $response->zip ?? null, $response->lat ?? null, $response->lon ?? null, $response->isp ?? null);
    }
}
