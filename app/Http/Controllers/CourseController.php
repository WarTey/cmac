<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:levels|max:100',
            'description' => 'nullable|max:2048',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'chapter_uuid' => 'required'
        ]);

        $course = new Course();
        $course->title = $request->post('title');
        $course->description = $request->post('description');
        $course->chapter_id = Chapter::where('uuid', $request->post('chapter_uuid'))->first()->id;

        if ($request->file('image'))
        {
            $path = $request->file('image')->store('public/img/courses');

            $course->image = basename($path);
        }

        $course->save();

        return Redirect::route('courses.index', ['uuid' => $request->post('chapter_uuid')])->with('success', 'Cours en ligne.');
    }
}
