<?php

namespace App\Http\Controllers;

use App\Models\seat_type;
use Illuminate\Http\Request;

class SeatTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seat_types = seat_type::all();
        return view('layouts.admin.seat_type', compact('seat_types'));
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
        $seat_type = new seat_type();
        $seat_type->name = $request->seat_type_name;
        $seat_type->price = $request->seat_type_price;
        $seat_type->save();
        
        return redirect()->back()->with('success', 'Loại ghế đã được thêm thành công!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(seat_type $seat_type)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(seat_type $seat_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $seat_type = seat_type::find($id);
        if($seat_type)
        {
            $seat_type->name = $request->seat_type_name;
            $seat_type->price = $request->seat_type_price;
            $seat_type->save();
            return redirect()->back()->with('success', 'Loại ghế đã được cập nhật thành công!');
        }
        else
        {
            return redirect()->back()->with('error', 'Loại ghế không tồn tại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $seat_type = seat_type::find($id);
        if($seat_type)
        {
            $seat_type->delete();
            return redirect()->back()->with('success', 'Loại ghế đã được xóa thành công!');
        }
        else
        {
            return redirect()->back()->with('error', 'Loại ghế không tồn tại!');
        }
    }
}
