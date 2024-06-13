<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Admin Dashboard</title>
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

        <h1>Nội dung chính</h1>
        <p>Nội dung chính của trang web được hiển thị ở đây.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
//         $(document).ready(function () {
//     const contentDiv = $('#content');

//     $('.sidebar a').on('click', function (event) {
//         event.preventDefault();
//         const url = $(this).attr('href');

//         fetch(url)
//             .then(response => response.text())
//             .then(data => {
//                 contentDiv.html(data);
//                 initializeEvents();
//             })
//             .catch(error => console.error('Lỗi khi tải nội dung:', error));
//     });

//     function initializeEvents() {
//         $('#editModal').on('show.bs.modal', function (event) {
//             const button = $(event.relatedTarget);
//             const categoryId = button.data('id');
//             const categoryName = button.data('name');

//             const modal = $(this);
//             modal.find('.modal-body #category_id').val(categoryId);
//             modal.find('.modal-body #category_name').val(categoryName);
//             modal.find('form').attr('action', '/admin/categories/' + categoryId);
//         });

//         $('#addCategoryForm').off('submit').on('submit', function (event) {
//             event.preventDefault();
//             const formData = new FormData(this);

//             $.ajax({
//                 url: $(this).attr('action'),
//                 type: 'POST',
//                 data: formData,
//                 processData: false,
//                 contentType: false,
//                 success: function (response) {
//                     showNotification(response.message);
//                     $('#addModal').modal('hide');
//                     location.reload(); // Làm mới trang để hiển thị thông báo session
//                 },
//                 error: function (error) {
//                     console.error('Lỗi khi thêm thể loại:', error);
//                 }
//             });
//         });

//         $(document).on('click', '.delete-button', function (event) {
//             event.preventDefault();
//             if (!confirm('Bạn có chắc chắn muốn xóa thể loại này không?')) {
//                 return;
//             }

//             const form = $(this).closest('form');
//             form.submit();
//         });

//         $('#editCategoryForm').off('submit').on('submit', function (event) {
//             event.preventDefault();
//             const formData = new FormData(this);

//             $.ajax({
//                 url: $(this).attr('action'),
//                 type: 'POST',
//                 data: formData,
//                 processData: false,
//                 contentType: false,
//                 success: function (response) {
//                     showNotification(response.message);
//                     $('#editModal').modal('hide');
//                     location.reload(); // Làm mới trang để hiển thị thông báo session
//                 },
//                 error: function (error) {
//                     console.error('Lỗi khi cập nhật thể loại:', error);
//                 }
//             });
//         });
//     }

//     function showNotification(message) {
//         const notification = $('<div>').addClass('alert alert-success').text(message);
//         $('body').append(notification);
//         setTimeout(() => notification.remove(), 3000);
//     }

//     initializeEvents();
// });

    </script>
</body>

</html>
