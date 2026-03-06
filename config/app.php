<?php

use Cake\Cache\Engine\FileEngine;
use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Cake\Log\Engine\FileLog;
use Cake\Mailer\Transport\MailTransport;

return [
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    'App' => [
        'namespace' => 'App',
        'encoding' => env('APP_ENCODING', 'UTF-8'),
        'defaultLocale' => env('APP_DEFAULT_LOCALE', 'en_US'),
        'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'UTC'),
        'base' => false,
        'dir' => 'src',
        'webroot' => 'webroot',
        'wwwRoot' => WWW_ROOT,
        'fullBaseUrl' => false,
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS],
            'templates' => [ROOT . DS . 'templates' . DS],
            'locales' => [RESOURCES . 'locales' . DS],
        ],
    ],

    'Security' => [
        'salt' => env('SECURITY_SALT', 'fallback-change-this-in-production-env'),
    ],

    'Asset' => [],

    'Cache' => [
        'default' => [
            'className' => FileEngine::class,
            'path' => CACHE,
            'url' => env('CACHE_DEFAULT_URL', null),
        ],
        '_cake_core_' => [
            'className' => FileEngine::class,
            'prefix' => 'myapp_cake_core_',
            'path' => CACHE . 'persistent' . DS,
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKECORE_URL', null),
        ],
        '_cake_model_' => [
            'className' => FileEngine::class,
            'prefix' => 'myapp_cake_model_',
            'path' => CACHE . 'models' . DS,
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKEMODEL_URL', null),
        ],
        '_cake_translations_' => [
            'className' => FileEngine::class,
            'prefix' => 'myapp_cake_translations_',
            'path' => CACHE . 'persistent' . DS,
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKETRANSLATIONS_URL', null),
        ],
    ],

    'Error' => [
        'errorLevel' => E_ALL,
        'skipLog' => [],
        'log' => true,
        'trace' => true,
        'ignoredDeprecationPaths' => [
            'src/Application.php',
            'vendor/cakephp/authentication/src/AuthenticationService.php',
        ],
    ],

    'Debugger' => [
        'editor' => 'phpstorm',
    ],

    'EmailTransport' => [
        'default' => [
            'className' => MailTransport::class,
            'host' => env('EMAIL_HOST', 'localhost'),
            'port' => env('EMAIL_PORT', 25),
            'timeout' => 30,
            'username' => env('EMAIL_USERNAME', null),
            'password' => env('EMAIL_PASSWORD', null),
            'client' => null,
            'tls' => false,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => env('EMAIL_FROM', 'you@localhost'),
        ],
    ],

    'Datasources' => [
        'default' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
            /*
             * All DB credentials are loaded from the DATABASE_URL env var.
             * Format: mysql://user:password@host/database
             */
            'url' => env('DATABASE_URL', null),
        ],

        'test' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
        ],
    ],

    'Log' => [
        'debug' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'debug',
            'url' => env('LOG_DEBUG_URL', null),
            'scopes' => null,
            'levels' => ['notice', 'info', 'debug'],
        ],
        'error' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'error',
            'url' => env('LOG_ERROR_URL', null),
            'scopes' => null,
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
        'queries' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'queries',
            'url' => env('LOG_QUERIES_URL', null),
            'scopes' => ['cake.database.queries'],
        ],
    ],

    'Session' => [
        'defaults' => 'php',
    ],
];
