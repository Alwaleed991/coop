<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Report;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 10 Regular users
        $users = User::factory(10)->create();
        
        // Combine admin + users for posts/comments
        $allUsers = $users->push($admin);

        // 20 Tags
        $tags = Tag::factory(20)->create();

        // 25 Posts with GUARANTEED tags (1-5 per post)
        $posts = Post::factory(25)
            ->recycle($allUsers)
            ->create()
            ->each(function ($post) use ($tags) {
                // ALWAYS attach 1-5 random tags
                $randomTagCount = rand(1, 5);
                $post->tags()->attach(
                    $tags->random($randomTagCount)->pluck('id')
                );
            });

        // 100 Comments
        Comment::factory(100)
            ->recycle($allUsers)
            ->recycle($posts)
            ->create();

        // 10 Reports
        Report::factory(10)
            ->recycle($allUsers)
            ->create();
    }
}