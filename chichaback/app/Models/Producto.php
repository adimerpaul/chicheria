<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'precio',
        'observacion',
        'estado',
        'tipo',
        'color',
        'orden'

    ];
    protected $hidden = ["created_at", "updated_at"];
}
