<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::all();

        return Inertia::render('Levels/Index', [
            'levels' => $levels
        ]);
    }
}
