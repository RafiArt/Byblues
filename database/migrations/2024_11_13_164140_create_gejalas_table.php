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
        Schema::create('gejalas', callback: function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->text('keterangan');
            $table->enum('kategori', [
                'Kesejahteraan Emosional',
                'Kesejahteraan Fisik',
                'Hubungan Sosial',
                'Peran dan Dukungan Keluarga'
            ]);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejalas');
    }
};
