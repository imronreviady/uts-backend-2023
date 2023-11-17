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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(false);
            $table->string('author', 100)->nullable(false);
            $table->string('description', 100)->nullable(false);
            $table->text('content')->nullable(false);
            $table->string('url', 100)->nullable(false)->unique();
            $table->string('url_image', 100)->nullable(false);
            $table->timestamp('published_at')->nullable(true); // jika null maka belum dipublish
            $table->string('category')->nullable(false);
            $table->timestamps();

            // relation to category table
            $table->foreign('category')->references('slug')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
