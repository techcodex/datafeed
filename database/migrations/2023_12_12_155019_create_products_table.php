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
            $table->unsignedBigInteger('entity_id');
            $table->string('sku');
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('shortdesc')->nullable();
            $table->double('price');
            $table->text('link')->nullable();
            $table->text('image')->nullable();
            $table->double('rating')->nullable();
            $table->string('caffine_type')->nullable();
            $table->integer('count')->default(0);
            $table->tinyInteger('flavored')->nullable();
            $table->tinyInteger('seasonal')->nullable();
            $table->tinyInteger('instock')->nullable();
            $table->tinyInteger('facebook')->nullable();
            $table->tinyInteger('is_k_cup')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            
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
