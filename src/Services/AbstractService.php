<?php

namespace Provodd\LaravelAuthenticationLog\Services;

use Illuminate\Http\Request;

class AbstractService
{

    protected static $ip;

    public function __construct($ip = false)
    {
        $this->ip = $ip ?? request()->ip();
    }

    public static function getData()
    {

    }

    public static function toDto(mixed $response): ServiceDto
    {

    }

    public function toArray(ServiceDto $dto)
    {
        return (array)$dto;
    }
}
