@extends('layouts.home')

@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">
    <div class="container" style="margin-top: 60px; margin-bottom: 100px;">
        <div class="form-box">
            <div class="button-box">
                <button type="button" class="toggle-btn" onclick="login()">ĐĂNG NHẬP</button>
                <button type="button" class="toggle-btn" onclick="register()">ĐĂNG KÝ</button>
            </div>
            <form action="{{ route('UserLogin') }}" method="POST" id="login" class="input-group">
                @csrf
                <div class="container-form">
                    <label for="uname">Email <span>*</span></label>
                    <input type="email" id="user_email" name="user_email" required>

                    <label for="psw">Mật khẩu <span>*</span></label>
                    <input type="password" id="user_password" name="user_password" required>
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                    <button type="submit">ĐĂNG NHẬP</button>
                </div>
            </form>
            <form action="{{ route('UserRegister') }}" method="POST" id="register" class="input-group"
                style="display:none;">
                @csrf
                <div class="container-form">
                    <label for="user_name">Họ và tên <span>*</span></label><br>
                    <input type="text" id="user_name" name="user_name" class="input-field" required><br>
                    <label for="user_phone">Số điện thoại <span>*</span></label><br>
                    <input type="text" id="user_phone" name="user_phone" class="input-field" required><br>
                    <label for="user_email">Email <span>*</span></label><br>
                    <input type="email" id="user_email" name="user_email" class="input-field" required><br>
                    <div style="display: flex;">
                        <div style="width:100%;">
                            <label for="user_gender">Giới tính <span>*</span></label>
                            <div style="display:flex; justify-content: space-evenly; margin-top: 20px;">
                                <input type="radio" id="male" name="user_gender" value="Nam" required>
                                <label for="male">Nam</label>
                                <input type="radio" id="female" name="user_gender" value="Nữ" required>
                                <label for="female">Nữ</label>
                            </div>
                        </div>
                        <div>
                            <label for="user_date_of_birth">Ngày sinh <span>*</span></label>
                            <input type="date" id="user_date_of_birth" name="user_date_of_birth" class="input-field"
                                required>
                        </div>
                    </div>

                    <label for="user_password">Mật khẩu <span>*</span></label><br>
                    <input type="password" id="user_password" name="user_password" class="input-field" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$">
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                    <button type="submit" class="submit-btn">ĐĂNG KÝ</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        var x = document.getElementById("login");
        var y = document.getElementById("register");

        function register() {
            y.style.display = "block";
            y.style.height = "100%";
            x.style.left = "-400px";
            y.style.left = "50px";
            x.style.display = "none";
        }

        function login() {
            x.style.display = "block";
            x.style.left = "50px";
            y.style.left = "450px";
            y.style.display = "none";
        }
    </script>
@endsection
