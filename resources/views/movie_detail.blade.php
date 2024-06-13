@extends('layouts.home')
@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/movie_detail.css') }}">
    <div class="container">
        <h1 class="mt-5">{{ $movie->movie_name }}</h1>

        <div class="row mt-4">
            <div class="col-md-4">
                <img src="{{ asset('images/' . $movie->poster) }}" alt="{{ $movie->movie_name }}" class="img-fluid">
            </div>
            <div class="col-md-8">
                <p><strong>Quốc gia:</strong> {{ $movie->nation }}</p>
                <p><strong>Đạo diễn:</strong> {{ $movie->directors }}</p>
                <p><strong>Diễn viên:</strong> {{ $movie->actor }}</p>
                <p><strong>Ngôn ngữ:</strong> {{ $movie->language }}</p>
                <p><strong>Thể loại:</strong>
                    @foreach ($movie->categories as $category)
                        {{ $category->category_name }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>
                <p><strong>Thời lượng:</strong> {{ $movie->time }} phút</p>
                <p><strong>Độ tuổi:</strong> {{ $movie->age_rating->description }}</p>
                <p><strong>Mô tả:</strong> {{ $movie->description }}</p>
                <p><strong>Trailer:</strong> <a href="{{ $movie->trailer_link }}"
                        target="_blank">{{ $movie->trailer_link }}</a></p>

            </div>
        </div>

        <h2 class="mt-5" style="text-align: center">Lịch chiếu</h2>

        <div class="row mt-3">
            @foreach ($showTimesGroupedByDate as $date => $showTimes)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $date }}</h5>
                            <p class="card-text">
                                <strong>Rạp phim:</strong> {{ $showTimes->first()->cinema_room->cinema->name }} <br>

                            <div id="showtime-list-{{ \Illuminate\Support\Str::slug($date) }}" class="showtime-list">
                                <!-- Suất chiếu sẽ được hiển thị ở đây -->
                            </div>
                            </p>
                            <button class="btn btn-primary select-showtime-btn" data-date="{{ $date }}"
                                data-showtimes="{{ json_encode($showTimes->map->only(['showtime_id', 'start_time'])->toArray()) }}"
                                data-target="#showtime-list-{{ \Illuminate\Support\Str::slug($date) }}">Chọn suất
                                chiếu</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Thêm phần tử để hiển thị chi tiết suất chiếu -->
        <div id="showtime-detail" class="mt-5"></div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const selectShowtimeButtons = document.querySelectorAll('.select-showtime-btn');

        //     selectShowtimeButtons.forEach(button => {
        //         button.addEventListener('click', function() {
        //             const date = this.getAttribute('data-date');
        //             const showtimes = JSON.parse(this.getAttribute('data-showtimes'));
        //             const target = this.getAttribute('data-target');

        //             let showtimeListHtml = ``;
        //             showtimes.forEach(showtime => {
        //                 showtimeListHtml += `<a href="#" class="showtime-link" data-id="${showtime.showtime_id}">${showtime.start_time}</a>`;
        //             });
        //             showtimeListHtml += '';

        //             document.querySelector(target).innerHTML = showtimeListHtml;

        //             // Thêm sự kiện click cho các liên kết suất chiếu
        //             document.querySelectorAll('.showtime-link').forEach(link => {
        //                 link.addEventListener('click', function(event) {
        //                     event.preventDefault();
        //                     const showtimeId = this.getAttribute('data-id');
        //                     fetch(`/showtimedetail/${showtimeId}`)
        //                         .then(response => response.json())
        //                         .then(data => {
        //                             if (data.error) {
        //                                 alert(data.error);
        //                                 return;
        //                             }
    //                             let detailHtml = `
    //                                 <h3>Chi tiết suất chiếu</h3>
    //                                 <h4>Phim: ${data.movie.movie_name}</h4>

    //                                 <p>Ngày: ${data.start_date}</p>
    //                                 <p>Giờ: ${data.start_time}</p>
    //                                 <h5>Danh sách ghế:</h5>
    //                                 <ul>
    //                             `;
    //                             data.cinema_room.seat.forEach(seat => {
    //                                 detailHtml += `<li>${seat.seat_name}</li>`;
    //                             });
    //                             detailHtml += `</ul>`;
    //                             document.querySelector('#showtime-detail').innerHTML = detailHtml;
    //                         })
    //                         .catch(error => {
    //                             console.error('Error:', error);
    //                         });
    //                 });
    //             });
    //         });
    //     });
    // });
        document.addEventListener('DOMContentLoaded', function() {
            const selectShowtimeButtons = document.querySelectorAll('.select-showtime-btn');

            selectShowtimeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const date = this.getAttribute('data-date');
                    const showtimes = JSON.parse(this.getAttribute('data-showtimes'));
                    const target = this.getAttribute('data-target');

                    let showtimeListHtml = ``;
                    showtimes.forEach(showtime => {
                        showtimeListHtml +=
                            `<a href="#" class="showtime-link" data-id="${showtime.showtime_id}">${showtime.start_time}</a>`;
                    });
                    showtimeListHtml += '';

                    document.querySelector(target).innerHTML = showtimeListHtml;

                    // Thêm sự kiện click cho các liên kết suất chiếu
                    document.querySelectorAll('.showtime-link').forEach(link => {
                        link.addEventListener('click', function(event) {
                            event.preventDefault();
                            const showtimeId = this.getAttribute('data-id');
                            fetch(`/showtimedetail/${showtimeId}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) {
                                        alert(data.error);
                                        return;
                                    }
                                    let detailHtml = `
                                    <h3>Chi tiết suất chiếu</h3>
                                    <h4>Phim: ${data.movie.movie_name}</h4>
                                    
                                    <p>Ngày: ${data.start_date}</p>
                                    <p>Giờ: ${data.start_time}</p>
                                    <h5>Danh sách ghế:</h5>
                                `;
                                    const rowMap =
                                        'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Dãy ký tự đại diện cho hàng ghế

                                    let currentRow = null;
                                    data.cinema_room.seat.forEach(seat => {
                                        const rowLetter = seat.seat_name
                                            .charAt(0);
                                        const colNumber = parseInt(seat
                                            .seat_name.slice(1));

                                        // Bắt đầu hàng mới nếu cần
                                        if (currentRow !== rowLetter) {
                                            if (currentRow !== null) {
                                                detailHtml += `</div>`;
                                            }
                                            detailHtml +=
                                                `<div class="seat-row">`;
                                            currentRow = rowLetter;
                                        }

                                        detailHtml +=
                                            `<div class="seat" data-seat-id="${seat.seat_id}">${seat.seat_name}</div>`;
                                    });

                                    if (currentRow !== null) {
                                        detailHtml += `</div>`;
                                    }

                                    detailHtml += `</div>`;
                                    document.querySelector('#showtime-detail')
                                        .innerHTML = detailHtml;
                                    const seats = document.querySelectorAll(
                                        '.seat');
                                    seats.forEach(seat => {
                                        seat.addEventListener('click',
                                            function() {
                                                // Kiểm tra xem ghế đã được chọn hay chưa
                                                const isSelected =
                                                    this.classList
                                                    .contains(
                                                        'selected');

                                                // Nếu ghế đã được chọn, bỏ chọn
                                                if (isSelected) {
                                                    this.classList
                                                        .remove(
                                                            'selected'
                                                            );
                                                } else {
                                                    // Nếu ghế chưa được chọn, thêm class 'selected'
                                                    this.classList
                                                        .add(
                                                            'selected'
                                                            );
                                                }
                                            });
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        });
                    });
                });
            });
        });
    </script>
@endsection
{{-- @section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/movie_detail.css') }}">
    <div class="container">
        <h1 class="mt-5">{{ $movie->movie_name }}</h1>

        <div class="row mt-4">
            <div class="col-md-4">
                <img src="{{ asset('images/' . $movie->poster) }}" alt="{{ $movie->movie_name }}" class="img-fluid">
            </div>
            <div class="col-md-8">
                <p><strong>Quốc gia:</strong> {{ $movie->nation }}</p>
                <p><strong>Đạo diễn:</strong> {{ $movie->directors }}</p>
                <p><strong>Diễn viên:</strong> {{ $movie->actor }}</p>
                <p><strong>Ngôn ngữ:</strong> {{ $movie->language }}</p>
                <p><strong>Thể loại:</strong>
                    @foreach ($movie->categories as $category)
                        {{ $category->category_name }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>
                <p><strong>Thời lượng:</strong> {{ $movie->time }} phút</p>
                <p><strong>Độ tuổi:</strong> {{ $movie->age_rating->description }}</p>
                <p><strong>Mô tả:</strong> {{ $movie->description }}</p>
                <p><strong>Trailer:</strong> <a href="{{ $movie->trailer_link }}"
                        target="_blank">{{ $movie->trailer_link }}</a></p>

                <!-- Thêm nút hoặc liên kết để đặt vé ở đây -->
                <a href="#" class="btn btn-primary">Đặt vé</a>
            </div>
        </div>

        <h2 class="mt-5">Lịch chiếu</h2>

        <div class="row mt-3">
            @foreach ($showTimesGroupedByDate as $date => $showTimes)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $date }}</h5>
                            <p class="card-text">
                                <strong>Rạp phim:</strong> {{ $showTimes->first()->cinema_room->cinema->name }} <br>

                            <div id="showtime-list-{{ \Illuminate\Support\Str::slug($date) }}" class="showtime-list">
                                <!-- Suất chiếu sẽ được hiển thị ở đây -->
                            </div>
                            </p>
                            <button class="btn btn-primary select-showtime-btn" data-date="{{ $date }}"
                                data-showtimes="{{ json_encode($showTimes->map->only(['showtime_id', 'start_time'])->toArray()) }}"
                                data-target="#showtime-list-{{ \Illuminate\Support\Str::slug($date) }}">Chọn suất
                                chiếu</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Thêm các liên kết JavaScript ở đây (ví dụ: Bootstrap, JavaScript tùy chỉnh) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const selectShowtimeButtons = document.querySelectorAll('.select-showtime-btn');

        //     selectShowtimeButtons.forEach(button => {
        //         button.addEventListener('click', function() {
        //             const date = this.getAttribute('data-date');
        //             const showtimes = JSON.parse(this.getAttribute('data-showtimes'));
        //             const target = this.getAttribute('data-target');

        //             let showtimeListHtml = `<ul>`;
        //             showtimes.forEach(showtime => {
        //                 showtimeListHtml +=
        //                     `<li><a href="/showtimedetail/${showtime.showtime_id}" target="_blank">${showtime.start_time}</a></li>`;
        //             });
        //             showtimeListHtml += '</ul>';

        //             document.querySelector(target).innerHTML = showtimeListHtml;
        //         });
        //     });
        // });
        document.addEventListener('DOMContentLoaded', function() {
    const selectShowtimeButtons = document.querySelectorAll('.select-showtime-btn');
    
    selectShowtimeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const date = this.getAttribute('data-date');
            const showtimes = JSON.parse(this.getAttribute('data-showtimes'));
            const target = this.getAttribute('data-target');
            
            let showtimeListHtml = `<ul>`;
            showtimes.forEach(showtime => {
                showtimeListHtml += `<li><a href="#" class="showtime-link" data-id="${showtime.showtime_id}">${new Date(showtime.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</a></li>`;
            });
            showtimeListHtml += '</ul>';
            
            document.querySelector(target).innerHTML = showtimeListHtml;

            // Thêm sự kiện click cho các liên kết suất chiếu
            document.querySelectorAll('.showtime-link').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const showtimeId = this.getAttribute('data-id');
                    fetch(`/showtimedetail/${showtimeId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }
                            let detailHtml = `
                                <h3>Chi tiết suất chiếu</h3>
                                <h4>Phim: ${data.movie.title}</h4>
                                <p>Rạp: ${data.cinema_room.cinema.name}</p>
                                <p>Ngày: ${data.start_date}</p>
                                <p>Giờ: ${data.start_time}</p>
                                <h5>Danh sách ghế:</h5>
                                <ul>
                            `;
                            data.cinema_room.seat.forEach(seat => {
                                detailHtml += `<li>${seat.seat_name} - ${seat.seat_type.name}</li>`;
                            });
                            detailHtml += `</ul>`;
                            document.querySelector('#showtime-detail').innerHTML = detailHtml;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    });
});
    </script>
@endsection --}}
