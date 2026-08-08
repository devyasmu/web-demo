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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable'); // commentable_id, commentable_type (untuk posts, announcements, dll)
            $table->string('name'); // Nama pengomentar
            $table->string('email'); // Email pengomentar
            $table->text('content'); // Isi komentar
            $table->string('user_ip')->nullable(); // IP address untuk tracking
            $table->string('user_agent')->nullable(); // User agent untuk tracking
            $table->boolean('is_approved')->default(true); // Status persetujuan komentar
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['commentable_id', 'commentable_type']);
            $table->index('is_approved');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
