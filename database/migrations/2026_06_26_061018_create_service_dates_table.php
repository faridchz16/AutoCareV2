<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')
                ->constrained('service_types')
                ->restrictOnDelete();

            $table->date('available_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('capacity')->default(1);
            $table->string('status')->default('disponible');
            $table->timestamps();

            $table->unique(['service_type_id', 'available_date', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_dates');
    }
};