<?php

declare(strict_types=1);

/**
 * Config to return types authorization gateways.
 */
return [
    'gateway' => [
        'picpay' => [
            'uri' => 'https://util.devi.tools/api/v2/authorize',
        ],
        'itau' => [],
    ],
];
