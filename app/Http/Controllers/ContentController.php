<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index(string $uuid)
    {
        $course = Course::select('id', 'uuid', 'title', 'chapter_id')->where('uuid', $uuid)->where('visible', true)->first();

        if (!$course) {
            return abort(404);
        }

        $contents = Content::where('course_id', $course->id)->orderBy('position')->with('resources', function ($query) {
            $query->orderBy('position');
        })->withCount('profiles')->get();

        if (count($contents) === 0 && Auth::user()->admin === 0) {
            return abort(404);
        }

        $chapter = Chapter::select('uuid', 'title', 'level_id')->where('id', $course->chapter_id)->first();

        $level = Level::select('uuid', 'title')->where('id', $chapter->level_id)->first();

        return Inertia::render('Contents/Index', [
            'contents' => $contents,
            'course' => $course,
            'chapter' => $chapter,
            'level' => $level,
            'sidebarItems' => $this->sidebar()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titleStore' => 'required|unique:contents,title|max:100',
            'positionStore' => 'required|integer|min:0',
            'courseUuid' => 'required'
        ]);

        $content = new Content();
        $content->title = $request->post('titleStore');
        $content->position = $request->post('positionStore');
        $content->course_id = Course::where('uuid', $request->post('courseUuid'))->first()->id;

        $content->save();

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('successStore', 'Contenu en ligne.');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'titleEdit' => [
                'required',
                Rule::unique('contents', 'title')->ignore($request->post('uuid'), 'uuid'),
                'max:100'
            ],
            'positionEdit' => 'required|integer|min:0',
            'courseUuid' => 'required'
        ]);

        $content = Content::where('uuid', $request->post('uuid'))->first();

        $content->position = $request->post('positionEdit');

        $content->update([
            'title' => $request->post('titleEdit')
        ]);

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('successEdit', 'Contenu mis à jour.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'courseUuid' => 'required'
        ]);

        Content::where('uuid', $request->post('uuid'))->first()->delete();

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('toast', 'Contenu supprimé.');
    }
}
