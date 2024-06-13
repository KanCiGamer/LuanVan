<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 200px;
            background-color: #f0f0f0;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar .profile {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar li a {
            text-decoration: none;
            color: #333;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <h3>Administrator</h3>
            <a href="#">Đăng xuất</a>
        </div>
        <ul>
            <li><a href="{{ route('AdminPage') }}">Số liệu</a></li>
            <li><a href="{{ route('ShowMovies') }}">Phim</a></li>
            <li><a href="{{ route('ShowCategories') }}">Thể loại</a></li>
            <li><a href="{{ route('ShowCinemas') }}">Rạp phim</a></li>
            <li><a href="{{ route('ShowCinemaRoom') }}">Phòng chiếu</a></li>
            <li><a href="{{ route('ShowSType') }}">Loại ghế</a></li>
            <li><a href="{{ route('ShowSeat') }}">Ghế</a></li>
            <li><a href="{{ route('ShowTime') }}">Suất chiếu</a></li>
            <li><a href="/admin/user">Người dùng</a></li>
            <li><a href="/admin/role">Vai trò</a></li>
        </ul>
    </div>

    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Quản lý suất chiếu</h4>
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#addShowtimeModal">
                                Thêm suất chiếu
                            </button>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>ID</th>
                                        <th>Tên phim</th>
                                        <th>Phòng chiếu</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Thời gian bắt đầu</th>
                                        <th>Hành động</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($showtimes as $showtime)
                                            <tr>
                                                <td>{{ $showtime->showtime_id }}</td>
                                                <td>{{ $showtime->movie->movie_name }}</td>
                                                <td>{{ $showtime->cinema_room->cinema_room_name }}</td>
                                                <td>{{ $showtime->start_date }}</td>
                                                <td>{{ $showtime->start_time }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm edit-showtime"
                                                        data-toggle="modal" data-target="#editShowtimeModal"
                                                        data-id="{{ $showtime->showtime_id }}"
                                                        data-movie-id="{{ $showtime->movie_id }}"
                                                        data-cinema-room-id="{{ $showtime->cinema_room_id }}"
                                                        data-start-time="{{ $showtime->start_time }}"
                                                        data-start-date="{{ $showtime->start_date }}">
                                                        
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('DeleteSTime', $showtime->showtime_id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa suất chiếu này?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal thêm suất chiếu -->
        <div class="modal fade" id="addShowtimeModal" tabindex="-1" role="dialog"
            aria-labelledby="addShowtimeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addShowtimeModalLabel">Thêm suất chiếu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('AddSTime') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="movie_id">Tên phim</label>
                                <select class="form-control" id="movie_id" name="movie_id" required>
                                    @foreach ($movies as $movie)
                                        <option value="{{ $movie->movie_id }}">{{ $movie->movie_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cinema_id">Rạp phim</label>
                                <select class="form-control" id="cinema_id" name="cinema_id" required>
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->cinema_id }}">{{ $cinema->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cinema_room_id">Phòng chiếu</label>
                                <select class="form-control" id="cinema_room_id" name="cinema_room_id" required>
                                    <!-- Danh sách phòng chiếu sẽ được tải bằng Ajax -->
                                </select>
                            </div>

                            {{-- <div class="form-group">
                                <label for="start_time">Thời gian bắt đầu</label>
                                <input type="datetime-local" class="form-control" id="start_time" name="start_time"
                                    required>
                            </div> --}}
                            <div class="form-group">
                                <label for="start_date">Ngày bắt đầu</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="start_time">Giờ bắt đầu</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal sửa suất chiếu -->
        <div class="modal fade" id="editShowtimeModal" tabindex="-1" role="dialog"
            aria-labelledby="editShowtimeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editShowtimeModalLabel">Sửa suất chiếu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="editShowtimeForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="showtime_id" id="edit_showtime_id">
                            <div class="form-group">
                                <label for="edit_movie_id">Tên phim</label>
                                <select class="form-control" id="edit_movie_id" name="movie_id" required>
                                    @foreach ($movies as $movie)
                                        <option value="{{ $movie->movie_id }}">{{ $movie->movie_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cinema_id">Rạp phim</label>
                                <select class="form-control" id="edit_cinema_id" name="cinema_id" required>
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->cinema_id }}">{{ $cinema->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cinema_room_id">Phòng chiếu</label>
                                <select class="form-control" id="edit_cinema_room_id" name="cinema_room_id" required>
                                    <!-- Danh sách phòng chiếu sẽ được tải bằng Ajax -->
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label for="edit_cinema_room_id">Phòng chiếu</label>
                                <select class="form-control" id="edit_cinema_room_id" name="cinema_room_id" required>
                                    @foreach ($cinema_rooms as $room)
                                        <option value="{{ $room->cinema_room_id }}">{{ $room->cinema_room_name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            {{-- <div class="form-group">
                                <label for="edit_start_time">Thời gian bắt đầu</label>
                                <input type="datetime-local" class="form-control" id="edit_start_time"
                                    name="start_time" required>
                            </div> --}}
                            <div class="form-group">
                                <label for="edit_start_date">Ngày bắt đầu</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_start_time">Giờ bắt đầu</label>
                                <input type="time" class="form-control" id="edit_start_time" name="start_time" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Lấy dữ liệu từ nút "Sửa" và hiển thị lên modal
            $('.edit-showtime').click(function() {
                console.log("da nhan");
                const showtimeId = $(this).data('id');
                const movieId = $(this).data('movie-id');
                const cinemaRoomId = $(this).data('cinema-room-id');
                const startTime = $(this).data('start-time');
                const startDate = $(this).data('start-date');

                $('#edit_showtime_id').val(showtimeId);
                $('#edit_movie_id').val(movieId);
                $('#edit_cinema_room_id').val(cinemaRoomId);
                $('#edit_start_time').val(startTime);
                $('#edit_start_date').val(startDate);


                $('#editShowtimeForm').attr('action', `/admin/stime/${showtimeId}`);
            });
        });
        $(document).ready(function() {
            $('#cinema_id').change(function() {
                let cinemaId = $(this).val();
                console.log("da nhan 2");
                if (cinemaId) {
                    $.ajax({
                        url: '/get-cinema-rooms/' + cinemaId,
                        type: 'GET',
                        success: function(data) {
                            $('#cinema_room_id').empty();
                            $('#cinema_room_id').append(
                                '<option value="">Chọn phòng chiếu</option>');
                            $('#cinema_room_id').show();
                            $.each(data, function(key, room) {
                                $('#cinema_room_id').append('<option value="' + room
                                    .cinema_room_id + '">' + room.cinema_room_name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#cinema_room_id').empty();
                    $('#cinema_room_id').hide();
                }
            });
        });
        $(document).ready(function() {
            $('#edit_cinema_id').change(function() {
                let cinemaId = $(this).val();
                console.log("da nhan 2");
                if (cinemaId) {
                    $.ajax({
                        url: '/get-cinema-rooms/' + cinemaId,
                        type: 'GET',
                        success: function(data) {
                            $('#edit_cinema_room_id').empty();
                            $('#edit_cinema_room_id').append(
                                '<option value="">Chọn phòng chiếu</option>');
                            $('#edit_cinema_room_id').show();
                            $.each(data, function(key, room) {
                                $('#edit_cinema_room_id').append('<option value="' + room
                                    .cinema_room_id + '">' + room.cinema_room_name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#edit_cinema_room_id').empty();
                    $('#edit_cinema_room_id').hide();
                }
            });
        });
        $(document).ready(function() {
            // Ẩn phần thông báo thành công sau 5 giây
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 2000);

            // Ẩn phần thông báo lỗi sau 5 giây
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 2000);
        });
    </script>
</body>

</html>
