<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Pack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Yadahan\AuthenticationLog\AuthenticationLog;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index');
    }

    public function logs(Request $request) {
        $length = $request->input('length');
        $orderBy = $request->input('column');
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $logs = AuthenticationLog::join('users', 'users.id', '=', 'authentication_log.authenticatable_id')
            ->select('users.name', 'users.email', 'users.admin', 'authentication_log.ip_address', 'authentication_log.login_at')
            ->where('users.name', 'like', '%' . $searchValue . '%')
            ->orWhere('users.email', 'like', '%' . $searchValue . '%')
            ->orWhere('users.admin', 'like', '%' . $searchValue . '%')
            ->orWhere('authentication_log.ip_address', 'like', '%' . $searchValue . '%')
            ->orWhere('authentication_log.login_at', 'like', '%' . $searchValue . '%')
            ->orderBy($orderBy, $orderByDir)
            ->paginate($length);

        return new DataTableCollectionResource($logs);
    }

    public function users(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column');
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $users = User::select('name', 'email', 'admin')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('email', 'like', '%' . $searchValue . '%')
            ->orWhere('admin', 'like', '%' . $searchValue . '%')
            ->orderBy($orderBy, $orderByDir)
            ->paginate($length);

        return new DataTableCollectionResource($users);
    }

    public function userAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        if ($request->post('email') == Auth::user()->email)
        {
            return ['success' => false];
        }

        $user = User::where('email', $request->post('email'))->first();
        $user->admin = $user->admin == 1 ? 0 : 1;
        $user->save();

        return ['success' => true];
    }

    public function userDelete(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        if ($request->post('email') == Auth::user()->email)
        {
            return ['success' => false];
        }

        User::where('email', $request->post('email'))->first()->delete();

        return ['success' => true];
    }

    public function coursesTable(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column');
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $courses = Course::select('uuid', 'title', 'visible', 'price', 'price_three_months', 'price_six_months')
            ->where('title', 'like', '%' . $searchValue . '%')
            ->orWhere('price', 'like', '%' . $searchValue . '%')
            ->orWhere('price_three_months', 'like', '%' . $searchValue . '%')
            ->orWhere('price_six_months', 'like', '%' . $searchValue . '%')
            ->orderBy($orderBy, $orderByDir)
            ->paginate($length);

        return new DataTableCollectionResource($courses);
    }

    public function editCourse(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'price' => 'required|numeric|min:0',
            'price_three_months' => 'required|numeric|min:0',
            'price_six_months' => 'required|numeric|min:0',
            'visibility' => 'nullable|boolean',
        ]);

        $course = Course::where('uuid', $request->post('uuid'))->first();
        $course->price = $request->post('price');
        $course->price_three_months = $request->post('price_three_months');
        $course->price_six_months = $request->post('price_six_months');
        $course->visible = $request->post('visibility');
        $course->save();

        return ['success' => true];
    }

    public function editPack(Request $request)
    {
        $request->validate([
            'uuid' => 'required',
            'price' => 'required|numeric|min:0',
            'price_three_months' => 'required|numeric|min:0',
            'price_six_months' => 'required|numeric|min:0',
            'courses' => 'nullable',
            'visibility' => 'nullable|boolean',
        ]);

        $pack = Pack::where('uuid', $request->post('uuid'))->first();
        $pack->price = $request->post('price');
        $pack->price_three_months = $request->post('price_three_months');
        $pack->price_six_months = $request->post('price_six_months');
        $pack->visible = $request->post('visibility');
        $pack->save();

        $pack->courses()->detach();

        foreach ($request->post('courses') as $elem) {
            $course = Course::where('uuid', $elem)->first();
            $pack->courses()->attach($course);
        }

        return ['success' => true];
    }

    public function packsTable(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column');
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $packs = Pack::select('id', 'uuid', 'title', 'visible', 'price', 'price_three_months', 'price_six_months')
            ->where('title', 'like', '%' . $searchValue . '%')
            ->orWhere('price', 'like', '%' . $searchValue . '%')
            ->orWhere('price_three_months', 'like', '%' . $searchValue . '%')
            ->orWhere('price_six_months', 'like', '%' . $searchValue . '%')
            ->orderBy($orderBy, $orderByDir)
            ->with('courses', function ($query) {
                $query->select('id', 'title', 'uuid');
            })
            ->paginate($length);

        return new DataTableCollectionResource($packs);
    }

    public function chapters()
    {
        return Chapter::select('id', 'uuid', 'title')->get();
    }

    public function courses()
    {
        return Course::select('id', 'uuid', 'title')->get();
    }
}
