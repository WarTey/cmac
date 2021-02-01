<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ChapterController extends Controller
{
    public function index(string $uuid)
    {
        $level = Level::select('id', 'uuid', 'title')->where('uuid', $uuid)->first();

        $chapters = Chapter::where('level_id', $level->id)->orderBy('position')->withCount('courses')->get();

        if (count($chapters) === 0 && Auth::user()->admin === 0) {
            return abort(404);
        }

        return Inertia::render('Chapters/Index', [
            'chapters' => $chapters,
            'level' => $level,
            'sidebarItems' => $this->sidebar()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titleStore' => 'required|unique:chapters,title|max:100',
            'descriptionStore' => 'nullable|max:2048',
            'positionStore' => 'required|integer|min:0',
            'imageStore' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'levelUuid' => 'required'
        ]);

        $chapter = new Chapter();
        $chapter->title = $request->post('titleStore');
        $chapter->description = $request->post('descriptionStore');
        $chapter->position = $request->post('positionStore');
        $chapter->level_id = Level::where('uuid', $request->post('levelUuid'))->first()->id;

        if ($request->file('imageStore'))
        {
            $path = $request->file('imageStore')->store('public/img/chapters');

            $chapter->image = basename($path);
        }

        $chapter->save();

        return Redirect::route('chapters.index', ['uuid' => $request->post('levelUuid')])->with('successStore', 'Chapitre en ligne.');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'titleEdit' => [
                'required',
                Rule::unique('chapters', 'title')->ignore($request->post('uuid'), 'uuid'),
                'max:100'
            ],
            'descriptionEdit' => 'nullable|max:2048',
            'positionEdit' => 'required|integer|min:0',
            'levelUuid' => 'required'
        ]);

        $chapter = Chapter::where('uuid', $request->post('uuid'))->first();

        if ($request->file('imageEdit'))
        {
            $request->validate([
                'imageEdit' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]);

            $path = $request->file('imageEdit')->store('public/img/chapters');

            $chapter->update([
                'image' => basename($path)
            ]);
        }
        else if ($request->post('imageEdit') == null)
        {
            $chapter->update([
                'image' => null
            ]);
        }

        $chapter->position = $request->post('positionEdit');

        $chapter->update([
            'title' => $request->post('titleEdit'),
            'description' => $request->post('descriptionEdit')
        ]);

        return Redirect::route('chapters.index', ['uuid' => $request->post('levelUuid')])->with('successEdit', 'Chapitre mis à jour.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'levelUuid' => 'required'
        ]);

        Chapter::where('uuid', $request->post('uuid'))->first()->delete();

        return Redirect::route('chapters.index', ['uuid' => $request->post('levelUuid')])->with('toast', 'Chapitre supprimé.');
    }
}
