<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
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
            'titleStore' => 'required|unique:levels,title|max:100',
            'descriptionStore' => 'nullable|max:2048',
            'imageStore' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $level = new Level();
        $level->title = $request->post('titleStore');
        $level->description = $request->post('descriptionStore');

        if ($request->file('imageStore'))
        {
            $path = $request->file('imageStore')->store('public/img/levels');

            $level->image = basename($path);
        }

        $level->save();

        return Redirect::route('levels.index')->with('successStore', 'Formation en ligne.');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'titleEdit' => [
                'required',
                Rule::unique('levels', 'title')->ignore($request->post('uuid'), 'uuid'),
                'max:100'
            ],
            'descriptionEdit' => 'nullable|max:2048'
        ]);

        $level = Level::where('uuid', $request->post('uuid'))->first();

        if ($request->file('imageEdit'))
        {
            $request->validate([
                'imageEdit' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]);

            $path = $request->file('imageEdit')->store('public/img/levels');

            $level->update([
                'image' => basename($path)
            ]);
        }
        else if ($request->post('imageEdit') == null)
        {
            $level->update([
                'image' => null
            ]);
        }

        $level->update([
            'title' => $request->post('titleEdit'),
            'description' => $request->post('descriptionEdit')
        ]);

        return Redirect::route('levels.index')->with('successEdit', 'Formation modifiée.');
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
