<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $fillable=[
        'ci',
        'nombre',
        'celular',
        'fechanac',
        'salario',
        'dias',
        'tipo',
    ];
    public function sueldos(){
        return $this->hasMany(Sueldo::class);
    }
    public function planillas(){
        return $this->hasMany(Planilla::class);
    }
}
