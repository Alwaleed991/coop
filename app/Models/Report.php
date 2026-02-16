<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportable() // now this is means A Report belongs to something reportable (could be Post OR Comment)
    {
        return $this->morphTo();
    }
}
