<?php

declare(strict_types=1);

namespace App\Domain\User\Document;

/**
 * Class to implement CNPJ methods abstract extends
 */
class CNPJ extends Document
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
        if (strlen($this->value) !== 14) {
            // throw error
        }
    }
}
