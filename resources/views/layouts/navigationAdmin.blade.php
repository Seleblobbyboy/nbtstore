<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ url('assets/CSS/navbar_admin.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</head>

<body>
    <div class="main-nav">
        <div class="nav"></div>
        <nav>
            <div class="logo">
                <div class="img-logo">
                    <img src="{{ url('assets/img/logo_w.png') }}" alt="">
                </div>
            </div>
            <div class="menu">
                <ul class="menu-drop">
                    <li><a href="{{ url('/admin') }}">หน้าแรก</a></li>
                    <li><a href="{{url('/product')}}">สินค้า</a></li>
                </ul>
                <div class="menu-drop">
                    <ul>
                        <li><a href="{{url('/logout/admin')}}">ออกจากระบบ</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content-main">
            @yield('content')
        </div>
    </div>
</body>

</html>
