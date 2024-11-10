<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/login/login.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @extends('layouts.navigation')
    @section('content')
    <div class="card-login">
        <form action="{{url('/forgot/check')}}" method="POST" class="form">
            @csrf
            <h2>เปลี่ยนรหัสผ่าน</h2>
            <label for="email">อีเมล</label>
            <input type="email" name="email" id="email" required oninput="checkEmail()">
            <span id="email-error" style="color: red; display: none;">รูปแบบ Email ไม่ถูกต้อง @gmail.com เท่านั้น</span>
            <input type="submit" value="ยืนยัน" class="btn-login" id="submit-btn" disabled>
            <div class="register_or">
                <a href="{{ url('login') }}">เข้าสู่ระบบ</a>
            </div>
        </form>
    </div>
    @endsection

    <script>
        function checkEmail() {
            const email = document.getElementById("email").value;
            const emailError = document.getElementById("email-error");

            if (email === "") {
                emailError.style.display = "none"; // Hide the error if input is empty
            } else if (!email.endsWith("@gmail.com")) {
                emailError.style.display = "block"; // Show error for incorrect format
            } else {
                emailError.style.display = "none"; // Hide error for correct format
            }

            toggleSubmitButton();
        }

        function toggleSubmitButton() {
            const email = document.getElementById("email").value;
            const submitBtn = document.getElementById("submit-btn");

            if (email.endsWith("@gmail.com")) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }
    </script>
    @if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: "error",
                title: "{!! session('error') !!}"
            });
        });
    </script>
    @endif
</body>
</html>
