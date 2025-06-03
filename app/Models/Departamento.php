<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Observers\DepartamentoObserver;


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
}
