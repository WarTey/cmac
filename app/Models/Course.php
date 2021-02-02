<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'chapter_id'];

    protected $fillable = ['title', 'description', 'image', 'position'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

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

    public function profiles()
    {
        return $this->belongsToMany(Profile::class)->where('user_id', auth()->user()->id)->where('active', true);
    }
}
