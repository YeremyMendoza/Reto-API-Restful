<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    /** @use HasFactory<\Database\Factories\EmpleadoFactory> */
    use HasFactory;

    public $incrementing  = true;
    public $timestamps = true;
    protected $connection = "mysql";
    protected $primaryKey = "empleado_id";
    protected $keyType = "integer";
    protected $table = "empleados";

    protected $fillable = [
        'nombre', 
        'apellido_paterno', 
        'apellido_materno', 
        'email', 
        'numero_celular', 
        'fecha_contratacion', 
        'salario', 
        'estado'
    ];
    
    protected $hidden = [];
}
