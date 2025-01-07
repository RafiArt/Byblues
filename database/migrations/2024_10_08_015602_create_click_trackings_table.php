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
        Schema::create('click_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('links')->onDelete('cascade');
            $table->string('ip_address');
            $table->string('device_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('click_trackings');
    }
};
