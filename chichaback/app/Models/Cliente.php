<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable=[
        'local',
        'titular',
        'tipo',
        'telefono',
        'fechanac',
        'direccion',
        'legalidad',
        'categoria',
        'razon',
        'nit',
        'estado',
    ];
    protected $hidden = ["created_at", "updated_at"];
}
