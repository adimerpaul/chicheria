<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logcaja extends Model
{
    use HasFactory;
    protected $fillable=[
        'monto',
        'motivo',
        'tipo',
        'fecha',
        'hora',
        'user_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
