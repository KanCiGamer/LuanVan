<?php

namespace App\Http\Controllers;

use App\Models\movie;
use App\Models\show_time;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $movies = movie::all();
        return view('welcome', compact('movies'));
    }
    public function MovieDetail($id)
    {
        //$movie = movie::with(['age_rating', 'categories', 'show_time'])->find($id);
        $movie = movie::with(['age_rating', 'categories', 'show_time.cinema_room.cinema'])->find($id);

        // Nếu không tìm thấy phim, trả về thông báo lỗi
        if (!$movie) {
            return redirect()->back()->with('error', 'Phim không tồn tại!');
        }
        // $showTimesGroupedByDate = $movie->show_time->groupBy(function ($date) {
        //     $parsedDate = \Carbon\Carbon::parse($date->start_date);
        //     $dayOfWeek = $parsedDate->format('l');
        //     $dayOfWeekInVietnamese = $this->getVietnameseDayOfWeek($dayOfWeek);
        //     $formattedDate = $parsedDate->format('d/m');
        //     return [
        //         'date' => $formattedDate,
        //         'day' => $dayOfWeekInVietnamese
        //     ];
        // });

        $showTimesGroupedByDate = $movie->show_time->groupBy(function ($date) {
            $parsedDate = \Carbon\Carbon::parse($date->start_date);
            return $parsedDate->format('d-m l'); // 'l' sẽ trả về thứ của ngày
        });

        //dd($showTimesGroupedByDate);
        // Trả về view với thông tin phim và các suất chiếu đã được nhóm
        return view('movie_detail', compact('movie', 'showTimesGroupedByDate'));
    }
    private function getVietnameseDayOfWeek($dayOfWeek)
    {
        $days = [
            'Monday' => 'Thứ Hai',
            'Tuesday' => 'Thứ Ba',
            'Wednesday' => 'Thứ Tư',
            'Thursday' => 'Thứ Năm',
            'Friday' => 'Thứ Sáu',
            'Saturday' => 'Thứ Bảy',
            'Sunday' => 'Chủ Nhật',
        ];

        return $days[$dayOfWeek] ?? $dayOfWeek;
    }

    // public function ShowTimeDetail($id)
    // {
    //     $showtime = show_time::with('cinema_room.seat.seat_type', 'movie')->find($id);
    //     //return view('showtime', compact('showtime'));
    //     if (!$showtime) {
    //         return response()->json(['error' => 'Suất chiếu không tồn tại!'], 404);
    //     }

    //     return response()->json($showtime);
    // }
    public function ShowTimeDetail($id)
{
    $showtime = show_time::with('cinema_room.seat.seat_type', 'movie')->find($id);

    if (!$showtime) {
        return response()->json(['error' => 'Suất chiếu không tồn tại!'], 404);
    }

    // Sắp xếp ghế theo tên ghế (đảm bảo tên ghế theo định dạng A1, A2, B1, ...)
    $showtime->cinema_room->seat = $showtime->cinema_room->seat->sortBy('seat_name'); 

    return response()->json($showtime);
}
}
