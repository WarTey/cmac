<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index(string $uuid)
    {
        $chapter = Chapter::where('uuid', $uuid)->first();

        $courses = Course::where('chapter_id', $chapter->id)->withCount('contents')->get();

        $level = Level::where('id', $chapter->level_id)->first();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'chapter' => $chapter,
            'level' => $level
        ]);
    }
}
