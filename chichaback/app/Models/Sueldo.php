<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sueldo extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'hora',
        'monto',
        'tipo',
        'empleado_id',
        'user_id',

    ];
}
