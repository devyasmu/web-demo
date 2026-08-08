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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->morphs('likeable'); // likeable_id, likeable_type (untuk posts, announcements, dll)
            $table->string('user_ip')->nullable(); // IP address untuk tracking
            $table->string('user_agent')->nullable(); // User agent untuk tracking
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['likeable_id', 'likeable_type']);
            $table->index('user_ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
