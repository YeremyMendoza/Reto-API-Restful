<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Observers\DepartamentoObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([DepartamentoObserver::class])]
class Departamento extends Model
{
    /** @use HasFactory<\Database\Factories\DepartamentoFactory> */
    use HasFactory;

    public $incrementing  = true;
    public $timestamps = true;
    protected $connection = "mysql";
    protected $primaryKey = "departamento_id";
    protected $keyType = "integer";
    protected $table = "departamentos";

    protected $fillable = ['nombre_departamento', 'encargado_id'];
    protected $hidden = [];

    public function empleados() : HasMany
    {
        return $this->hasMany(Empleado::class, 'departamento_id', 'departamento_id');
    }

    public function encargado() : BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'encargado_id');
    }

    public static function filtro(array $fields, string $value){
        $value = trim(filter_var($value, FILTER_SANITIZE_STRING));
        return self::query()->whereAny($fields, $value)->get();
    }
}
