<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    | Supported: "apc", "array", "database", "file", "memcached", "redis"
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT  => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM based store such as APC or Memcached, there might
    | be other applications utilizing the same cache. So, we'll specify a
    | value to get prefixed to all our keys so we can avoid collisions.
    |
    */

    'prefix' => env(
        'CACHE_PREFIX',
        str_slug(env('APP_NAME', 'laravel'), '_').'_cache'
    ),

    /*
    |--------------------------------------------------------------------------
    | Caching application entities options
    |--------------------------------------------------------------------------
    |
    | Below is the caching of application entities. This cache allows you to reduce
    | the load on the database. You can enable or disable it, as well as adjust the
    | lifetime of the cache (specified in seconds). Setting the lifetime to 0
    | allows you to make a cache without expiration.
    |
    */

    'options' => [
        'settings' => [
            'enabled' => true,
            'lifetime' => 86400
        ],
        'servers' => [
            'enabled' => true,
            'lifetime' => 3600
        ],
        'categories' => [
            'enabled' => true,
            'lifetime' => 3600
        ],
        'items' => [
            'enabled' => true,
            'lifetime' => 3600
        ],
        'products' => [
            'enabled' => true,
            'lifetime' => 3600
        ],
        'users' => [
            'enabled' => true,
            'lifetime' => 600
        ],
        'roles' => [
            'enabled' => true,
            'lifetime' => 3600
        ],
        'permissions' => [
            'enabled' => true,
            'lifetime' => 3600
        ],
        'pages' => [
            'enabled' => true,
            'lifetime' => 86400
        ],
    ]
];
