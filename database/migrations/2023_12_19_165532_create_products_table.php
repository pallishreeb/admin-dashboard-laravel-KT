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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->string('productId')->unique();
            $table->foreignId('category_id')->constrained()->index();
            $table->foreignId('subcategory_id')->constrained()->index('products_subcategory_id_foreign');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('model')->nullable();
            $table->json('features')->nullable();
            $table->string('brand')->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('isDeleted')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('image')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
