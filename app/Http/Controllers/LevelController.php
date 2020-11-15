<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        $request->validate([
            'title' => 'required|unique:levels|max:50',
            'description' => 'max:255',
            'image' => 'max:50'
        ]);

        /*$level = new Level();
        $level->uuid = Str::uuid();
        $level->title = $request->post('title');
        $level->description = $request->post('description');
        $level->image = $request->post('image');
        $level->save();*/

        Level::create($request->all());

        return Redirect::route('dashboard')->with('success', 'Formation en ligne.');
    }
}
