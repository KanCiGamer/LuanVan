<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CinemaRoomController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SeatTypeController;
use App\Http\Controllers\ShowTimeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Models\Users;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/movie/{id}', [HomeController::class,'MovieDetail'])->name('MovieDetail');
Route::get('/showtimedetail/{id}', [HomeController::class,'ShowTimeDetail'])->name('ShowTimeSeat');

// trang đăng nhập/ đăng ký
Route::get('/login', function(){return view('./user/login');})->name('LoginPage');

// trang thông báo yêu cầu xác minh tài khoản
Route::get('/notify', function () {return view('./layouts/notify');})->name('VerifyNotify');
// chức năng đăng ký, đăng nhập và đăng xuất
Route::post('/register', [UsersController::class, 'register'])->name('UserRegister');
Route::post('/login', [UsersController::class, 'login'])->name('UserLogin');
Route::post('/logout', [UsersController::class, 'logout'])->name('UserLogout');



Route::get('/verify/{token}', function ($token) {
    $user = Users::where('verification_token', $token)->first();

    if ($user) {
        $user->verification = true;
        $user->save();

        return redirect()->route('UserLogin')->with('success', 'Xác minh tài khoản thành công!');
    } else {
        return redirect()->route('VerifyNotify')->with('error', 'Xác minh thất bại!');
    }
})->name('VerifyUser');




Route::get('/admin', function () {
    return view('./layouts/admin/home');
})->name('AdminPage');//->middleware('CheckUserRole');


 // categories
Route::get('/admin/categories',[CategoriesController::class, 'index'])->name('ShowCategories');
Route::post('/admin/categories', [CategoriesController::class, 'store'])->name('AddCategory');
Route::delete('/admin/categories/{id}', [CategoriesController::class, 'destroy'])->name('DeleteCategory');
Route::put('/admin/categories/{id}', [CategoriesController::class, 'update'])->name('UpdateCategory');

//cinema
Route::get('/admin/cinema',[CinemaController::class, 'index'])->name('ShowCinemas');
Route::post('/admin/cinema', [CinemaController::class, 'store'])->name('AddCinema');
Route::delete('/admin/cinema/{id}', [CinemaController::class, 'destroy'])->name('DeleteCinema');
Route::put('/admin/cinema/{id}', [CinemaController::class, 'update'])->name('UpdateCinema');

//cinema_room
Route::get('/admin/room',[CinemaRoomController::class, 'index'])->name('ShowCinemaRoom');
Route::post('/admin/room', [CinemaRoomController::class, 'store'])->name('AddCinemaRoom');
Route::delete('/admin/room/{id}', [CinemaRoomController::class, 'destroy'])->name('DeleteCinemaRoom');
Route::put('/admin/room/{id}', [CinemaRoomController::class, 'update'])->name('UpdateCinemaRoom');

//seat_type
Route::get('/admin/stype',[SeatTypeController::class, 'index'])->name('ShowSType');
Route::post('/admin/stype', [SeatTypeController::class, 'store'])->name('AddSType');
Route::delete('/admin/stype/{id}', [SeatTypeController::class, 'destroy'])->name('DeleteSType');
Route::put('/admin/stype/{id}', [SeatTypeController::class, 'update'])->name('UpdateSType');

//seat
Route::get('/admin/seat',[SeatController::class, 'index'])->name('ShowSeat');
Route::post('/admin/seat', [SeatController::class, 'store'])->name('AddSeat');
Route::delete('/admin/seat/{id}', [SeatController::class, 'destroy'])->name('DeleteSeat');
Route::put('/admin/seat/{id}', [SeatController::class, 'update'])->name('UpdateSeat');

//movie
Route::get('/admin/movies', [MovieController::class, 'index'])->name('ShowMovies');
Route::post('/admin/movies', [MovieController::class, 'store'])->name('AddMovie');
Route::get('/admin/movies/{id}', [MovieController::class, 'show'])->name('ShowMovie');
Route::put('/admin/movies/{id}', [MovieController::class, 'update'])->name('UpdateMovie');
Route::delete('/admin/movies/{id}', [MovieController::class, 'destroy'])->name('DeleteMovie');

//show_time
Route::get('/admin/stime',[ShowTimeController::class, 'index'])->name('ShowTime');
Route::post('/admin/stime', [ShowTimeController::class, 'store'])->name('AddSTime');
Route::delete('/admin/stime/{id}', [ShowTimeController::class, 'destroy'])->name('DeleteSTime');
Route::put('/admin/stime/{id}', [ShowTimeController::class, 'update'])->name('UpdateSTime');
Route::get('/get-cinema-rooms/{cinema_id}', [ShowtimeController::class, 'getCinemaRooms']);