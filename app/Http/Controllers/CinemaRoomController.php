<?php

namespace App\Http\Controllers;

use App\Models\cinema_room;
use App\Models\cinema;
use Illuminate\Http\Request;

class CinemaRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemaroom = cinema_room::all();
        $cinemas = cinema::all();
        return view('layouts.admin.cinema_room', compact('cinemaroom','cinemas'));
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
        $cinema_room = new cinema_room();
        $cinema_room->cinema_room_name = $request->cinema_room_name;
        $cinema_room->cinema_id = $request->cinema_id;
        $cinema_room->save();
        
        return redirect()->back()->with('success', 'Phòng chiếu đã được thêm thành công!');

    }

    /**
     * Display the specified resource.
     */
    public function show(cinema_room $cinema_room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cinema_room $cinema_room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cinema_room = cinema_room::find($id);
        if($cinema_room)
        {
            $cinema_room->cinema_room_name = $request->cinema_room_name;
            $cinema_room->cinema_id = $request->cinema_id;
            $cinema_room->save();
            return redirect()->back()->with('success', 'Phòng chiếu đã được cập nhật thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Phòng chiếu không tồn tại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cinema_room = cinema_room::find($id);
        if($cinema_room)
        {
            $cinema_room->delete();
            return redirect()->back()->with('success', 'Phòng chiếu đã được xóa thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Phòng chiếu không tồn tại!');
        }
    }
}
