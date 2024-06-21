<?php

declare(strict_types=1);

namespace App\Response;

use Hyperf\HttpServer\Response as HyperfResponse;

/**
 * Response class bind hyperf.
 */
class Response extends HyperfResponse implements ResponseInterface
{
}
