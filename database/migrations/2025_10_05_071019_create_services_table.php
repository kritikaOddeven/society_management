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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id');
            $table->boolean('is_daily_help')->default(false);
            $table->unsignedBigInteger('tower_id')->nullable();
            $table->unsignedBigInteger('floor_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->string('contact_person_name');
            $table->string('contact_number');
            $table->string('country_code')->default('+1');
            $table->string('company_name')->nullable();
            $table->string('website_link')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->string('photo')->nullable();
            $table->timestamps();
            
            // Add foreign key constraints if these tables exist
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('tower_id')->references('id')->on('towers')->onDelete('set null');
            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('set null');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};