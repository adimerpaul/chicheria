<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable=[
        "fecha",
        "total",
        "acuenta",
        "saldo",
        "estado",
        "local",
        'user_id',
        'cliente_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
