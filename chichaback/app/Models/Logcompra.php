<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logcompra extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'monto',
        'observacion',
        'compra_id',
        'user_id',
    ];
    protected $hidden = ["created_at", "updated_at"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
