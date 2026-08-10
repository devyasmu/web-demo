<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institution_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->default('bi bi-whatsapp');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $sitePhone = DB::table('site_settings')->value('phone');
        $now = now();
        $institutions = [
            ['name' => 'Yayasan', 'description' => 'Informasi umum dan kemitraan'],
            ['name' => 'MTs', 'description' => 'Informasi jenjang madrasah tsanawiyah'],
            ['name' => 'SMP', 'description' => 'Informasi jenjang sekolah menengah pertama'],
            ['name' => 'MA', 'description' => 'Informasi jenjang madrasah aliyah'],
            ['name' => 'SMA', 'description' => 'Informasi jenjang sekolah menengah atas'],
            ['name' => 'SMK', 'description' => 'Informasi jenjang sekolah menengah kejuruan'],
        ];

        foreach ($institutions as $index => $institution) {
            DB::table('institution_contacts')->insert([
                'name' => $institution['name'],
                'contact_person' => null,
                'phone' => $sitePhone,
                'description' => $institution['description'],
                'icon' => 'bi bi-whatsapp',
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_contacts');
    }
};
