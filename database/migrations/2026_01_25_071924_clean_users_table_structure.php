<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Drop foreign keys first
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);

            // Then drop columns
            $table->dropColumn(['category_id', 'sub_category_id']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories');
        });
    }
};
