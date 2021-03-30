<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LevelController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Levels/Index', [
            'levels' => $this->get(),
            'sidebarItems' => $this->sidebar()
        ]);
    }

    public function get() {
        return Level::orderBy('position')->withCount('chapters as child_count')->get();
    }

    public function store(Request $request): array
    {
        $request->validate([
            'titleStore' => 'required|unique:levels,title|max:100',
            'descriptionStore' => 'nullable|max:2048',
            'positionStore' => 'required|integer|min:0',
            'imageStore' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $level = new Level();
        $level->title = $request->post('titleStore');
        $level->description = $request->post('descriptionStore');
        $level->position = $request->post('positionStore');

        if ($request->file('imageStore'))
        {
            $path = $request->file('imageStore')->store('public/img/levels');

            $level->image = basename($path);
        }

        $level->save();

        return ['success' => true, 'elements' => $this->get()];
    }

    public function edit(Request $request): array
    {
        $request->validate([
            'uuid' => 'required',
            'titleEdit' => [
                'required',
                Rule::unique('levels', 'title')->ignore($request->post('uuid'), 'uuid'),
                'max:100'
            ],
            'descriptionEdit' => 'nullable|max:2048',
            'positionEdit' => 'required|integer|min:0'
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

        $level->position = $request->post('positionEdit');

        $level->update([
            'title' => $request->post('titleEdit'),
            'description' => $request->post('descriptionEdit')
        ]);

        return ['success' => true, 'elements' => $this->get()];
    }

    public function delete(Request $request): array
    {
        $request->validate([
            'uuid' => 'required'
        ]);

        Level::where('uuid', $request->post('uuid'))->first()->delete();

        return ['success' => true, 'elements' => $this->get()];
    }
}
