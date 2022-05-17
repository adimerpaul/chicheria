<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'hora',
        'cantidad',
        'observacion',
        'provider_id',
        'material_id',
        'user_id'

    ];
    protected $hidden = ["created_at", "updated_at"];
}
