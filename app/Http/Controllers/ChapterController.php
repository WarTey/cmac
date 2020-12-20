<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ChapterController extends Controller
{
    public function index(string $uuid)
    {
        $level = Level::where('uuid', $uuid)->first();

        $chapters = Chapter::where('level_id', $level->id)->withCount('courses')->get();

        return Inertia::render('Chapters/Index', [
            'chapters' => $chapters,
            'level' => $level
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:chapters|max:100',
            'description' => 'nullable|max:2048',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'level_uuid' => 'required'
        ]);

        $chapter = new Chapter();
        $chapter->title = $request->post('title');
        $chapter->description = $request->post('description');
        $chapter->level_id = Level::where('uuid', $request->post('level_uuid'))->first()->id;

        if ($request->file('image'))
        {
            $path = $request->file('image')->store('public/img/chapters');

            $chapter->image = basename($path);
        }

        $chapter->save();

        return Redirect::route('chapters.index', ['uuid' => $request->post('level_uuid')])->with('success', 'Chapitre en ligne.');
    }
}
