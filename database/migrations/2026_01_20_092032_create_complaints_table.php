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

  
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->foreignId('subcategory_id')
                  ->constrained('sub_categories')
                  ->onDelete('cascade');

            // Form Data
            $table->string('subject');
            $table->text('message');
            $table->text('address');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');

            // Geolocation
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            // Media & Tracking
            $table->json('images')->nullable(); 
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};