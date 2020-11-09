<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index(int $id)
    {
        $contents = Content::where('course_id', $id)->with('files')->get();

        $course = Course::where('id', $contents[0]->course_id)->first();

        $chapter = Chapter::where('id', $course->chapter_id)->first();

        return Inertia::render('Contents/Index', [
            'contents' => $contents,
            'course' => $course,
            'chapter' => $chapter
        ]);
    }
}
