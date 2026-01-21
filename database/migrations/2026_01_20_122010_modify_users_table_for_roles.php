<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change existing columns to nullable using the ->change() method
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('sub_category_id')->nullable()->change();
            $table->string('zone')->nullable()->change();
            $table->string('constituency')->nullable()->change();
            $table->json('wards')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // To roll back, we would theoretically make them required again
            // Note: This requires the 'doctrine/dbal' package in older Laravel versions
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->unsignedBigInteger('sub_category_id')->nullable(false)->change();
            $table->string('zone')->nullable(false)->change();
            $table->string('constituency')->nullable(false)->change();
            $table->json('wards')->nullable(false)->change();
        });
    }
};