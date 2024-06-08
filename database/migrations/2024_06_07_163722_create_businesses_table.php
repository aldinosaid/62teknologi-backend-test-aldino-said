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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('alias')->nullable();
            $table->string('name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('is_claimed')->nullable();
            $table->string('is_closed')->nullable();
            $table->string('url')->nullable();
            $table->string('phone')->nullable();
            $table->string('display_phone')->nullable();
            $table->integer('review_count')->nullable();
            $table->json('categories')->nullable();
            $table->decimal('rating')->default(0);
            $table->json('location')->nullable();
            $table->json('coordinates')->nullable();
            $table->json('photos')->nullable();
            $table->json('hours')->nullable();
            $table->string('price')->nullable();
            $table->json('transactions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
