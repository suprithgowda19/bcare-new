<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_updates', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Which Complaint
            |--------------------------------------------------------------------------
            */
            $table->foreignId('complaint_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('acted_by_user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | What Happened
            |--------------------------------------------------------------------------
            */
            $table->enum('action_type', [
                'comment',
                'status_change'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Status Tracking
            |--------------------------------------------------------------------------
            */
            $table->enum('old_status', [
                'pending',
                'in_progress',
                'resolved',
                'rejected'
            ])->nullable();

            $table->enum('new_status', [
                'pending',
                'in_progress',
                'resolved',
                'rejected'
            ])->nullable();

     
            $table->text('remarks')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Attachments (optional)
            |--------------------------------------------------------------------------
            */
            $table->json('images')->nullable();

        
            $table->boolean('is_public')->default(true);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes for timeline performance
            |--------------------------------------------------------------------------
            */
            $table->index('complaint_id');
            $table->index(['complaint_id', 'is_public']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_updates');
    }
};
