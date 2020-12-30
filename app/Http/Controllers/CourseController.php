<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
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
            'titleStore' => 'required|unique:courses|max:100',
            'descriptionStore' => 'nullable|max:2048',
            'imageStore' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'chapterUuid' => 'required'
        ]);

        $course = new Course();
        $course->title = $request->post('titleStore');
        $course->description = $request->post('descriptionStore');
        $course->chapter_id = Chapter::where('uuid', $request->post('chapterUuid'))->first()->id;

        if ($request->file('imageStore'))
        {
            $path = $request->file('imageStore')->store('public/img/courses');

            $course->image = basename($path);
        }

        $course->save();

        return Redirect::route('courses.index', ['uuid' => $request->post('chapterUuid')])->with('success', 'Cours en ligne.');
    }

    public function edit(Request $request) {
        $request->validate([
            'uuid' => 'required',
            'titleEdit' => [
                'required',
                Rule::unique('courses', 'title')->ignore($request->post('uuid'), 'uuid'),
                'max:100'
            ],
            'descriptionEdit' => 'nullable|max:2048',
            'chapterUuid' => 'required'
        ]);

        $course = Course::where('uuid', $request->post('uuid'))->first();

        if ($request->file('imageEdit'))
        {
            $request->validate([
                'imageEdit' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]);

            $path = $request->file('imageEdit')->store('public/img/courses');

            $course->update([
                'image' => basename($path)
            ]);
        }
        else if ($request->post('imageEdit') == null)
        {
            $course->update([
                'image' => null
            ]);
        }

        $course->update([
            'title' => $request->post('titleEdit'),
            'description' => $request->post('descriptionEdit')
        ]);

        return Redirect::route('courses.index', ['uuid' => $request->post('chapterUuid')])->with('successEdit', 'Cours en ligne.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'chapterUuid' => 'required'
        ]);

        Course::where('uuid', $request->post('uuid'))->first()->delete();

        return Redirect::route('courses.index', ['uuid' => $request->post('chapterUuid')])->with('toast', 'Cours supprimé.');
    }
}
