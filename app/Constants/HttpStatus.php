<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class HttpStatus extends AbstractConstants
{
    /**
     * @Message("OK")
     */
    public const OK = 200;

    /**
     * @Message("Created")
     */
    public const CREATED = 201;

    /**
     * @Message("Accepted")
     */
    public const ACCEPTED = 202;

    /**
     * @Message("No Content")
     */
    public const NO_CONTENT = 204;

    /**
     * @Message("Bad Request")
     */
    public const BAD_REQUEST = 400;

    /**
     * @Message("Unauthorized")
     */
    public const UNAUTHORIZED = 401;

    /**
     * @Message("Forbidden")
     */
    public const FORBIDDEN = 403;

    /**
     * @Message("Not Found")
     */
    public const NOT_FOUND = 404;

    /**
     * @Message("Conflict")
     */
    public const CONFLICT = 409;

    /**
     * @Message("Unprocessable Entity")
     */
    public const UNPROCESSABLE_ENTITY = 422;

    /**
     * @Message("Internal Server Error")
     */
    public const INTERNAL_SERVER_ERROR = 500;

    /**
     * @Message("Service Unavailable")
     */
    public const SERVICE_UNAVAILABLE = 503;
}
