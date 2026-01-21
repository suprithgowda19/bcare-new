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

            // Complaint being updated
            $table->foreignId('complaint_id')
                ->constrained('complaints')
                ->cascadeOnDelete();

            // Staff who performed the update
            $table->foreignId('staff_id')
                ->constrained('users')
                ->cascadeOnDelete();

           
            $table->string('status'); 
         

          
            $table->text('remarks');
            $table->json('images')->nullable();
            $table->timestamps();

            // For fast history lookups
            $table->index(['complaint_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_updates');
    }
};
