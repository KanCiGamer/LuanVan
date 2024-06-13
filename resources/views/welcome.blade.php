@extends('layouts.home')

{{-- @section('noi-dung')
    <div class="container">
        <div class="banner">
            <div style="width: 85%; background-color: #FF9F66; height: 360px; margin: auto; position: relative;">
                <h1 style="text-align:center; position:absolute; top: 50%; left: 50%;transform: translate(-50%, -50%);">
                    BANNER</h1>
            </div>
        </div>
        <div class="content" style="text-align: center; margin-top: 30px; margin-bottom: 20px;">
            <h2>PHIM ĐANG HOT</h2>
            <div style="margin-top: 20px; display: flex; justify-content:space-around;">
                <div style="width: 20%; background-color: #FF9F66;height: 360px;"></div>
                <div style="width: 20%; background-color: #FF9F66; height: 360px;"></div>
                <div style="width: 20%; background-color: #FF9F66; height: 360px;"></div>
            </div>
        </div>
    </div>
@endsection --}}

@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <div class="container">
        <div class="banner">
            <div style="width: 85%; background-color: #FF9F66; height: 360px; margin: auto; position: relative;">
                <h1 style="text-align:center; position:absolute; top: 50%; left: 50%;transform: translate(-50%, -50%);">
                    BANNER</h1>
            </div>
        </div>
        <div class="content" style="text-align: center; margin-top: 30px; margin-bottom: 20px;">
            <h2>PHIM ĐANG HOT</h2>
            <div style="margin-top: 20px; display: flex; justify-content:space-around;">
                {{-- @foreach ($movies as $movie)
                    <div class="movie-container" style="width: 20%; background-color: #FF9F66; height: 360px;">
                        <img src="{{ asset('images/' . $movie->poster) }}" alt="{{ $movie->name }}"
                            style="width: 100%; height: px;">
                        <h3 class="movie-title">{{ $movie->movie_name }}</h3>
                        <!-- Hiển thị tên phim -->
                    </div>
                @endforeach --}}
                @foreach ($movies as $movie)
                    <a href="{{ route('MovieDetail', ['id' => $movie->movie_id]) }}" class="movie-link" >
                        <div class="movie-container" style="width: 100%; background-color: #FF9F66; height: 360px;">
                            <img src="{{ asset('images/' . $movie->poster) }}" alt="{{ $movie->name }}"
                                style="width: 100%; height: 360px;">
                            <h3 class="movie-title">{{ $movie->movie_name }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
