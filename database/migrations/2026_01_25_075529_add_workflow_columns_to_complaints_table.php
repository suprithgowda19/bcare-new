<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Workflow Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('workflow_id')
                  ->nullable()
                  ->after('subcategory_id')
                  ->constrained()
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Current Step Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('current_step_id')
                  ->nullable()
                  ->after('workflow_id')
                  ->constrained('workflow_steps')
                  ->nullOnDelete();

            $table->index('workflow_id');
            $table->index('current_step_id');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {

            $table->dropForeign(['workflow_id']);
            $table->dropForeign(['current_step_id']);

            $table->dropIndex(['workflow_id']);
            $table->dropIndex(['current_step_id']);

            $table->dropColumn(['workflow_id', 'current_step_id']);
        });
    }
};
