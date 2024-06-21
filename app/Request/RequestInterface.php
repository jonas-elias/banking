<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\HttpServer\Contract\RequestInterface as HyperfRequestInterface;

/**
 * Request interface bind hyperf.
 */
interface RequestInterface extends HyperfRequestInterface
{
}
