<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'client_id',
        'amount',
        'payment_date',
    ];

    // Relación inversa al cliente
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
