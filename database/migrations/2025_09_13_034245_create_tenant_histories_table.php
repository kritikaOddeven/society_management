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
        Schema::create('tenant_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('action'); // 'created', 'updated', 'deleted'
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('country_code', 10)->default('+91');
            $table->string('profile_image')->nullable();
            $table->foreignId('apartment_id')->nullable()->constrained('apartments')->onDelete('set null');
            $table->enum('bill_cycle', ['monthly', 'annually'])->nullable();
            $table->decimal('rent_amount', 10, 2)->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->boolean('status')->default(true);
            $table->json('changed_fields')->nullable(); // To track what fields were changed
            $table->unsignedBigInteger('changed_by')->nullable(); // User who made the change
            $table->timestamps();
            
            $table->index('tenant_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_histories');
    }
};