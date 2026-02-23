<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $tags = [
            'Laravel', 'PHP', 'Vue', 'JavaScript', 'React', 'TypeScript',
            'Python', 'Django', 'Ruby', 'Rails', 'Node.js', 'Express',
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Docker', 'AWS',
            'Backend', 'Frontend', 'DevOps', 'API', 'Testing', 'Security'
        ];
        
        return [
            'name' => fake()->unique()->randomElement($tags),
        ];
    }
}