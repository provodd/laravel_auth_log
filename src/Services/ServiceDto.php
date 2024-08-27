<?php

namespace Provodd\LaravelAuthenticationLog\Services;

class ServiceDto
{
    public string $country;
    public string $countryCode;
    public string $region;
    public string $city;
    public string $zip;
    public string $lat;
    public string $lon;
    public string $isp;

    public function __construct(?string $country = null, ?string $countryCode = null, ?string $region = null, ?string $city = null,
                                 ?string $zip = null, ?float $lat = null, ?float $lon = null, ?string $isp = null)
    {
        $this->country = $country;
        $this->countryCode = $countryCode;
        $this->region = $region;
        $this->city = $city;
        $this->zip = $zip;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->isp = $isp;
    }

    public function toArray()
    {
        return [
            'country' => $this->country,
            'countryCode' => $this->countryCode,
            'region' => $this->region,
            'city' => $this->city,
            'zip' => $this->zip,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'isp' => $this->isp
        ];
    }

}
