<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Phim</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        <h1>Quản lý Phim</h1>
        <div class="container">
            <h2 class="mt-5 mb-3">Danh sách Phim</h2>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm
                Phim</button>
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
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Phim</th>
                        <th>Quốc Gia</th>
                        <th>Đạo Diễn</th>
                        <th>Diễn Viên</th>
                        <th>Ngôn Ngữ</th>
                        <th>Mô Tả</th>
                        <th>Poster</th>
                        <th>Trailer</th>
                        <th>Thời Lượng</th>
                        <th>Giá</th>
                        <th>Trạng Thái</th>
                        <th>Độ Tuổi</th>
                        <th>Thể Loại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movies as $movie)
                        <tr>
                            <td>{{ $movie->movie_id }}</td>
                            <td>{{ $movie->movie_name }}</td>
                            <td>{{ $movie->nation }}</td>
                            <td>{{ $movie->directors }}</td>
                            <td>{{ $movie->actor }}</td>
                            <td>{{ $movie->language }}</td>
                            <td>{{ $movie->description }}</td>
                            <td><img src="{{ asset('images/' . $movie->poster) }}" height="100"></td>
                            <td><a href="{{ $movie->trailer_link }}" target="_blank">Xem Trailer</a></td>
                            <td>{{ $movie->time }} phút</td>
                            <td>{{ number_format($movie->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $movie->status ? 'Đang Chiếu' : 'Sắp Chiếu' }}</td>
                            <td>{{ $movie->age_rating->rating_name }}</td>
                            <td>
                                @foreach ($movie->categories as $category)
                                    <span class="badge badge-secondary">{{ $category->category_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary edit-button" data-toggle="modal"
                                    data-target="#editModal" data-id="{{ $movie->movie_id }}"
                                    data-movie_name="{{ $movie->movie_name }}" data-nation="{{ $movie->nation }}"
                                    data-directors="{{ $movie->directors }}" data-actor="{{ $movie->actor }}"
                                    data-language="{{ $movie->language }}"
                                    data-description="{{ $movie->description }}" data-poster="{{ $movie->poster }}"
                                    data-trailer_link="{{ $movie->trailer_link }}" data-time="{{ $movie->time }}"
                                    data-price="{{ $movie->price }}" data-status="{{ $movie->status }}"
                                    data-age_rating_id="{{ $movie->age_rating_id }}"
                                    data-categories="[{{ $movie->categories->pluck('id')->implode(',') }}]">
                                    Chỉnh sửa
                                </button>
                                <form action="{{ route('DeleteMovie', $movie->movie_id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Thêm Phim -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm Phim</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('AddMovie') }}" method="POST" id="addMovieForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="movie_name">Tên Phim:</label>
                                <input type="text" class="form-control" id="movie_name" name="movie_name" required>
                            </div>
                            <div class="form-group">
                                <label for="nation">Quốc Gia:</label>
                                <input type="text" class="form-control" id="nation" name="nation" required>
                            </div>
                            <div class="form-group">
                                <label for="directors">Đạo Diễn:</label>
                                <input type="text" class="form-control" id="directors" name="directors" required>
                            </div>
                            <div class="form-group">
                                <label for="actor">Diễn Viên:</label>
                                <input type="text" class="form-control" id="actor" name="actor" required>
                            </div>
                            <div class="form-group">
                                <label for="language">Ngôn Ngữ:</label>
                                <input type="text" class="form-control" id="language" name="language" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Mô Tả:</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="poster">Poster:</label>
                                <input type="file" class="form-control" id="poster" name="poster" required>
                            </div>
                            <div class="form-group">
                                <label for="trailer_link">Trailer Link:</label>
                                <input type="text" class="form-control" id="trailer_link" name="trailer_link"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="time">Thời Lượng (phút):</label>
                                <input type="number" class="form-control" id="time" name="time" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Giá:</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Trạng Thái:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Đang Chiếu</option>
                                    <option value="0">Sắp Chiếu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="age_rating_id">Độ Tuổi:</label>
                                <select class="form-control" id="age_rating_id" name="age_rating_id">
                                    @foreach ($age_rating as $rating)
                                        <option value="{{ $rating->age_rating_id }}">{{ $rating->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                            <label for="categories">Thể Loại:</label> <br>
                            @foreach ($categories as $category)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="categories[]" id="category_{{ $category->category_id }}" value="{{ $category->category_id }}">
                                    <label class="form-check-label" for="category_{{ $category->category_id }}">{{ $category->category_name }}</label>
                                </div>
                            @endforeach
                        </div> --}}
                            <div class="form-group">
                                <label for="categories">Thể Loại:</label> <br>
                                @foreach ($categories as $category)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            id="category_{{ $category->id }}" value="{{ $category->id }}">
                                        <label class="form-check-label"
                                            for="category_{{ $category->id }}">{{ $category->category_name }}</label>
                                    </div>
                                @endforeach
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

        <!-- Modal Chỉnh Sửa Phim -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Phim</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="updateMovieForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="edit_movie_id" name="id">
                            <div class="form-group">
                                <label for="edit_movie_name">Tên Phim:</label>
                                <input type="text" class="form-control" id="edit_movie_name" name="movie_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_nation">Quốc Gia:</label>
                                <input type="text" class="form-control" id="edit_nation" name="nation" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_directors">Đạo Diễn:</label>
                                <input type="text" class="form-control" id="edit_directors" name="directors"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_actor">Diễn Viên:</label>
                                <input type="text" class="form-control" id="edit_actor" name="actor" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_language">Ngôn Ngữ:</label>
                                <input type="text" class="form-control" id="edit_language" name="language"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_description">Mô Tả:</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                            </div>
                            {{-- <div class="form-group">
                                <label for="edit_poster">Poster:</label>
                                <input type="text" class="form-control" id="edit_poster" name="poster" required>
                            </div> --}}
                            <div class="form-group">
                                <label for="poster">Poster:</label>
                                <input type="file" class="form-control" id="poster" name="poster">
                            </div>
                            <div class="form-group">
                                <label for="edit_trailer_link">Trailer Link:</label>
                                <input type="text" class="form-control" id="edit_trailer_link"
                                    name="trailer_link" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_time">Thời Lượng (phút):</label>
                                <input type="number" class="form-control" id="edit_time" name="time" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_price">Giá:</label>
                                <input type="number" class="form-control" id="edit_price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_status">Trạng Thái:</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="1">Đang Chiếu</option>
                                    <option value="0">Sắp Chiếu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_age_rating_id">Độ Tuổi:</label>
                                <select class="form-control" id="edit_age_rating_id" name="age_rating_id">
                                    @foreach ($age_rating as $rating)
                                        <option value="{{ $rating->age_rating_id }}">{{ $rating->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_categories">Thể Loại:</label> <br>
                                @foreach ($categories as $category)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            id="edit_category_{{ $category->id }}"
                                            value="{{ $category->id }}">
                                        <label class="form-check-label"
                                            for="edit_category_{{ $category->id }}">{{ $category->category_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Hiển thị dữ liệu trong modal chỉnh sửa
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var movieId = button.data('id');
            var movieName = button.data('movie_name');
            var nation = button.data('nation');
            var directors = button.data('directors');
            var actor = button.data('actor');
            var language = button.data('language');
            var description = button.data('description');
            var poster = button.data('poster');
            var trailerLink = button.data('trailer_link');
            var time = button.data('time');
            var price = button.data('price');
            var status = button.data('status');
            var ageRatingId = button.data('age_rating_id');
            //var categories = JSON.parse(button.data('categories'));
            var categories = button.data('categories');
            // console.log(categories);
            // categories = JSON.parse(categories);
            var modal = $(this);
            modal.find('.modal-body #edit_movie_id').val(movieId);
            modal.find('.modal-body #edit_movie_name').val(movieName);
            modal.find('.modal-body #edit_nation').val(nation);
            modal.find('.modal-body #edit_directors').val(directors);
            modal.find('.modal-body #edit_actor').val(actor);
            modal.find('.modal-body #edit_language').val(language);
            modal.find('.modal-body #edit_description').val(description);
            modal.find('.modal-body #edit_poster').val(poster);
            modal.find('.modal-body #edit_trailer_link').val(trailerLink);
            modal.find('.modal-body #edit_time').val(time);
            modal.find('.modal-body #edit_price').val(price);
            modal.find('.modal-body #edit_status').val(status);
            modal.find('.modal-body #edit_age_rating_id').val(ageRatingId);
            modal.find('.modal-body input[type="checkbox"]').prop('checked', false);
            // Check các checkbox thể loại dựa trên dữ liệu từ categories
            categories.forEach(function(categoryId) {
                modal.find('.modal-body #edit_category_' + categoryId).prop('checked', true);
            });
            // Cập nhật action cho form
            modal.find('form').attr('action', '/admin/movies/' + movieId);
        });


        // Xử lý submit form cập nhật phim (sử dụng Ajax)
        // $('#updateMovieForm').on('submit', function(event) {
        //     event.preventDefault();

        //     var formData = new FormData(this);
        //     // Thêm logic để xử lý dữ liệu của checkbox categories[]
        //     // ...

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log('Phim đã được cập nhật thành công!');
        //             $('#editModal').modal('hide');
        //             // Thêm logic để cập nhật bảng danh sách phim
        //         },
        //         error: function(error) {
        //             console.error('Lỗi khi cập nhật phim:', error);
        //         }
        //     });
        // });
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
