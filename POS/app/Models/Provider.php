<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Provider extends Model
{
    protected $table = 'providers';

    protected $fillable = [
        'company_id',
        'name',
        'nit',
        'address',
        'contact',
        'employee_name',
        'employee_phone',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Cada proveedor pertenece a una empresa.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    
    // Un proveedor puede proveer muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

