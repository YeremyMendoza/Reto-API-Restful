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
        //
        Schema::table('departamentos', function (Blueprint $table) {
            $table->foreignId('encargado_id')->nullable()->unique()->constrained('empleados', 'empleado_id');
        });

        Schema::table('empleados', function (Blueprint $table) {
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos', 'departamento_id');
            $table->foreignId('encargado_id')->nullable()->constrained('empleados', 'empleado_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
