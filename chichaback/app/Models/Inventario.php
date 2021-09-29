<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $fillable=[
        'codigo',
        'nombre',
        'cantidad',
        'detalle',
        'estado',
    ];
    protected $hidden = ["created_at", "updated_at"];
}
