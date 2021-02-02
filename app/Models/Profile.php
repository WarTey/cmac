<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $hidden = ['user_id'];

    protected $fillable = ['name', 'image', 'active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
