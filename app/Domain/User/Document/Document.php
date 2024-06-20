<?php

declare(strict_types=1);

namespace App\Domain\User\Document;

/**
 * Abstract class to create signature of methods
 */
abstract class Document
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
     * Method to get value document
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Method to validate type of concret class
     *
     * @return void
     */
    abstract protected function validate(): void;
}
