<?php

declare(strict_types=1);

namespace App\Domain\User\DTO;

use App\Domain\User\Contract\UserDTOInterface;
use App\DTO\BaseDTO;
use App\DTO\Cast\IntegerCast;

/**
 * Class DTO to user get params and basic validations.
 */
class UserDTO extends BaseDTO implements UserDTOInterface
{
    /**
     * @var string
     *             The user name.
     */
    public string $name;

    /**
     * @var string
     *             The user document CPF or CNPJ.
     */
    public string $document;

    /**
     * @var string
     *             The user email address.
     */
    public string $email;

    /**
     * @var string
     *             The user password.
     */
    public string $password;

    /**
     * @var int
     *          The user balance in cents.
     */
    public int $balance;

    /**
     * @var string
     *             The user type either 'common' or 'merchant'.
     */
    public string $type;

    /**
     * Define the validation messages for each field.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'     => 'The name field is required.',
            'name.string'       => 'The name field must be a string.',
            'document.required' => 'The document field is required.',
            'document.string'   => 'The document field must be a string.',
            'email.required'    => 'The email field is required.',
            'email.email'       => 'The email field must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.string'   => 'The password field must be a string.',
            'password.min'      => 'The password field must be at least 8 characters.',
            'balance.required'  => 'The balance field is required.',
            'balance.integer'   => 'The balance field must be an integer value.',
            'balance.min'       => 'The balance field must be at least 0.',
            'type.required'     => 'The type field is required.',
            'type.in'           => 'The type field must be either "common" or "merchant".',
        ];
    }

    /**
     * Define the default values for each field.
     *
     * @return array
     */
    public function defaults(): array
    {
        return [
            'balance' => 0,
        ];
    }

    /**
     * Define method to get password with hash.
     *
     * @return string
     */
    public function hashPassword(): string
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    /**
     * Define the validation rules for each field.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'name'     => ['required', 'string'],
            'document' => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'balance'  => ['required', 'integer', 'min:0'],
            'type'     => ['required', 'in:common,merchant'],
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
            'balance' => new IntegerCast(),
        ];
    }
}
