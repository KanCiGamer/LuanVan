<?php

namespace App\Http\Controllers;

use App\Models\movie;
use App\Models\Categories;
use App\Models\Age_rating;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::with('categories')->get();
        $categories = Categories::all();
        $age_rating = Age_rating::all();
        return view('layouts.admin.movie', compact('movies', 'categories', 'age_rating'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Request data:', $request->all());
        $imagePath = $request->file('poster');
        $imageName = $imagePath->getClientOriginalName();
        $imagePath->move('images', $imageName);
        //$imageName = basename($imagePath);
        $movie = new movie();
        $movie->movie_id = Str::uuid();
        $movie->movie_name = $request->movie_name;
        $movie->nation = $request->nation;
        $movie->directors = $request->directors;
        $movie->actor = $request->actor;
        $movie->language = $request->language;
        $movie->description = $request->description;
        $movie->poster = $imageName;
        $movie->trailer_link = $request->trailer_link;
        $movie->time = $request->time;
        $movie->price = $request->price;
        $movie->status = $request->status;
        $movie->age_rating_id = $request->age_rating_id;
        $movie->save();
        if ($request->has('categories')) {
            $movie->categories()->attach($request->categories);
        }
        //$movie->categories()->attach($request->input('categories', []));


        return redirect()->back()->with('success', 'Phim đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return response()->json($movie);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $movie = movie::find($id);
        if($movie)
        {
            $movie->movie_name = $request->movie_name;
            $movie->nation = $request->nation;
            $movie->directors = $request->directors;
            $movie->actor = $request->actor;
            $movie->language = $request->language;
            $movie->description = $request->description;

            if ($request->hasFile('poster')) {
                $imagePath = $request->file('poster');
                $imageName = $imagePath->getClientOriginalName();
                $imagePath->move('images', $imageName);
                $movie->poster = $imageName;
            }
            
            $movie->trailer_link = $request->trailer_link;
            $movie->time = $request->time;
            $movie->price = $request->price;
            $movie->status = $request->status;
            $movie->age_rating_id = $request->age_rating_id;
            $movie->save();
            $movie->categories()->detach();
            if ($request->has('categories')) {
                $movie->categories()->attach($request->categories);
            }
            return redirect()->back()->with('success', 'Phim đã được cập nhật thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Phim không tồn tại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if($movie)
        {
            $movie->delete();
            return redirect()->back()->with('success', 'Phim đã được xóa thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Phim không tồn tại!');
        }
    }
}
