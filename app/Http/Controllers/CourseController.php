<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Level;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index(string $uuid)
    {
        $this->deleteUsersCourses();

        $chapter = Chapter::select('id', 'uuid', 'title', 'level_id')->where('uuid', $uuid)->first();

        $courses = Course::where('chapter_id', $chapter->id)->orderBy('position')->where('visible', true)->with('users', function ($query) {
            $query->where('user_id', Auth::user() != null ? Auth::user()->id : -1);
        })->withCount('contents')->get();

        if (count($courses) === 0 && Auth::user()->admin === 0) {
            return abort(404);
        }

        $level = Level::select('uuid', 'title')->where('id', $chapter->level_id)->first();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'chapter' => $chapter,
            'level' => $level,
            'sidebarItems' => $this->sidebar()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titleStore' => 'required|unique:courses,title|max:100',
            'descriptionStore' => 'nullable|max:2048',
            'positionStore' => 'required|integer|min:0',
            'priceStore' => 'required|numeric|min:0',
            'priceThreeStore' => 'required|numeric|min:0',
            'priceSixStore' => 'required|numeric|min:0',
            'visibilityStore' => 'nullable|boolean',
            'imageStore' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'chapterUuid' => 'required'
        ]);

        $course = new Course();
        $course->title = $request->post('titleStore');
        $course->description = $request->post('descriptionStore');
        $course->position = $request->post('positionStore');
        $course->price = $request->post('priceStore');
        $course->price_three_months = $request->post('priceThreeStore');
        $course->price_six_months = $request->post('priceSixStore');
        if ($request->post('visibilityStore'))
        {
            $course->visible = $request->post('visibilityStore');
        }
        $course->chapter_id = Chapter::where('uuid', $request->post('chapterUuid'))->first()->id;

        if ($request->file('imageStore'))
        {
            $path = $request->file('imageStore')->store('public/img/courses');

            $course->image = basename($path);
        }

        $course->save();

        return Redirect::route('courses.index', ['uuid' => $request->post('chapterUuid')])->with('successStore', 'Cours en ligne.');
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
            'positionEdit' => 'required|integer|min:0',
            'priceEdit' => 'required|numeric|min:0',
            'priceThreeEdit' => 'required|numeric|min:0',
            'priceSixEdit' => 'required|numeric|min:0',
            'visibilityEdit' => 'nullable|boolean',
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

        $course->position = $request->post('positionEdit');
        $course->price = $request->post('priceEdit');
        $course->price_three_months = $request->post('priceThreeEdit');
        $course->price_six_months = $request->post('priceSixEdit');
        if ($request->post('visibilityEdit'))
        {
            $course->visible = $request->post('visibilityEdit');
        }

        $course->update([
            'title' => $request->post('titleEdit'),
            'description' => $request->post('descriptionEdit')
        ]);

        return Redirect::route('courses.index', ['uuid' => $request->post('chapterUuid')])->with('successEdit', 'Cours mis à jour.');
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

    public function buy(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string',
            'chapterUuid' => 'required|string',
            'duration' => 'required|integer|min:1|max:6'
        ]);

        $course = Course::where('uuid', $request->post('uuid'))->first();
        $user = User::where('id', Auth::user()->id)->first();

        $course->users()->attach($user, [
            'validity_period' => Carbon::now()->addMonths($request->post('duration')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $chapter = Chapter::select('id', 'uuid', 'title', 'level_id')->where('uuid', $request->post('chapterUuid'))->first();
        $courses = Course::where('chapter_id', $chapter->id)->orderBy('position')->where('visible', true)->with('users', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->withCount('contents')->get();

        return [
            'success' => true,
            'courses' => $courses
        ];
    }
}
