<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes; //The SoftDeletes trait makes delete() soft delete instead of hard delete and this one sets deleted_at so they they work togther, and adds Adds restore() method and forceDelete(), So your existing destroy() method which calls $post->delete() now automatically becomes a soft delete — and you'll add a separate forceDelete endpoint for permanent deletion.


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
