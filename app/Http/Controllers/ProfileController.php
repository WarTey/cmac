<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('profiles')->where('email', Auth::user()->email)->first();
        if (count($user->profiles) == 0) {
            $this->initProfile($user->name, true, $user->id);
            $user = User::with('profiles')->where('email', Auth::user()->email)->first();
        }

        return Inertia::render('Profiles/Index', [
            'user' => $user
        ]);
    }

    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string'
        ]);

        $this->initProfile($request->post('name'), false, Auth::user()->id);

        return Redirect::route('profiles.index')->with('success', 'Profil en ligne.');
    }

    public function edit(Request $request) {
        $request->validate([
            'id' => 'required|integer|min:0',
            'name' => 'required|string'
        ]);

        $profile = Profile::where('id', $request->post('id'))->first();
        $profile->update([
            'name' => $request->post('name')
        ]);

        return Redirect::route('profiles.index')->with('success', 'Profil mis à jour.');
    }

    public function delete(Request $request) {
        $request->validate([
            'id' => 'required|integer|min:0'
        ]);

        Profile::where('id', $request->post('id'))->first()->delete();

        return Redirect::route('profiles.index')->with('success', 'Profil supprimé.');
    }

    public function select(Request $request) {
        $request->validate([
            'id' => 'required|integer|min:0'
        ]);

        $this->resetActiveProfiles();
        $profile = Profile::where('id', $request->post('id'))->first();
        $profile->update([
            'active' => true
        ]);

        return Redirect::route('levels.index');
    }

    private function resetActiveProfiles() {
        $profiles = Profile::where('user_id', Auth::user()->id)->get();
        foreach ($profiles as $profile) {
            $profile->update([
                'active' => false
            ]);
        }
    }

    private function initProfile($name, $active, $userId) {
        $profile = new Profile();
        $profile->name = $name;
        $profile->active = $active;
        $profile->user_id = $userId;
        $profile->save();
    }
}
