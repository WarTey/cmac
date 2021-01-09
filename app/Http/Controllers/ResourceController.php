<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ResourceController extends Controller
{
    public function store (Request $request)
    {
        // TODO : Change video format
        $request->validate([
            'descriptionStore' => 'nullable',
            'fileStore' => 'nullable|file|mimes:pdf|max:2048',
            'videoStore' => 'nullable|file|mimetypes:video/quicktime|max:2048',
            'positionStore' => 'required|integer|min:0',
            'contentUuid' => 'required',
            'courseUuid' => 'required'
        ]);

        $resource = new Resource();
        $resource->description = $request->post('descriptionStore');
        $resource->position = $request->post('positionStore');
        $resource->content_id = Content::where('uuid', $request->post('contentUuid'))->first()->id;

        if ($request->file('fileStore'))
        {
            $path = $request->file('fileStore')->store('public/files');

            $resource->file = basename($path);
        }

        if ($request->file('videoStore'))
        {
            $path = $request->file('videoStore')->store('public/videos');

            $resource->video = basename($path);
        }

        $resource->save();

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('successStore', 'Ressource en ligne.');
    }
}
