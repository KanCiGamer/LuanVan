<?php

namespace App\Http\Controllers;

use App\Models\cinema;
use App\Models\cinema_room;
use App\Models\movie;
use App\Models\show_time;
use Illuminate\Http\Request;

class ShowTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showtimes = show_time::with('movie', 'cinema_room')->get();
        $movies = movie::all(); // Lấy tất cả phim từ database
        $cinema_rooms = cinema_room::all(); // Lấy tất cả phòng chiếu từ database
        $cinemas = cinema::all();
        return view('layouts.admin.show_time', compact('showtimes', 'movies', 'cinema_rooms', 'cinemas')); // 
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
        $show_time = new show_time();
        $show_time->movie_id = $request->movie_id;
        $show_time->cinema_room_id = $request->cinema_room_id;

        // $show_time->start_time = request('start_time');
        $show_time->start_date = $request->start_date;
        $show_time->start_time = $request->start_time;
        $show_time->save();

        return redirect()->back()->with('success', 'Suất chiếu đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(show_time $show_time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(show_time $show_time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $show_time = show_time::find($id);
        if ($show_time) {
            $show_time->movie_id = $request->movie_id;
            $show_time->cinema_room_id = $request->cinema_room_id;
            $show_time->start_date = $request->start_date;
            $show_time->start_time = $request->start_time;
            $show_time->save();
            return redirect()->back()->with('success', 'Suất chiếu đã được cập nhật thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy suất chiếu!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $show_time = show_time::find($id);
        if ($show_time) {
            $show_time->delete();
            return redirect()->back()->with('success', 'Suất chiếu đã được xóa thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy suất chiếu!');
        }
    }
    // public function getCinemaRooms($cinema_id)
    // {
    //     $cinema = Cinema::find($cinema_id);
    //     $cinema_rooms = $cinema->cinemaRooms()->pluck('cinema_room_name', 'cinema_room_id');
    //     return response()->json($cinema_rooms);
    // }
    public function getCinemaRooms($cinemaId)
    {
        $cinema_rooms = cinema_room::where('cinema_id', $cinemaId)->get();
        return response()->json($cinema_rooms);
    }
}
