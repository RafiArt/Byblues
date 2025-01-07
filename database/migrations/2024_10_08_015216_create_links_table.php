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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('original_url');
            $table->string('short_url')->unique();
            $table->string('password')->nullable();
            $table->timestamp('expiration_date')->nullable();
            $table->integer('clicks')->default(0);
            $table->boolean('active')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
