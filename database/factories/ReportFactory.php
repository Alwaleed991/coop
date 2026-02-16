<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        // Randomly choose Post or Comment
        $reportableType = $this->faker->randomElement([Post::class, Comment::class]);
        
        // Get a random Post or Comment
        if ($reportableType === Post::class) {
            $reportable = Post::inRandomOrder()->first();
        } else { 
            $reportable = Comment::inRandomOrder()->first();
        }

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'reportable_type' => $reportableType,
            'reportable_id' => $reportable->id,
            'category' => $this->faker->randomElement([
                'spam',
                'offensive',
                'harassment',
                'misinformation',
                'violence',
                'other'
            ]),
            'reason' => $this->faker->sentence(10),
            'status' => 'pending',
        ];
    }
}