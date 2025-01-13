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
        Schema::create('diagnosas', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->unsignedBigInteger('gejala_id'); // Foreign key ke tabel gejalas
            $table->string('hasil'); // Hasil diagnosis
            $table->float('cf_value'); // Nilai certainty factor
            $table->text('solusi'); // Solusi yang diberikan
            $table->date('tanggal');
            $table->timestamps(); // created_at dan updated_at

            // Constraint foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gejala_id')->references('id')->on('gejalas')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosas');
    }
};
