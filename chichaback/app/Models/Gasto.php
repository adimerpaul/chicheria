<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $fillable=[
        'precio',
        'observacion',
        'glosa',
        'fecha',
        'hora',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
