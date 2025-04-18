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
    public function users()     { return $this->hasMany(User::class); }
    public function products()  { return $this->hasMany(Product::class); }
    public function categories(){ return $this->hasMany(Category::class); }
    public function providers() { return $this->hasMany(Provider::class); }

}
