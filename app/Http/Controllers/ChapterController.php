<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChapterController extends Controller
{
    public function index(string $uuid)
    {
        $level = Level::where('uuid', $uuid)->first();

        $chapters = Chapter::where('level_id', $level->id)->withCount('courses')->get();

        return Inertia::render('Chapters/Index', [
            'chapters' => $chapters,
            'level' => $level
        ]);
    }
}
