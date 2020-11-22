<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
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
}
