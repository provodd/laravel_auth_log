<?php

return [
    // The database table name
    // You can change this if the database keys get too long for your driver
    'table_name' => 'authentication_log',

    // The database connection where the authentication_log table resides. Leave empty to use the default
    'db_connection' => null,

    //check geolocation using ip services
    'use_ip_services' => false,

    // The events the package listens for to log
    'events' => [
        'login' => \Illuminate\Auth\Events\Login::class,
        'failed' => \Illuminate\Auth\Events\Failed::class,
        'logout' => \Illuminate\Auth\Events\Logout::class,
        'logout-other-devices' => \Illuminate\Auth\Events\OtherDeviceLogout::class,
    ],

    'listeners' => [
        'login' => \Provodd\LaravelAuthenticationLog\Listeners\LoginListener::class,
        'failed' => \Provodd\LaravelAuthenticationLog\Listeners\FailedLoginListener::class,
        'logout' => \Provodd\LaravelAuthenticationLog\Listeners\LogoutListener::class,
        'logout-other-devices' => \Provodd\LaravelAuthenticationLog\Listeners\OtherDeviceLogoutListener::class,
    ],

    'notifications' => [
        'new-device' => [
            // Send the NewDevice notification
            'enabled' => true,

            // The Notification class to send
            'template' => \Provodd\LaravelAuthenticationLog\Notifications\NewDevice::class,
        ],
        'failed-login' => [
            // Send the FailedLogin notification
            'enabled' => false,

            // The Notification class to send
            'template' => \Provodd\LaravelAuthenticationLog\Notifications\FailedLogin::class,
        ],
    ],

    // When the clean-up command is run, delete old logs greater than `purge` days
    // Don't schedule the clean-up command if you want to keep logs forever.
    'purge' => 365,

];
