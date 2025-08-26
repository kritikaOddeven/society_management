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
            $table->foreignId('apartment_id')->constrained('apartments')->onDelete('cascade');
            $table->string('parking_code');
            $table->foreignId('floor_id')->constrained('floors')->onDelete('cascade')->nullable();
            $table->timestamps();
        });

        Schema::create('apartments', function (Blueprint $table) {
            $table->foreignId('parking_id')->nullable()->constrained('parkings')->onDelete('set null')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkings');
        Schema::dropIfExists('apartments');
    }
};
