<?php

declare(strict_types=1);

namespace App\Domain\Transaction\DTO;

use App\Domain\Transaction\Contract\TransactionDTOInterface;
use App\DTO\BaseDTO;
use App\DTO\Cast\IntegerConversionCast;

/**
 * Class DTO to transaction get params and basic validations.
 */
class TransactionDTO extends BaseDTO implements TransactionDTOInterface
{
    /**
     * @var string
     *             The payer ulid.
     */
    public string $payer;

    /**
     * @var string
     *             The payee ulid.
     */
    public string $payee;

    /**
     * @var int
     *          The value in cents.
     */
    public int $value;

    /**
     * Define the validation messages for each field.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'payer.required' => 'The payer field is required.',
            'payer.string'   => 'The payer field must be a string.',
            'payee.required'  => 'The payee field is required.',
            'payee.string'    => 'The payee field must be a string.',
            'value.required'  => 'The value field is required.',
            'value.numeric'   => 'The value field must be an numeric.',
            'value.min'       => 'The value field must be at least 1 cent.',
        ];
    }

    /**
     * Define the default values for each field.
     *
     * @return array
     */
    public function defaults(): array
    {
        return [];
    }

    /**
     * Define the validation rules for each field.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'payer'   => ['required', 'string'],
            'payee'    => ['required', 'string'],
            'value'    => ['required', 'numeric', 'min:0.1'],
        ];
    }

    /**
     * Define the cast types for each field.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'value' => new IntegerConversionCast(),
        ];
    }
}
