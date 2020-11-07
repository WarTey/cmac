<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChapterController extends Controller
{
    public function index(int $id)
    {
        $chapters = Chapter::where('level_id', $id)->withCount('courses')->get();

        $level = Level::where('id', $chapters[0]->level_id)->first();

        return Inertia::render('Chapters/Index', [
            'chapters' => $chapters,
            'level' => $level
        ]);
    }
}
