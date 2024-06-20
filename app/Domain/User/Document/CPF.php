<?php

declare(strict_types=1);

namespace App\Domain\User\Document;

/**
 * Class to implement CPF methods abstract extends
 */
class CPF extends Document
{
    /**
     * Method constructor
     *
     * @param string $value
     *
     * @return void
     */
    public function __construct(protected string $value)
    {
        $this->validate();
    }

    /**
     * Method to validate length document value
     *
     * @return void
     */
    protected function validate(): void
    {
        if (strlen($this->value) !== 11) {
            // throw error
        }
    }
}
