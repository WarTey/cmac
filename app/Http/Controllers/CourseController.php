<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index(int $id)
    {
        $courses = Course::where('chapter_id', $id)->withCount('contents')->get();

        $chapter = Chapter::where('id', $courses[0]->chapter_id)->first();

        $level = Level::where('id', $chapter->level_id)->first();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'chapter' => $chapter,
            'level' => $level
        ]);
    }
}
