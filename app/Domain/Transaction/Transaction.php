<?php

declare(strict_types=1);

namespace App\Domain\Transaction;

use App\Model\Model;
use Hyperf\Database\Model\Concerns\HasUlids;

/**
 * Model to represent transaction table.
 */
class Transaction extends Model
{
    use HasUlids;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'id',
        'payer_id',
        'payee_id',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];
}
