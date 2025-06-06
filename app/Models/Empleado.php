<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @OA\Schema(
 *     schema="Empleado",
 *     required={"nombre", "apellido_paterno", "carnet_identidad", "email"},
 *     @OA\Property(property="empleado_id", type="integer", example=10),
 *     @OA\Property(property="nombre", type="string", example="Juan"),
 *     @OA\Property(property="apellido_paterno", type="string", example="Pérez"),
 *     @OA\Property(property="apellido_materno", type="string", example="Gonzales"),
 *     @OA\Property(property="carnet_identidad", type="string", example="12345678"),
 *     @OA\Property(property="fecha_nacimiento", type="string", format="date", example="1990-01-01"),
 *     @OA\Property(property="pais", type="string", example="Bolivia"),
 *     @OA\Property(property="departamento", type="string", example="La Paz"),
 *     @OA\Property(property="ciudad", type="string", example="El Alto"),
 *     @OA\Property(property="zona", type="string", example="Villa Adela"),
 *     @OA\Property(property="calle", type="string", example="Calle 1"),
 *     @OA\Property(property="numero_puerta", type="string", example="456"),
 *     @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
 *     @OA\Property(property="departamento_id", type="integer", example=2),
 *     @OA\Property(property="encargado_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="numero_celular", type="string", example="77712345"),
 *     @OA\Property(property="fecha_contratacion", type="string", format="date", example="2020-05-10"),
 *     @OA\Property(property="salario", type="number", format="float", example=3500.50),
 *     @OA\Property(property="estado", type="string", example="activo"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-05T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-05T12:00:00Z")
 * )
 */

class Empleado extends Model
{
    /** @use HasFactory<\Database\Factories\EmpleadoFactory> */
    use HasFactory;

    public $incrementing  = true;
    public $timestamps = true;
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

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'departamento_id');
    }

    public function encargado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'encargado_id');
    }
    public function subordinados(): HasMany
    {
        return $this->hasMany(Empleado::class, 'encargado_id');
    }
}
