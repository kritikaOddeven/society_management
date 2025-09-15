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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tower_id')->constrained('towers')->onDelete('cascade');
            $table->foreignId('floor_id')->constrained('floors')->onDelete('cascade');
            $table->foreignId('apartment_id')->constrained('apartments')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->string('tenant_name');
            $table->year('rent_year');
            $table->enum('rent_month', [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ]);
            $table->decimal('rent_amount', 10, 2);
            $table->enum('status', ['Paid', 'Unpaid', 'Partial'])->default('Unpaid');
            $table->date('payment_date')->nullable();
            $table->string('payment_image')->nullable();
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate rent entries
            $table->unique(['apartment_id', 'tenant_id', 'rent_year', 'rent_month'], 'unique_rent_entry');
            
            // Add indexes for faster queries
            $table->index(['rent_year', 'rent_month']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};