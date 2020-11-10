<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $fillable = ['title', 'description', 'image'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
