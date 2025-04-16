<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'name',
        'nit',
        'direction',
        'status',
    ];

    // relación inversa: una company tiene muchos users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
