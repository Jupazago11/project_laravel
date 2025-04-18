<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IvaRate extends Model
{
    protected $fillable = [
        'code',        // código corto
        'name',        // nombre legible
        'rate',        // porcentaje
        'description', // detalle (opcional)
        'status',      // activa/inactiva
    ];

    /**
     * Productos que usan esta tarifa de IVA.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
