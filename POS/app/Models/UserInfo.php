<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    protected $fillable = [
        'identification',
        'cellphone',
        'birth_date',
        'eps',
        'compensation_box',
        'arl',
        'pension',
        'salary',
        'hire_date',
        'contract_type',
        'contract_duration',
        'contract_date',
        'observation',
    ];
}
