<?php

declare(strict_types=1);

namespace App\DTO;

use FriendsOfHyperf\ValidatedDTO\ValidatedDTO;

class TransactionDTO extends ValidatedDTO
{
    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    protected function rules(): array
    {
        return [];
    }

    protected function scenes(): array
    {
        return [];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
