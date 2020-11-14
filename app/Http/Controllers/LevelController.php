<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::withCount('chapters')->get();

        return Inertia::render('Levels/Index', [
            'levels' => $levels
        ]);
    }

    public function store(Request $request)
    {
        $level = new Level();
        $level->uuid = Str::uuid();
        $level->title = $request->post('title');
        $level->description = $request->post('description');
        $level->image = $request->post('image');
        $level->save();

        return Level::withCount('chapters')->get();
    }
}
