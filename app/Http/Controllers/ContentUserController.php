<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContentUserController extends Controller
{
    public function edit(Request $request)
    {
        $request->validate([
            'contentUuid' => 'required|string'
        ]);

        $content = Content::where('uuid', $request->post('contentUuid'))->first();
        $profile = Profile::where('user_id', auth()->user()->id)->where('active', true)->first();

        $content->profiles()->attach($profile);

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')])->with('toast', 'Félicitation!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'contentUuid' => 'required|string'
        ]);

        $content = Content::where('uuid', $request->post('contentUuid'))->first();
        $profile = Profile::where('user_id', auth()->user()->id)->where('active', true)->first();

        $content->profiles()->detach($profile);

        return Redirect::route('contents.index', ['uuid' => $request->post('courseUuid')]);
    }
}
