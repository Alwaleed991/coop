<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    public function definition(): array
    {
        $reportableType = fake()->randomElement([Post::class, Comment::class]);
        
        return [
            'user_id' => User::factory(),
            'reportable_type' => $reportableType,
            'reportable_id' => $reportableType === Post::class 
                ? Post::factory() 
                : Comment::factory(),
            'category' => fake()->randomElement(['spam', 'offensive', 'harassment', 'misinformation', 'violence', 'other']),
            'reason' => fake()->sentence(),
            'status' => 'pending',
        ];
    }
}