<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name');        
            $table->foreignId('category_id')
                  ->constrained()
                  ->restrictOnDelete();
            $table->foreignId('subcategory_id')
                  ->nullable()
                  ->constrained('sub_categories')
                  ->nullOnDelete();
            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Designations Within Same Domain
            |--------------------------------------------------------------------------
            | Allows:
            | Junior Engineer (Water)
            | Junior Engineer (Electricity)
            |
            | Prevents duplicate inside same category/subcategory.
            |--------------------------------------------------------------------------
            */
            $table->unique(['name', 'category_id', 'subcategory_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
