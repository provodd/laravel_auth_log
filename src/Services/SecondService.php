<?php

namespace Provodd\LaravelAuthenticationLog\Services;

class SecondService extends AbstractService
{

    private static $url = 'http://ipinfo.io/';

    public static function getData(): bool| ServiceDto
    {
        $response = @file_get_contents(self::$url.'json');
        if ($response === false) return false;
        $response = json_decode($response);
        if (!isset($response->city)) return false;
        return self::toDto($response);
    }

    public static function toDto(mixed $response): ServiceDto
    {
        $loc = explode(',', $response->loc);
        return new ServiceDto($response->country ?? null, $response->country ?? null, $response->region ?? null, $response->city ?? null, $response->postal ?? null, $loc[0] ?? null, $loc[1] ?? null, $response->org ?? null);
    }
}
