<?php

namespace Provodd\LaravelAuthenticationLog\Services;

class ThirdService extends AbstractService
{

    private static $url = 'https://api.ipregistry.co/';

    public static function getData()
    {
        $response = @file_get_contents(self::$url . self::$ip.'?key=tryout');
        if ($response === false) return false;
        $response = json_decode($response);
        if (!isset($response->location->city)) return false;
        return self::toDto($response);
    }

    public static function toDto(mixed $response): ServiceDto
    {
        return new ServiceDto($response->location->country->name ?? null,
            $response->location->country->code ?? null,
            $response->location->region->name ?? null,
            $response->location->city ?? null,
            $response->location->postal ?? null,
            $response->location->latitude ?? null,
            $response->location->longitude ?? null,
            $response->company->name ?? null);
    }
}
