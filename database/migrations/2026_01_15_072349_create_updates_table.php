<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('updates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('tag_name')->nullable(); // e.g., "Trending", "Announcement"
            $table->string('about')->nullable();    // Short summary
            $table->text('content');                // Detailed body
            $table->string('image');                // File path
            
            // Enum for strict status control
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('updates');
    }
};