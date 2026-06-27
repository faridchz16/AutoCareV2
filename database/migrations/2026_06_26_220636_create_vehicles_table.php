<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('plate', 20)->unique();
            $table->string('brand', 80);
            $table->string('model', 80);
            $table->year('year')->nullable();
            $table->string('color', 50)->nullable();
            $table->integer('current_mileage')->nullable();
            $table->string('status')->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};