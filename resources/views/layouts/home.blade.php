<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
        }

        a {
            text-decoration: none;
            font-size: 26px;
            color: black;
            transition: 0.5s;
        }

        a:hover {
            color: #FF5F00;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .drop-down:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="navbar2" style="background-color: #FFFAE6; padding: 25px;">
        <div class="content" style="display: flex; align-items:center; justify-content: space-between;">
            <div class="logo">
                <a href="{{ route('home') }}"><div style="padding: 35px; background-color:#FF9F66; margin-left: 100px;"></div></a>
            
            </div>
            <div class="menu" style="display: flex; align-items:center; width: 60%; justify-content: space-evenly;">
                <div>
                    <input type="text" placeholder="Tìm phim, rạp"
                        style="border-radius: 100rem; font-size: 1.4rem; font-weight:400; height: 4rem; line-height: 1; width: 100%; padding: 0 3rem 0 1.6rem;">
                </div>
                @if (Auth::guard('users')->check())
                    <div class="drop-down">
                        <a class="link" href="#"><i class="bi bi-person-circle"></i>
                            {{ Auth::guard('users')->user()->user_name }}</a>
                        <div class="dropdown-content">
                            <a href="#">Profile</a>
                            <a href="#" id="logout">Đăng xuất</a>
                        </div>
                    </div>
                @else
                    <a class="link" href="{{ route('LoginPage') }}"><i class="bi bi-person-circle"></i> Tài khoản</a>
                @endif
            </div>
        </div>
    </div>
    <div class="noi-dung">
        @yield('noi-dung')
    </div>
    <div class="footer">
        <div class="footer" style="background-color: #FFFAE6; padding: 25px; text-align: center;">
            <p>&copy; 2024 My Website. All rights reserved.</p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#logout').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('UserLogout') }}',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        window.location.href = '{{ route('home') }}';
                    }
                });
            });
        });
    </script>
</body>

</html>
</body>

</html>
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* CSS chung */
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
        }

        a {
            text-decoration: none;
            font-size: 26px;
            color: black;
            transition: 0.5s;
        }

        a:hover {
            color: #FF5F00;
        }

        /* Navbar */
        .navbar {
            background-color: #FFFAE6;
            padding: 25px;
        }

        .navbar .content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .logo a {
            display: block;
            padding: 35px;
            background-color: #FF9F66;
            margin-left: 100px;
        }

        .navbar .menu {
            display: flex;
            align-items: center;
            width: 60%;
            justify-content: space-evenly;
        }

        .navbar .menu input[type="text"] {
            border-radius: 100rem;
            font-size: 1.4rem;
            font-weight: 400;
            height: 4rem;
            line-height: 1;
            width: 100%;
            padding: 0 3rem 0 1.6rem;
            border: 1px solid #ccc;
        }

        /* Dropdown */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .drop-down:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Nội dung */
        .noi-dung {
            padding: 20px;
        }

        /* Footer */
        .footer {
            background-color: #FFFAE6;
            padding: 25px;
            text-align: center;
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="container">
            <div class="content">
                <div class="logo">
                    <a href="{{ route('home') }}"></a>
                </div>
                <div class="menu">
                    <input type="text" placeholder="Tìm phim, rạp">
                    @if (Auth::guard('users')->check())
                        <div class="drop-down">
                            <a href="#"><i class="bi bi-person-circle"></i>
                                {{ Auth::guard('users')->user()->user_name }}</a>
                            <div class="dropdown-content">
                                <a href="#">Profile</a>
                                <a href="#" id="logout">Đăng xuất</a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('LoginPage') }}"><i class="bi bi-person-circle"></i> Tài khoản</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="noi-dung">
        @yield('noi-dung')
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2024 My Website. All rights reserved.</p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#logout').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('UserLogout') }}',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        window.location.href = '{{ route('home') }}';
                    }
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> --}}