<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
