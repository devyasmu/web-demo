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
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'content')) {
                $table->longText('content')->nullable()->after('description');
            }
            if (!Schema::hasColumn('galleries', 'event_date')) {
                $table->date('event_date')->nullable()->after('content');
            }
            if (!Schema::hasColumn('galleries', 'location')) {
                $table->string('location')->nullable()->after('event_date');
            }
            if (!Schema::hasColumn('galleries', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('location');
            }
            if (!Schema::hasColumn('galleries', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'featured_image')) {
                $table->dropColumn('featured_image');
            }
            if (Schema::hasColumn('galleries', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
            if (Schema::hasColumn('galleries', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('galleries', 'event_date')) {
                $table->dropColumn('event_date');
            }
            if (Schema::hasColumn('galleries', 'content')) {
                $table->dropColumn('content');
            }
        });
    }
};


