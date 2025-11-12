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
        Schema::create('common_area_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_type_id')->constrained('bill_types')->cascadeOnDelete();
            $table->decimal('bill_amount', 10, 2);
            $table->string('payment_mode', 50);
            $table->date('bill_date');
            $table->date('bill_due_date');
            $table->string('bill_image')->nullable();
            $table->string('status', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_area_bills');
    }
};
