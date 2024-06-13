<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{



    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $categories = Categories::all();
        return view('layouts.admin.categories', compact('categories'));
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
        $categories = new Categories();
        $categories->category_name = $request->category_name;
        $categories->save();

        return redirect()->back()->with('success', 'Thể loại đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Categories::find($id);
        if ($category) {
            $category->category_name = $request->category_name;
            $category->save();
            return redirect()->back()->with('success', 'Thể loại đã được sửa thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy thể loại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categories = Categories::find($id);
        if ($categories) {
            $categories->delete();
            return redirect()->back()->with('success', 'Thể loại đã được xóa thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy thể loại!');
        }
    }
}
