<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Phòng Chiếu</title>
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


    <h1>Quản lý Phòng Chiếu</h1>
    <div class="container">
        <h2 class="mt-5 mb-3">Danh sách Phòng Chiếu</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm Phòng Chiếu</button>
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
                    <th>Tên Phòng Chiếu</th>
                    <th>Rạp</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cinemaroom as $room)
                    <tr>
                        <td>{{ $room->cinema_room_id }}</td>
                        <td>{{ $room->cinema_room_name }}</td>
                        <td>{{ $room->cinema->name }}</td> 
                        <td>
                            <button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal" data-id="{{ $room->cinema_room_id }}" data-name="{{ $room->cinema_room_name }}" data-cinema-id="{{ $room->cinema_id }}">
                                Chỉnh sửa
                            </button>
                            <form action="{{ route('DeleteCinemaRoom', $room->cinema_room_id) }}" method="POST" style="display: inline;">
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

    <!-- Modal Thêm Phòng Chiếu -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Phòng Chiếu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('AddCinemaRoom') }}" method="POST" id="addCinemaRoomForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cinema_room_name">Tên Phòng Chiếu:</label>
                            <input type="text" class="form-control" id="cinema_room_name" name="cinema_room_name" required>
                        </div>
                        <div class="form-group">
                            <label for="cinema_id">Rạp:</label>
                            <select class="form-control" id="cinema_id" name="cinema_id">
                                @foreach ($cinemas as $cinema)
                                    <option value="{{ $cinema->cinema_id }}">{{ $cinema->name }}</option>
                                @endforeach
                            </select>
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

    <!-- Modal Chỉnh Sửa Phòng Chiếu -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Phòng Chiếu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="POST" id="updateCinemaRoomForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_cinema_room_id" name="id">
                        <div class="form-group">
                            <label for="edit_cinema_room_name">Tên Phòng Chiếu:</label>
                            <input type="text" class="form-control" id="edit_cinema_room_name" name="cinema_room_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_cinema_id">Rạp:</label>
                            <select class="form-control" id="edit_cinema_id" name="cinema_id">
                                @foreach ($cinemas as $cinema)
                                    <option value="{{ $cinema->cinema_id }}">{{ $cinema->name }}</option>
                                @endforeach
                            </select>
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
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var roomId = button.data('id');
            var roomName = button.data('name');
            var cinemaId = button.data('cinema-id'); 

            console.log('Room ID:', roomId);
            console.log('Room Name:', roomName);

            var modal = $(this);
            modal.find('.modal-body #edit_cinema_room_id').val(roomId);
            modal.find('.modal-body #edit_cinema_room_name').val(roomName);
            modal.find('.modal-body #edit_cinema_id').val(cinemaId);
            
            modal.find('form').attr('action', '/admin/room/' + roomId); 
        });

//         $('#updateCinemaRoomForm').on('submit', function(event) {
//     event.preventDefault(); 

//     var formData = new FormData(this);
//     formData.forEach((value, key) => {
//         console.log(key + ": " + value);
//     });

//     $.ajax({
//         url: $(this).attr('action'),
//         type: 'PUT', // Chú ý phương thức là PUT
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//             console.log('Phòng chiếu đã được cập nhật thành công!');
//             $('#editModal').modal('hide'); 
//             // Thêm logic để cập nhật bảng danh sách phòng chiếu
//         },
//         error: function(error) {
//             console.error('Lỗi khi cập nhật phòng chiếu:', error);
//         }
//     });
// });
        // Xử lý submit form thêm phòng chiếu (sử dụng Ajax)
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