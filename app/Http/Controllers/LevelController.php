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
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $values = $request->all();

        if ($request->file('image'))
        {
            $path = $request->file('image')->store('public/img/levels');

            $values['image'] = $path;
        }

        Level::create($values);

        return Redirect::route('dashboard')->with('success', 'Formation en ligne.');
    }
}
