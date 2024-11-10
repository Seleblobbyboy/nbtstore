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
        <form action="{{url('/register/add')}}" method="POST" class="form">
            @csrf
            <h2>สมัครบัญชี</h2>

            <label for="name">ชื่อ-สกุล</label>
            <input type="text" name="name" required>

            <label for="email">อีเมล</label>
            <input type="email" name="email" id="email" required oninput="checkEmail()">
            <span id="email-error" style="color: red; display: none;">รูปแบบ Email ไม่ถูกต้อง @gmail.com เท่านั้น</span>

            <label for="password">รหัสผ่าน</label>
            <div class="password-field">
                <input type="password" id="password" name="password" required oninput="checkPasswords()">
                <img src="{{url('assets/img/open.png')}}" alt="แสดงรหัสผ่าน" class="toggle-password" onclick="togglePassword('password', this)">
            </div>
            <span id="password-format-error" style="color: red; display: none;">รหัสผ่านต้องมีตัวอักษรตัวแรกเป็นตัวใหญ่ ตัวเลขอย่างน้อย 1 ตัว และมีความยาว 8 ตัวอักษรขึ้นไป</span>

            <label for="confirm_password">ยืนยันรหัสผ่าน</label>
            <div class="password-field">
                <input type="password" id="confirm_password" name="confirm_password" required oninput="checkPasswords()">
                <img src="{{url('assets/img/open.png')}}" alt="แสดงรหัสผ่าน" class="toggle-password" onclick="togglePassword('confirm_password', this)">
            </div>
            <span id="password-error" style="color: red; display: none;">รหัสผ่านไม่ตรงกัน</span>

            <input type="submit" value="สมัครบัญชี" class="btn-login" id="submit-btn" disabled>

            <div class="or">
                <div class="left"></div>
                <span>หรือ</span>
                <div class="right"></div>
            </div>

            <div class="button" onclick="googleSignIn()">
                <img src="{{'assets/img/google.png'}}" alt="">
                <p>เข้าสู่ระบบด้วย Google</p>
            </div>
            <div class="register_or">
                <p>มีบัญชีอยู่แล้ว?</p><a href="{{ url('login') }}">สมัครสมาชิก</a>
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

        function checkPasswords() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const passwordError = document.getElementById("password-error");
            const passwordFormatError = document.getElementById("password-format-error");

            // Regex for password requirements: first character uppercase, at least one number, at least 8 characters
            const passwordPattern = /^[A-Z][A-Za-z0-9]{7,}$/;
            const hasNumber = /\d/; // Check if there is at least one number

            if (password && (!passwordPattern.test(password) || !hasNumber.test(password))) {
                passwordFormatError.style.display = "block";
            } else {
                passwordFormatError.style.display = "none";
            }

            if (password && confirmPassword && password !== confirmPassword) {
                passwordError.style.display = "block";
            } else {
                passwordError.style.display = "none";
            }

            toggleSubmitButton();
        }

        function toggleSubmitButton() {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const passwordPattern = /^[A-Z][A-Za-z0-9]{7,}$/;
            const hasNumber = /\d/;
            const submitBtn = document.getElementById("submit-btn");

            if (email.endsWith("@gmail.com") && 
                password === confirmPassword && 
                password !== "" && 
                confirmPassword !== "" && 
                passwordPattern.test(password) && 
                hasNumber.test(password)) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        function togglePassword(fieldId, icon) {
            const passwordField = document.getElementById(fieldId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.src = "{{url('assets/img/closs.png')}}"; // Change to closed eye icon
            } else {
                passwordField.type = "password";
                icon.src = "{{url('assets/img/open.png')}}"; // Change back to open eye icon
            }
        }
    </script>
    @if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error', // Correct spelling
                title: 'สมัครบัญชีไม่สำเร็จ!',
                text: '{{ session('error') }}',
                confirmButtonText: 'ตกลง'
            });
        });
    </script>
@endif
</body>
</html>
