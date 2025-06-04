<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('empleado_id');
            $table->string('nombre', 50);
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            $table->char('carnet_identidad', 15)->unique();
            $table->date('fecha_nacimiento');
            $table->string('pais', 50);
            $table->string('departamento', 50);
            $table->string('ciudad', 50);
            $table->string('zona', 50);
            $table->string('calle', 100);
            $table->string('numero_puerta', 10);
            $table->string('email', 100);
            $table->char('numero_celular', 15);
            $table->date('fecha_contratacion');
            $table->decimal('salario', 10, 2);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
