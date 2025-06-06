<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Observers\DepartamentoObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Departamento",
 *     required={"nombre_departamento"},
 *     @OA\Property(property="departamento_id", type="integer", example=1),
 *     @OA\Property(property="nombre_departamento", type="string", example="Recursos Humanos"),
 *     @OA\Property(property="encargado_id", type="integer", example=3),
 *     @OA\Property(property="subdepartamento_de", type="integer", nullable=true, example=null),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-05T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-05T12:00:00Z")
 * )
 */

#[ObservedBy([DepartamentoObserver::class])]
class Departamento extends Model
{
    /** @use HasFactory<\Database\Factories\DepartamentoFactory> */
    use HasFactory;

    public $incrementing  = true;
    public $timestamps = true;
    protected $primaryKey = "departamento_id";
    protected $keyType = "integer";
    protected $table = "departamentos";

    protected $fillable = [
        'nombre_departamento', 
        'encargado_id', 
        'subdepartamento_de'];
    protected $hidden = [];

    public function empleados() : HasMany
    {
        return $this->hasMany(Empleado::class, 'departamento_id', 'departamento_id');
    }

    public function encargado() : BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'encargado_id');
    }

    public function subdepartamentos(): HasMany
    {
        return $this->hasMany(Departamento::class, 'subdepartamento_de');
    }

    public static function filtro(array $fields, string $value){
        $value = trim(filter_var($value, FILTER_SANITIZE_STRING));
        return self::query()->whereAny($fields, $value)->get();
    }
}
