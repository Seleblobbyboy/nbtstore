<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/login/login.css') }}">
    <script src="https://www.gstatic.com/firebasejs/7.14.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.2/firebase-auth.js"></script>
    <script src="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.css" />
</head>

<body>
    @extends('layouts.navigation')

    @section('content')
        <div class="card-login">
            <form action="{{ url('login/check') }}" method="POST" class="form">
                @csrf <!-- เพิ่มบรรทัดนี้เพื่อสร้าง CSRF token -->
                <h2>เข้าสู่ระบบ</h2>
                <label for="email">อีเมล</label>
                <input type="email" name="email" required>
                <label for="password">รหัสผ่าน</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" required>
                    <img src="{{ url('assets/img/open.png') }}" alt="แสดงรหัสผ่าน" class="toggle-password"
                        onclick="togglePassword('password', this)">
                </div>
                <input type="submit" value="เข้าสู่ระบบ" class="btn-login">
                <div class="Forgot">
                    <a href="{{url('/forgot')}}">เปลี่ยนรหัสผ่าน</a>
                </div>

                <div class="or">
                    <div class="left"></div>
                    <span>หรือ</span>
                    <div class="right"></div>
                </div>

                <div class="button" onclick="googleSignIn()">
                    <img src="{{ url('assets/img/google.png') }}" alt="">
                    <p>เข้าสู่ระบบด้วย Google</p>
                </div>
                <div class="register_or">
                    <p>ยังไม่มีบัญชี?</p><a href="{{ url('register') }}">สมัครสมาชิก</a>
                </div>
            </form>
        </div>

        <form id="update" action="{{ url('/login/add') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="name" value="">
            <input type="hidden" name="email" value="">
        </form>
    @endsection

    <script>
        function togglePassword(fieldId, icon) {
            var passwordField = document.getElementById(fieldId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.src = "{{ url('assets/img/closs.png') }}"; // เปลี่ยนเป็นไอคอนปิดตา
            } else {
                passwordField.type = "password";
                icon.src = "{{ url('assets/img/open.png') }}"; // เปลี่ยนกลับเป็นไอคอนเปิดตา
            }
        }
    </script>
    <script src="{{ url('assets/Js/google.js') }}"></script>
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'ตกลง'
                });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error', // Correct spelling
                    title: 'เข้าสู่ระบบไม่สำเร็จ!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'ตกลง'
                });
            });
        </script>
    @endif
</body>

</html>
