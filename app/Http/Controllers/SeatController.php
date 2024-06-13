<?php

namespace App\Http\Controllers;

use App\Models\seat;
use App\Models\seat_type;
use App\Models\cinema_room;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seat = seat::all();
        $seat_type = seat_type::all();
        $cinema_room = cinema_room::all();
        return view('layouts.admin.seat', compact('seat','seat_type','cinema_room'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seat = new seat();
        $seat->seat_name = $request->seat_name;
        $seat->seat_type_id = $request->seat_type_id;
        $seat->cinema_room_id = $request->cinema_room_id;
        $seat->save();

        return redirect()->back()->with('success', 'Ghế đã được thêm thành công!');

    }

    /**
     * Display the specified resource.
     */
    public function show(seat $seat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(seat $seat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $seat = seat::find($id);
        if($seat){
            $seat->seat_name = $request->seat_name;
            $seat->seat_type_id = $request->seat_type_id;
            $seat->cinema_room_id = $request->cinema_room_id;
            $seat->save();
            return redirect()->back()->with('success', 'Ghế đã được sửa thành công!');
            
        }
        else{
            return redirect()->back()->with('error', 'Không tìm thấy ghế!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $seat = seat::find($id);
        if($seat){
        $seat->delete();
        return redirect()->back()->with('success', 'Ghế đã được xóa thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Không tìm thấy ghế!');
        }
    }
}
