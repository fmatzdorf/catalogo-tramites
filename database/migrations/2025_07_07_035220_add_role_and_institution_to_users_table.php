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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'institutional'])->default('institutional')->after('email');
            $table->foreignId('institution_id')->nullable()->after('role')->constrained('institutions')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->after('institution_id')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();

            // Indexes for better performance
            $table->index(['role']);
            $table->index(['institution_id']);
            $table->index(['created_by']);
            $table->index(['updated_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['institution_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropIndex(['role']);
            $table->dropIndex(['institution_id']);
            $table->dropIndex(['created_by']);
            $table->dropIndex(['updated_by']);
            $table->dropColumn(['role', 'institution_id', 'created_by', 'updated_by']);
        });
    }
};
