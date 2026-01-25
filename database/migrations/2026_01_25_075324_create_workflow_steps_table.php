<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_steps', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Parent Workflow
            |--------------------------------------------------------------------------
            */

            $table->foreignId('workflow_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Step Order
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('step_number');

            /*
            |--------------------------------------------------------------------------
            | Responsible Designation
            |--------------------------------------------------------------------------
            */

            $table->foreignId('designation_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | SLA Control (Hours)
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('sla_hours')->default(24);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Constraints
            |--------------------------------------------------------------------------
            */

            // No duplicate step number in same workflow
            $table->unique(['workflow_id', 'step_number']);

            // No duplicate designation in same workflow
            $table->unique(['workflow_id', 'designation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_steps');
    }
};
