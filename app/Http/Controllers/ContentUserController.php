<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContentUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'contentUuid' => 'required|string',
            'courseUuid' => 'required|string'
        ]);

        $content = Content::where('uuid', $request->post('contentUuid'))->first();
        $user = Content::where('id', auth()->user()->id)->first();

        $content->users()->attach($user);

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('toast', 'Félicitation!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'contentUuid' => 'required|string',
            'courseUuid' => 'required|string'
        ]);

        $content = Content::where('uuid', $request->post('contentUuid'))->first();
        $user = Content::where('id', auth()->user()->id)->first();

        $content->users()->detach($user);

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')]);
    }
}
