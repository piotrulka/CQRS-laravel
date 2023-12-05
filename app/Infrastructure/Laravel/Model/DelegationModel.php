<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelegationModel extends Model
{
    use HasUuids;
    protected $fillable = [
        'start',
        'end',
        'country',
        'amount_due',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'delegations';

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }
}
