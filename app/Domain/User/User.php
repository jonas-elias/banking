<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Exception\BalanceException;
use App\Model\Model;
use Hyperf\Database\Model\Concerns\HasUlids;

/**
 * Model to represent user single-table model.
 */
class User extends Model
{
    use HasUlids;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'user';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'id',
        'name',
        'email',
        'password',
        'document',
        'balance',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * Method to increase value in balance.
     *
     * @param int $value
     *
     * @return User
     */
    public function credit(int $value): User
    {
        $this->balance += $value;

        return $this;
    }

    /**
     * Method to decrease value in balance.
     *
     * @param int $value
     *
     * @return User
     */
    public function debit(int $value): User
    {
        if ($value > $this->balance) {
            throw new BalanceException();
        }

        $this->balance -= $value;

        return $this;
    }
}
