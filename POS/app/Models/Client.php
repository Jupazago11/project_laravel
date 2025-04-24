<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'identification',
        'email',
        'phone',
        'address',
        'credit_limit',
        'current_balance',
        'status',
    ];

    /**
     * Cada cliente pertenece a una compañía.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
