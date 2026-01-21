<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Standard Profile Fields
            $table->string('phone')->unique()->after('email');
            
            // Administrative Relationships
            // We use unsignedBigInteger first to ensure compatibility before adding the constraint
            $table->unsignedBigInteger('category_id')->after('password');
            $table->unsignedBigInteger('sub_category_id')->nullable()->after('category_id');
            
            // Geographical Fields
            $table->string('zone')->after('sub_category_id');
            $table->string('constituency')->after('zone');
            $table->json('wards')->after('constituency'); // For multiple selections
            
            $table->enum('status', ['active', 'inactive'])->default('active')->after('wards');

            // Adding Foreign Key Constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);
            
            // Drop columns
            $table->dropColumn([
                'phone', 
                'category_id', 
                'sub_category_id', 
                'zone', 
                'constituency', 
                'wards', 
                'status'
            ]);
        });
    }
};