<?php

namespace Provodd\LaravelAuthenticationLog\Services;

use Illuminate\Http\Request;

class AbstractService
{
    public static function getData(): bool|ServiceDto
    {
        return false;
    }

    public static function toDto(mixed $response): ServiceDto
    {
        return new ServiceDto($response);
    }

    public function toArray(ServiceDto $dto): array
    {
        return (array)$dto;
    }
}
