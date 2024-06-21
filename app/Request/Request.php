<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\HttpServer\Request as HyperfRequest;

/**
 * Request class bind hyperf.
 */
class Request extends HyperfRequest implements RequestInterface
{
}
