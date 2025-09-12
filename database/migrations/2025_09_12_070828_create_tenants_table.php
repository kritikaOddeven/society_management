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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('country_code', 10)->default('+91');
            $table->string('profile_image')->nullable();
            $table->foreignId('apartment_id')->nullable()->constrained('apartments')->onDelete('cascade');
            $table->enum('bill_cycle', ['monthly', 'annually'])->default('monthly');
            $table->decimal('rent_amount', 10, 2);
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
