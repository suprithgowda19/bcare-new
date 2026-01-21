<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
       
            $table->string('title');
            $table->text('content')->nullable(); // Text area for descriptions
            $table->string('image');             // Stores the file path
            
        
            $table->boolean('status')->default(true); // true = active, false = inactive
      
            
           
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};