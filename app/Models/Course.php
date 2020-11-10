<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
