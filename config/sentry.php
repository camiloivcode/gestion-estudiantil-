<?php

return [

    'dsn' => env('SENTRY_LARAVEL_DSN'),

    'release' => env('SENTRY_RELEASE'),

    'environment' => env('APP_ENV'),

    'breadcrumbs' => [
        'logs'          => true,
        'sql_queries'   => true,
        'sql_bindings'  => true,
        'queue_info'    => true,
        'command_info'  => true,
    ],

    'tracing' => [
        'enabled'           => env('SENTRY_TRACING_ENABLED', false),
        'routes'            => env('SENTRY_TRACING_ROUTES', true),
        'queue_jobs'        => true,
    ],

];
