<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Si tu tabla es 'category' en singular, especifícalo:
    protected $table = 'category';

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'description',
        'status',
    ];

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    // Una categoría puede tener muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
