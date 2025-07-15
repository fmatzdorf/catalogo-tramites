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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('item_type'); // procedure, category, institution, user
            $table->unsignedBigInteger('item_id');
            $table->string('action'); // create, update, delete
            $table->json('item_data'); // serialized version of the item's data
            $table->timestamps();

            // Indexes for better performance
            $table->index(['user_id']);
            $table->index(['item_type']);
            $table->index(['item_id']);
            $table->index(['action']);
            $table->index(['created_at']);

            // Composite index for common queries
            $table->index(['item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
