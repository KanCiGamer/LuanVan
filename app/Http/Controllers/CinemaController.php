<?php

namespace App\Http\Controllers;

use App\Models\cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemas = cinema::all();
        return view('layouts.admin.cinema', compact('cinemas'));
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
        $cinema = new cinema();
        $cinema->name = $request->cinema_name;
        $cinema->address = $request->cinema_address;
        $cinema->save();

        return redirect()->back()->with('success', 'Rạp đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(cinema $cinema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cinema $cinema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cinema = cinema::find($id);
        if($cinema)
        {
            $cinema->name = $request->cinema_name;
            $cinema->address = $request->cinema_address;
            $cinema->save();
            return redirect()->back()->with('success', 'Rạp đã được sửa thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Không tìm thấy rạp!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cinema = cinema::find($id);
        if($cinema)
        {
            $cinema->delete();
            return redirect()->back()->with('success', 'Rạp đã được xóa thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Không tìm thấy rạp!');
        }
    }
}
