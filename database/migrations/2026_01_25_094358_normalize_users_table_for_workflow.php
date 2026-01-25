<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | DROP category_id (if exists)
            |--------------------------------------------------------------------------
            */

            if (Schema::hasColumn('users', 'category_id')) {

                try {
                    $table->dropForeign(['category_id']);
                } catch (\Throwable $e) {
                    // Foreign key may not exist — ignore
                }

                $table->dropColumn('category_id');
            }

            /*
            |--------------------------------------------------------------------------
            | DROP sub_category_id (if exists)
            |--------------------------------------------------------------------------
            */

            if (Schema::hasColumn('users', 'sub_category_id')) {

                try {
                    $table->dropForeign(['sub_category_id']);
                } catch (\Throwable $e) {
                }

                $table->dropColumn('sub_category_id');
            }

            /*
            |--------------------------------------------------------------------------
            | DROP zone + constituency (if exist)
            |--------------------------------------------------------------------------
            */

            if (Schema::hasColumn('users', 'zone')) {
                $table->dropColumn('zone');
            }

            if (Schema::hasColumn('users', 'constituency')) {
                $table->dropColumn('constituency');
            }

            /*
            |--------------------------------------------------------------------------
            | ADD designation_id (if not exists)
            |--------------------------------------------------------------------------
            */

            if (!Schema::hasColumn('users', 'designation_id')) {

                $table->foreignId('designation_id')
                    ->nullable()
                    ->after('phone')
                    ->constrained('designations')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'designation_id')) {

                try {
                    $table->dropForeign(['designation_id']);
                } catch (\Throwable $e) {
                }

                $table->dropColumn('designation_id');
            }

            if (!Schema::hasColumn('users', 'category_id')) {
                $table->foreignId('category_id')->nullable();
            }

            if (!Schema::hasColumn('users', 'sub_category_id')) {
                $table->foreignId('sub_category_id')->nullable();
            }

            if (!Schema::hasColumn('users', 'zone')) {
                $table->string('zone')->nullable();
            }

            if (!Schema::hasColumn('users', 'constituency')) {
                $table->string('constituency')->nullable();
            }
        });
    }
};
