<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'estado',
        'cantidad',
        'user_id',
        'cliente_id',
        'inventario_id',
    ];
    protected $hidden = ["created_at", "updated_at"];
    public function inventario(){
        return $this->belongsTo(Inventario::class);
    }
}
