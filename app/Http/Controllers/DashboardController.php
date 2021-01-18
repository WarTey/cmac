<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index');
    }

    /*public function logs(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $data = Log::select('description', 'user_id', 'created_at')->orderBy('created_at', 'desc')->with('user', function ($query, $sortBy, $orderBy) {
            $query->select('id', 'name', 'email')->orderBy($sortBy, $orderBy)->first();
        })->paginate($length);

        return new DataTableCollectionResource($data);
    }*/
}
