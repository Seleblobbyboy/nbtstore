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
            <form action="{{ url('/reset/check') }}" method="POST" class="form">
                @csrf
                <h2>สร้างรหัสใหม่</h2>

                <!-- Old Password Field -->
                <label for="password">รหัสผ่านเก่า</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" required>
                    <img src="{{ url('assets/img/open.png') }}" alt="แสดงรหัสผ่าน" class="toggle-password"
                        onclick="togglePassword('password', this)">
                </div>

                <!-- New Password Field with Validation -->
                <label for="confirm_password">รหัสผ่านใหม่</label>
                <div class="password-field">
                    <input type="password" id="confirm_password" name="confirm_password" required oninput="validatePassword()">
                    <img src="{{ url('assets/img/open.png') }}" alt="แสดงรหัสผ่าน" class="toggle-password"
                        onclick="togglePassword('confirm_password', this)">
                </div>
                <span id="password-format-error" style="color: red; display: none;">
                    รหัสผ่านต้องมีตัวอักษรตัวแรกเป็นตัวใหญ่ ตัวเลขอย่างน้อย 1 ตัว และมีความยาว 8 ตัวอักษรขึ้นไป
                </span>

                <input type="submit" value="ยันยัน" class="btn-login" id="submit-btn" disabled>

                <div class="register_or">
                    <a href="{{ url('login') }}">เข้าสู่ระบบ</a>
                </div>
            </form>
        </div>
    @endsection

    <script>
        // Toggle visibility of password fields
        function togglePassword(fieldId, icon) {
            const passwordField = document.getElementById(fieldId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.src = "{{ url('assets/img/closs.png') }}"; // Change to closed eye icon
            } else {
                passwordField.type = "password";
                icon.src = "{{ url('assets/img/open.png') }}"; // Change back to open eye icon
            }
        }

        // Validate new password format
        function validatePassword() {
            const confirmPassword = document.getElementById("confirm_password").value;
            const passwordFormatError = document.getElementById("password-format-error");
            const submitBtn = document.getElementById("submit-btn");

            // Regular expression to check for the required password pattern
            const passwordPattern = /^[A-Z][A-Za-z0-9]{7,}$/;

            if (confirmPassword === "") {
                passwordFormatError.style.display = "none"; // Hide error if input is empty
                submitBtn.disabled = true;
            } else if (!passwordPattern.test(confirmPassword)) {
                passwordFormatError.style.display = "block"; // Show error for incorrect format
                submitBtn.disabled = true;
            } else {
                passwordFormatError.style.display = "none"; // Hide error if correct format
                submitBtn.disabled = false; // Enable the submit button
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
