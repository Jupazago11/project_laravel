<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'company_id',
        'category_id',
        'provider_id',
        'product_code',
        'name',
        'description',
        'cost',
        'iva_rate_id',
        'inc_rate',
        'additional_tax',
        'price_1',
        'price_2',
        'price_3',
        'track_inventory',
        'stock',
        'status',
    ];

    // Relación con Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relación con Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con Provider
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    // Relación con IvaRate
    public function ivaRate()
    {
        return $this->belongsTo(IvaRate::class);
    }
}
