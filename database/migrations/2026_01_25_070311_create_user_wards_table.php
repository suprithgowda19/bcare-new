<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_wards', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | User ↔ Ward Pivot
            |--------------------------------------------------------------------------
            | This controls jurisdiction access.
            | Only users with role 'staff' should be assigned.
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('ward_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Composite Primary Key
            |--------------------------------------------------------------------------
            | Prevents duplicate ward assignments.
            |--------------------------------------------------------------------------
            */
            $table->primary(['user_id', 'ward_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_wards');
    }
};
