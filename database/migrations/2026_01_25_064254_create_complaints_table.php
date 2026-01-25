<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Ownership
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Classification & Location
            |--------------------------------------------------------------------------
            */
            $table->foreignId('ward_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('category_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('subcategory_id')
                  ->nullable()
                  ->constrained('sub_categories')
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Complaint Content
            |--------------------------------------------------------------------------
            */
            $table->string('subject');
            $table->text('message');
            $table->text('address')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])
                  ->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Geo Coordinates (Correct Numeric Type)
            |--------------------------------------------------------------------------
            */
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            /*
            |--------------------------------------------------------------------------
            | Attachments (MVP – JSON Storage)
            |--------------------------------------------------------------------------
            */
            $table->json('images')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Tracking
            |--------------------------------------------------------------------------
            */
            $table->enum('status', [
                'pending',
                'in_progress',
                'resolved',
                'rejected'
            ])->default('pending');

            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Performance Indexes (CRITICAL)
            |--------------------------------------------------------------------------
            */
            $table->index(['ward_id', 'status']);
            $table->index('category_id');
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
