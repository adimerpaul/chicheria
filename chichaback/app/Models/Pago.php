<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'monto',
        'observacion',
    ];
    protected $hidden = ["created_at", "updated_at"];
}
