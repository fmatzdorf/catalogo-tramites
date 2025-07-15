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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->text('requirements')->nullable();
            $table->string('cost')->nullable();
            $table->string('currency')->nullable();
            $table->string('response_time')->nullable();
            $table->string('result_type')->nullable();
            $table->string('url')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['title']);
            $table->index(['category_id']);
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
        Schema::dropIfExists('procedures');
    }
};
