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
                    <div class="card showtime-card" data-date="{{ $date }}"
                        data-showtimes="{{ json_encode(
                            collect($showTimes)->map(function ($showtime) {
                                    return [
                                        'showtime_id' => $showtime['showtime_id'],
                                        'start_time' => $showtime['start_time'],
                                    ];
                                })->toArray(),
                        ) }}"
                        data-target="#showtime-list-{{ \Illuminate\Support\Str::slug($date) }}">
                        <div class="card-body" style="text-align: center;">
                            <h5 class="card-title">{{ $date }}</h5>
                            <p class="card-text">
                            <div id="showtime-list-{{ \Illuminate\Support\Str::slug($date) }}" class="showtime-list">
                                <!-- Suất chiếu sẽ được hiển thị ở đây -->
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Thêm phần tử để hiển thị chi tiết suất chiếu -->
        <div id="showtime-detail" class="mt-5"></div>
        <button id="pay-button" class="btn btn-success mt-3">đặt vé</button>


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showtimeCards = document.querySelectorAll('.showtime-card');
            let currentShowtimeId = null;
            showtimeCards.forEach(button => {
                button.addEventListener('click', function() {
                    const date = this.getAttribute('data-date');
                    const showtimes = JSON.parse(this.getAttribute('data-showtimes'));
                    const target = this.getAttribute('data-target');

                    showtimes.sort((a, b) => {
                        const timeA = new Date('1970-01-01T' + a.start_time + 'Z');
                        const timeB = new Date('1970-01-01T' + b.start_time + 'Z');
                        return timeA - timeB;
                    });

                    let showtimeListHtml = ``;

                    showtimes.forEach(showtime => {
                        showtimeListHtml +=
                            `<a href="#" class="showtime-link" data-id="${showtime.showtime_id}">${showtime.start_time}</a>`;
                    });
                    showtimeListHtml += '';

                    document.querySelector(target).innerHTML = showtimeListHtml;

                    document.querySelectorAll('.showtime-link').forEach(link => {
                        link.addEventListener('click', function(event) {
                            event.preventDefault();
                            currentShowtimeId = this.getAttribute(
                            'data-id'); // Cập nhật showtimeId hiện tại
                            console.log(currentShowtimeId);
                            fetch(`/showtimedetail/${currentShowtimeId}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) {
                                        alert(data.error);
                                        return;
                                    }
                                    let detailHtml = `
                                    <h3>Chi tiết suất chiếu</h3>
                                    <h4>Phim: ${data.showtime.movie.movie_name}</h4>
                                    
                                    <p>Ngày: ${data.showtime.start_date}</p>
                                    <p>Giờ: ${data.showtime.start_time}</p>
                                    <h5>Danh sách ghế:</h5>
                                `;
                                    const rowMap = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                    const soldSeats = data.soldSeats;
                                    let currentRow = null;
                                    data.showtime.cinema_room.seat.forEach(
                                        seat => {
                                            const rowLetter = seat.seat_name
                                                .charAt(0);
                                            const colNumber = parseInt(seat
                                                .seat_name.slice(1));

                                            if (currentRow !== rowLetter) {
                                                if (currentRow !== null) {
                                                    detailHtml += `</div>`;
                                                }
                                                detailHtml +=
                                                    `<div class="seat-row">`;
                                                currentRow = rowLetter;
                                            }
                                            let seatStatusClass = soldSeats
                                                .includes(seat.seat_id) ?
                                                'sold' : '';
                                            detailHtml +=
                                                `<div class="seat ${seatStatusClass}" data-seat-id="${seat.seat_id}">${seat.seat_name}</div>`;
                                        });

                                    if (currentRow !== null) {
                                        detailHtml += `</div>`;
                                    }

                                    detailHtml += `</div>`;
                                    document.querySelector('#showtime-detail')
                                        .innerHTML = detailHtml;

                                    document.querySelectorAll('.seat').forEach(
                                        seat => {
                                            seat.addEventListener('click',
                                                function() {
                                                    const isSelected =
                                                        this.classList
                                                        .contains(
                                                            'selected');
                                                    if (this.classList
                                                        .contains(
                                                            'sold')) {
                                                        return;
                                                    }
                                                    if (isSelected) {
                                                        this.classList
                                                            .remove(
                                                                'selected'
                                                            );
                                                    } else {
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

            document.querySelector('#pay-button').addEventListener('click', function() {
                const selectedSeats = document.querySelectorAll('.seat.selected');
                const seats = Array.from(selectedSeats).map(seat => seat.getAttribute('data-seat-id'));

                if (!currentShowtimeId) {
                    //alert('Vui lòng chọn suất chiếu.');
                    return;
                }
                if (seats.length === 0) {
                    //alert('Vui lòng chọn ít nhất một ghế.');
                    return;
                }

                const requestData = {
                    showtime_id: currentShowtimeId,
                    seats: seats
                };

                fetch('/book-ticket', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(requestData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/payment-page';
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
