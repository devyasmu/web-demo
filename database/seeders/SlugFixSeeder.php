<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Announcement;
use App\Models\Post;
use App\Models\Program;
use App\Models\Gallery;

class SlugFixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fix Announcements
        $announcements = Announcement::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($announcements as $announcement) {
            $announcement->slug = Str::slug($announcement->title);
            $announcement->save();
            echo "Fixed announcement: {$announcement->title}\n";
        }

        // Fix Posts
        $posts = Post::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($posts as $post) {
            $post->slug = Str::slug($post->title);
            $post->save();
            echo "Fixed post: {$post->title}\n";
        }

        // Fix Programs
        $programs = Program::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($programs as $program) {
            $program->slug = Str::slug($program->title);
            $program->save();
            echo "Fixed program: {$program->title}\n";
        }

        // Fix Galleries
        $galleries = Gallery::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($galleries as $gallery) {
            $gallery->slug = Str::slug($gallery->title);
            $gallery->save();
            echo "Fixed gallery: {$gallery->title}\n";
        }

        echo "Slug fixing completed!\n";
    }
}