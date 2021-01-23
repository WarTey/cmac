<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ResourceController extends Controller
{
    public function store(Request $request)
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

        if ($request->post('optionStore')) {
            $this->editPosition($request->post('positionStore'), $request->post('optionStore'), $resource->uuid);
        }

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('successStore', 'Ressource en ligne.');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'courseUuid' => 'required'
        ]);

        Resource::where('uuid', $request->post('uuid'))->first()->delete();

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('toast', 'Ressource supprimée.');
    }

    public function edit(Request $request)
    {
        // TODO : Change video format
        $request->validate([
            'uuid' => 'required',
            'descriptionEdit' => 'nullable',
            'positionEdit' => 'required|integer|min:0',
            'courseUuid' => 'required'
        ]);

        $resource = Resource::where('uuid', $request->post('uuid'))->first();

        if ($request->post('optionEdit')) {
            $this->editPosition($request->post('positionEdit'), $request->post('optionEdit'), $resource->uuid);
        }

        if ($request->file('fileEdit'))
        {
            $request->validate([
                'fileEdit' => 'nullable|file|mimes:pdf|max:2048'
            ]);

            $path = $request->file('fileEdit')->store('public/files');

            $resource->update([
                'file' => basename($path)
            ]);
        }
        else if ($request->post('fileEdit') == null)
        {
            $resource->update([
                'file' => null
            ]);
        }

        if ($request->file('videoEdit'))
        {
            $request->validate([
                'videoEdit' => 'nullable|file|mimetypes:video/quicktime|max:2048'
            ]);

            $path = $request->file('videoEdit')->store('public/videos');

            $resource->update([
                'video' => basename($path)
            ]);
        }
        else if ($request->post('videoEdit') == null)
        {
            $resource->update([
                'video' => null
            ]);
        }

        $resource->update([
            'description' => $request->post('descriptionEdit'),
            'position' => $request->post('positionEdit')
        ]);

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('successEdit', 'Ressource mise à jour.');
    }

    public function editPosition($position, $option, $uuid) {
        if ($option == 1) {
            $element = Resource::where([
                ['uuid', '!=', $uuid],
                ['position', '=', $position],
            ])->first();
            if ($element) {
                $element->delete();
            }
        } else if ($option == 2) {
            $ressources = Resource::where([
                ['uuid', '!=', $uuid],
                ['position', '>=', $position],
            ])->get();
            foreach ($ressources as $element) {
                $element->update([
                    'position' => $element->position + 1
                ]);
            }
        }
    }
}
