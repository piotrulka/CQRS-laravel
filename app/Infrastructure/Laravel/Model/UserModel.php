<?php

namespace App\Infrastructure\Laravel\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserModel extends Authenticatable
{
    use HasUuids;

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'users';

    public function delegations(): HasMany
    {
        return $this->hasMany(DelegationModel::class);
    }
}
