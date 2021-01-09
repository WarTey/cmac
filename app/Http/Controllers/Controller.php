<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sidebar()
    {
        return Level::select('id', 'uuid', 'title')->orderBy('position')->with('chapters', function ($query) {
            $query->select('id', 'uuid', 'title', 'level_id')->orderBy('position')->with('courses', function ($query) {
                $query->select('id', 'uuid', 'title', 'chapter_id')->orderBy('position')->with('contents', function ($query) {
                    $query->select('id', 'title', 'course_id')->orderBy('position');
                });
            });
        })->get();
    }
}
