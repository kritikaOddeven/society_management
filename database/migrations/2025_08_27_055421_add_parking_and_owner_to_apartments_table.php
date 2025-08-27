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
        Schema::table('apartments', function (Blueprint $table) {
            $table->foreignId('owner_id')->nullable()->constrained('owners')->onDelete('set null')->after('status');

            
            $table->foreignId('parking_id')->nullable()->constrained('parkings')->onDelete('set null')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');

            $table->dropForeign(['parking_id']);
            $table->dropColumn('parking_id');
        });
    }
};
