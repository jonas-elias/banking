<?php

declare(strict_types=1);

namespace App\Response;

use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponseInterface;

/**
 * Response interface bind hyperf.
 */
interface ResponseInterface extends HyperfResponseInterface
{
}
