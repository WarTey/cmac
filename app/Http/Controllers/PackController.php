<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:packs,title|max:100',
            'description' => 'nullable|max:2048',
            'position' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'priceThree' => 'required|numeric|min:0',
            'priceSix' => 'required|numeric|min:0',
            'visibility' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'courses' => 'nullable',
            'chapter' => 'required'
        ]);

        if ($validator->fails()) {
            return ['errors' => $request->post('courses')];
        }

        $pack = new Pack();
        $pack->title = $request->post('title');
        $pack->description = $request->post('description');
        $pack->position = $request->post('position');
        $pack->price = $request->post('price');
        $pack->price_three_months = $request->post('priceThree');
        $pack->price_six_months = $request->post('priceSix');
        if ($request->post('visibility'))
        {
            $pack->visible = $request->post('visibility');
        }
        $pack->chapter_id = Chapter::where('uuid', $request->post('chapter'))->first()->id;

        if ($request->file('image'))
        {
            $path = $request->file('image')->store('public/img/packs');

            $pack->image = basename($path);
        }

        $pack->save();

        foreach ($request->post('courses') as $elem) {
            $course = Course::where('uuid', $elem)->first();
            $pack->courses()->attach($course);
        }

        return ['success' => true, "test" => $request->post('courses')];
    }
}
