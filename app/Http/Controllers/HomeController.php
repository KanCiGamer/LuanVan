<?php

namespace App\Http\Controllers;

use App\Models\discount_code;
use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\movie;
use App\Models\show_time;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        $movies = movie::all();
        return view('welcome', compact('movies'));
    }
    public function MovieDetail($id)
    {
        $movie = movie::with(['age_rating', 'categories', 'show_time.cinema_room.cinema'])->find($id);

        if (!$movie) {
            return redirect()->back()->with('error', 'Phim không tồn tại!');
        }
    
        $currentDate = Carbon::now();
        $futureShowTimes = $movie->show_time->where('start_date', '>=', $currentDate->toDateString());
        $showTimesGroupedByDate = $futureShowTimes->groupBy(function ($date) {
            $parsedDate = Carbon::parse($date->start_date);
            return $parsedDate->format('d-m l');
        })->toArray();
    
        uksort($showTimesGroupedByDate, function ($a, $b) {
            $dateA = Carbon::createFromFormat('d-m l', $a);
            $dateB = Carbon::createFromFormat('d-m l', $b);
    
            return $dateA->greaterThan($dateB) ? 1 : -1;
        });
    
        return view('movie_detail', compact('movie', 'showTimesGroupedByDate'));
    }
    public function ShowTimeDetail($id)
    {
        $showtime = show_time::with('cinema_room.seat.seat_type', 'movie')->find($id);

        if (!$showtime) {
            return response()->json(['error' => 'Suất chiếu không tồn tại!'], 404);
        }

        // Sắp xếp ghế theo tên ghế (đảm bảo tên ghế theo định dạng A1, A2, B1, ...)
        $showtime->cinema_room->seat = $showtime->cinema_room->seat->sortBy('seat_name');

        $soldSeats = invoice_detail::where('showtime_id', $id)
            ->pluck('seat_id') // Lấy ra chỉ cột 'seat_id'
            ->toArray();

        return response()->json([
            'showtime' => $showtime,
            'soldSeats' => $soldSeats,
        ]);
    }

    public function book_ticket(Request $request)
    {
        $validated = $request->validate([
            'showtime_id' => 'required|exists:show_times,showtime_id',
            'seats' => 'required|array',
            'seats.*' => 'exists:seats,seat_id'
        ]);
        session()->put('ticket', $validated);
        return response()->json(['success' => true]);

    }
    public function showPaymentPage()
    {
        $ticket = session()->get('ticket');
        if(!$ticket)
        {
            return redirect()->route('home')->with('error', 'No items in cart.');
        }
        return view('payment', ['ticket' => $ticket]);
    }
    public function payment(Request $request)
    {
        $ticket = session()->get('ticket');
        
        $validatedData = $request->validate([
            'email' => 'required|email',
            'discount_code' => 'nullable|exists:discount_codes,code'
        ]);
        $discountCodeId = null;
        if($validatedData['discount_code'])
        {
            $discountCode = discount_code::where('code',$validatedData['discount_code'])->first();
            if(!$discountCode)
            {   
                return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ.']);
            }
            $discountCodeId = $discountCode->id;
        }
        DB::beginTransaction();
    
        try {
            $invoiceId = Str::random(10);
            $email = $validatedData['email'];

            $invoice = Invoice::create([
                'invoice_id' => $invoiceId,
                'date_created' => now(),
                'status' => false,
                'email_kh' => $email,
                'user_id' => null,
                'discount_code_id' => $discountCodeId
            ]);
    
            foreach ($ticket['seats'] as $seatId) {
                invoice_detail::create([
                    'invoice_id' => $invoice->invoice_id,
                    'showtime_id' => $ticket['showtime_id'],
                    'seat_id' => $seatId,
                    'gia_tien' => 100000
                ]);
            }
            DB::commit();
    
            session()->forget('ticket');
    
            return response()->json(['success' => true, 'invoice_id' => $invoice->invoice_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
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
}
