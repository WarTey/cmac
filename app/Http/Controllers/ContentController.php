<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
use App\Models\File;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index(string $uuid)
    {
        $course = Course::where('uuid', $uuid)->first();

        $contents = Content::where('course_id', $course->id)->with('files')->get();

        $chapter = Chapter::where('id', $course->chapter_id)->first();

        $level = Level::where('id', $chapter->level_id)->first();

        return Inertia::render('Contents/Index', [
            'contents' => $contents,
            'course' => $course,
            'chapter' => $chapter,
            'level' => $level
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:contents|max:100',
            'description' => 'nullable',
            'files.*' => 'nullable|file|mimes:pdf|max:2048',
            'courseUuid' => 'required'
        ]);

        $content = new Content();
        $content->title = $request->post('title');
        $content->description = $request->post('description');
        $content->course_id = Course::where('uuid', $request->post('courseUuid'))->first()->id;

        $content->save();

        if ($request->file()) {
            foreach ($request->file()["files"] as $file) {
                if ($file->getError() == 0) {
                    $path = $file->store('public/files');
                    $fileName = $file->getClientOriginalName();

                    $file = new File();
                    $file->title = basename($path);
                    $file->name = $fileName;
                    $file->content_id = Content::where('uuid', $content->uuid)->first()->id;

                    $file->save();
                }
            }
        }

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('success', 'Contenu en ligne.');
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
