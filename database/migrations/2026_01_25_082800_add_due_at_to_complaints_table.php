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
            | SLA Deadline for Current Step
            |--------------------------------------------------------------------------
            | Stores expiration timestamp for current workflow step.
            | Indexed for scheduler efficiency.
            |--------------------------------------------------------------------------
            */

            $table->timestamp('due_at')
                  ->nullable()
                  ->after('current_step_id')
                  ->index();
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('due_at');
        });
    }
};
