<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Model\Model;

/**
 * Model to represent user single-table model.
 */
class User extends Model
{
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
}
