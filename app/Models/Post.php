<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function reports() //A Post can have MANY reports  --  sharif do you read this ??
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function attach_tags_to_post($name)
    {
        $tag = Tag::firstOrCreate([
            'name' => $name
        ]);
        $this->tags()->attach($tag);
    }

    public function attach_updated_tags_to_post($names)
    {
        $tags = [];  

        foreach ($names as $name) {
            $tags[] = Tag::firstOrCreate(['name' => $name]); //// dont forget this is appending so we need to difine it in the top 
        }

        $this->tags()->sync($tags); // sync will go to the pvot table and replace the old tags with the new one so its perfect for update
    }

}
