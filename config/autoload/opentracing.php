<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 *
 * @document https://hyperf.wiki
 *
 * @contact  group@hyperf.io
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Tracer\Adapter\JaegerTracerFactory;
use Hyperf\Tracer\Adapter\ZipkinTracerFactory;
use Zipkin\Samplers\BinarySampler;

use function Hyperf\Support\env;

return [
    'default' => env('TRACER_DRIVER', 'zipkin'),
    'enable'  => [
        'guzzle' => env('TRACER_ENABLE_GUZZLE', true),
        'redis'  => env('TRACER_ENABLE_REDIS', true),
        'db'     => env('TRACER_ENABLE_DB', true),
        'method' => env('TRACER_ENABLE_METHOD', true),
    ],
    'tracer' => [
        'zipkin' => [
            'driver' => ZipkinTracerFactory::class,
            'app'    => [
                'name' => env('APP_NAME', 'skeleton'),
                // Hyperf will detect the system info automatically as the value if ipv4, ipv6, port is null
                'ipv4' => '127.0.0.1',
                'ipv6' => null,
                'port' => 9501,
            ],
            'options' => [
                'endpoint_url' => env('ZIPKIN_ENDPOINT_URL', 'http://banking-zipkin:9411/api/v2/spans'),
                'timeout'      => env('ZIPKIN_TIMEOUT', 1),
            ],
            'sampler' => BinarySampler::createAsAlwaysSample(),
        ],
        'jaeger' => [
            'driver'  => JaegerTracerFactory::class,
            'name'    => env('APP_NAME', 'skeleton'),
            'options' => [
                'local_agent' => [
                    'reporting_host' => env('JAEGER_REPORTING_HOST', 'localhost'),
                    'reporting_port' => env('JAEGER_REPORTING_PORT', 5775),
                ],
            ],
        ],
    ],
    'tags' => [
        'http_client' => [
            'http.url' => 'http.url',
            'http.method' => 'http.method',
            'http.status_code' => 'http.status_code',
        ],
        'redis' => [
            'arguments' => 'arguments',
            'result' => 'result',
        ],
        'db' => [
            'db.query' => 'db.query',
            'db.statement' => 'db.statement',
            'db.query_time' => 'db.query_time',
        ],
        'exception' => [
            'class' => 'exception.class',
            'code' => 'exception.code',
            'message' => 'exception.message',
            'stack_trace' => 'exception.stack_trace',
        ],
        'request' => [
            'path' => 'request.path',
            'uri' => 'request.uri',
            'method' => 'request.method',
            'header' => 'request.header',
            /**
             * I added this option :).
             *
             * @see https://github.com/hyperf/hyperf/commit/3037ed81582751c7c73638c4be0b3bdc6388e5fd
             */
            'body' => 'request.body',
        ],
        'coroutine' => [
            'id' => 'coroutine.id',
        ],
        'response' => [
            'status_code' => 'response.status_code',
            /**
             * I added this option :).
             *
             * @see https://github.com/hyperf/hyperf/commit/3037ed81582751c7c73638c4be0b3bdc6388e5fd
             */
            'body' => 'response.body',
        ],
    ]
];
