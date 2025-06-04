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
        'carnet_identidad',
        'fecha_nacimiento',
        'pais',
        'departamento',
        'ciudad',
        'zona',
        'calle',
        'numero_puerta',
        'email',
        'departamento_id',
        'encargado_id',
        'numero_celular',
        'fecha_contratacion',
        'salario',
        'estado',
    ];
    
    protected $hidden = [];

    public static function filtro(array $fields, string $value){
        $value = trim(filter_var($value, FILTER_SANITIZE_STRING));
        return self::query()->whereAny($fields, $value)->get();
    }
}
