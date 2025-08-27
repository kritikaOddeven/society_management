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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('country_code', 10)->default('+93');
            $table->string('profile_image')->nullable();
            $table->boolean('status')->default(true);
             $table->foreignId('tower_id')->nullable()->constrained('towers')->onDelete('cascade');
            $table->foreignId('floor_id')->nullable()->constrained('floors')->onDelete('cascade');
            $table->foreignId('apartment_id')->nullable()->constrained('apartments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
