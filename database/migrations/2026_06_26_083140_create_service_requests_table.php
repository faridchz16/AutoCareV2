<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('service_type_id')
                ->constrained('service_types')
                ->restrictOnDelete();

            $table->foreignId('service_date_id')
                ->constrained('service_dates')
                ->restrictOnDelete();

            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')
                ->restrictOnDelete();

            $table->foreignId('mechanic_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('vehicle_plate', 20);
            $table->string('vehicle_brand', 80);
            $table->string('vehicle_model', 80);
            $table->integer('vehicle_year')->nullable();
            $table->integer('current_mileage')->nullable();

            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->string('status')->default('pendiente');
            $table->boolean('mechanic_finished')->default(false);
            $table->boolean('admin_confirmed')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};