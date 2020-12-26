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
            'title' => 'required|unique:levels|max:100',
            'description' => 'nullable|max:2048',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $level = new Level();
        $level->title = $request->post('title');
        $level->description = $request->post('description');

        if ($request->file('image'))
        {
            $path = $request->file('image')->store('public/img/levels');

            $level->image = basename($path);
        }

        $level->save();

        return Redirect::route('levels.index')->with('success', 'Formation en ligne.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'uuid' => 'required'
        ]);

        Level::where('uuid', $request->post('uuid'))->first()->delete();

        return Redirect::route('levels.index')->with('toast', 'Formation supprimée.');
    }
}
