@extends('layouts.home')

@section('noi-dung')
<h1>Chi tiết suất chiếu</h1>

<h2>Phim: {{ $showtime->movie->title }}</h2>
<p>Rạp: {{ $showtime->cinema_room->cinema->name }}</p>
<p>Ngày: {{ $showtime->start_date }}</p>
<p>Giờ: {{ $showtime->start_time }}</p>

<h3>Danh sách ghế:</h3>
<ul>
    @foreach ($showtime->cinema_room->seat as $seat)
        <li>{{ $seat->seat_name }} - {{ $seat->seat_type->name }}</li>
    @endforeach
</ul>
@endsection
