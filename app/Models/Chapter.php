<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
