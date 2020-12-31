<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Content extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $fillable = ['title', 'description'];

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

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
