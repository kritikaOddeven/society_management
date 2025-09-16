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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->enum('maintenance_type', ['fixed_value', 'unit_type'])->default('fixed_value');
            $table->string('apartment_type')->nullable();
            $table->decimal('annual_value', 10, 2)->nullable();
            $table->decimal('half_yearly_value', 10, 2)->nullable();
            $table->decimal('quarterly_value', 10, 2)->nullable();
            $table->decimal('monthly_value', 10, 2)->nullable();
            $table->string('unit_name')->nullable();
            $table->decimal('unit_value', 10, 2)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            
            $table->unique(['maintenance_type', 'apartment_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};