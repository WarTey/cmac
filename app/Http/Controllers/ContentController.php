<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
use App\Models\File;
use App\Models\Level;
use App\Models\Progression;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index(string $uuid)
    {
        $course = Course::where('uuid', $uuid)->first();

        $contents = Content::where('course_id', $course->id)->orderBy('position')->with('files')->withCount('users')->get();

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
            'titleStore' => 'required|unique:contents,title|max:100',
            'descriptionStore' => 'nullable',
            'positionStore' => 'required|integer|min:0',
            'filesStore.*' => 'nullable|file|mimes:pdf|max:2048',
            'courseUuid' => 'required'
        ]);

        $content = new Content();
        $content->title = $request->post('titleStore');
        $content->description = $request->post('descriptionStore');
        $content->position = $request->post('positionStore');
        $content->course_id = Course::where('uuid', $request->post('courseUuid'))->first()->id;

        $content->save();

        if ($request->file())
        {
            foreach ($request->file()["filesStore"] as $file)
            {
                $this->uploadFile($file, $content->uuid);
            }
        }

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('successStore', 'Contenu en ligne.');
    }

    public function edit(Request $request) {
        $request->validate([
            'uuid' => 'required',
            'titleEdit' => [
                'required',
                Rule::unique('contents', 'title')->ignore($request->post('uuid'), 'uuid'),
                'max:100'
            ],
            'descriptionEdit' => 'nullable|max:2048',
            'positionEdit' => 'required|integer|min:0',
            'filesSave.*' => 'nullable|string',
            'filesAdd.*' => 'nullable|file|mimes:pdf|max:2048',
            'courseUuid' => 'required'
        ]);

        $content = Content::where('uuid', $request->post('uuid'))->first();

        if ($request->post('filesDel'))
        {
            foreach ($request->post('filesDel') as $file)
            {
                File::where('uuid', $file)->first()->delete();
            }
        }

        if ($request->file())
        {
            foreach ($request->file()["filesAdd"] as $file)
            {
                $this->uploadFile($file, $content->uuid);
            }
        }

        $content->position = $request->post('positionEdit');

        $content->update([
            'title' => $request->post('titleEdit'),
            'description' => $request->post('descriptionEdit')
        ]);

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('successEdit', 'Contenu en ligne.');
    }

    private function uploadFile(UploadedFile $file, string $uuid)
    {
        if ($file->getError() == 0)
        {
            $path = $file->store('public/files');
            $fileName = $file->getClientOriginalName();

            $file = new File();
            $file->title = basename($path);
            $file->name = $fileName;
            $file->content_id = Content::where('uuid', $uuid)->first()->id;

            $file->save();
        }
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
