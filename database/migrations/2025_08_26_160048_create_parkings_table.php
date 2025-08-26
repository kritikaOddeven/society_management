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
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->nullable()->constrained('apartments')->onDelete('set null');
            $table->string('parking_code')->unique();
            $table->foreignId('floor_id')->nullable()->constrained('floors')->onDelete('set null');
            $table->enum('status', ['Available', 'Occupied'])->default('Available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkings');
    }
};
