<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeUser extends Model
{
    // Indica la tabla si difiere de la convención "type_users"
    protected $table = 'type_users';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'type',
        'status',
    ];

    /**
     * Relación con el modelo User (un TypeUser puede tener muchos usuarios).
     */
    public function users()
    {
        return $this->hasMany(User::class, 'type_user_id');
    }
}
