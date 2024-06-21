<?php

declare(strict_types=1);

namespace App\Exception;

use Hyperf\Contract\ValidatorInterface;
use Hyperf\Validation\ValidationException as HyperfValidationException;

/**
 * Exception class throw in DTO validation.
 */
class ValidationException extends HyperfValidationException
{
    /**
     * Method constructor.
     *
     * @param ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(public ValidatorInterface $validator)
    {
        parent::__construct($validator);
    }
}
