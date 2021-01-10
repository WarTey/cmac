<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Content extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'course_id'];

    protected $fillable = ['title', 'position'];

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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->where('user_id', auth()->user()->id);
    }
}
