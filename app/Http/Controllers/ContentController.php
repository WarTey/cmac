<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
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
            'title' => 'required|unique:levels|max:100',
            'description' => 'nullable',
            'course_uuid' => 'required'
        ]);

        $content = new Content();
        $content->title = $request->post('title');
        $content->description = $request->post('description');
        $content->course_id = Course::where('uuid', $request->post('course_uuid'))->first()->id;

        /*if ($request->file('image'))
        {
            $path = $request->file('image')->store('public/img/courses');

            $course->image = basename($path);
        }*/

        $content->save();

        return Redirect::route('contents.index', ['uuid' => $request->post('course_uuid')])->with('success', 'Contenu en ligne.');
    }
}
