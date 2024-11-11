<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ url('assets/CSS/navbar.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>

</head>

<body>
    <div class="container-fluid">
        <nav>
            <div class="logo">
                <h1>บริษัท <span>เอ็น บี ที.</span> ซัพพลายจำกัด</h1>
            </div>
            <div class="menu-login">
                <ul>
                    @if ($customer)
                        <li class="login"><a href="{{url('/profile')}}">สวัสดีคุณ {{ $customer->CustomerName }}</a></li>
                        <li class="login"><a href="{{ url('logout') }}">ออกจากระบบ</a></li>
                    @else
                        <li class="login"><a href="{{ url('login') }}">เข้าสู่ระบบ</a></li>
                        <li class="register"><a href="{{ url('register') }}">สมัครสมาชิก</a></li>
                    @endif
                </ul>
            </div>
        </nav>
        <div class="nav-menu">
            <div class="logo-menu">
                <img src="{{ url('assets/img/logo.png') }}" alt="">
            </div>
            <ul class="menu-bar">
                <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="dorp"><a href="">หมวดหมู่สินค้า <i class="fas fa-chevron-down"></i></a>
                    <ul class="down">
                        @foreach ($categories as $category)
                            <li><a href="{{url('/category',$category->CategoryID)}}">{{ $category->CategoryName }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="">วิธีซื้อสินค้า</a></li>
                <li><a href="">ใบกำกับภาษี</a></li>
                <li><a href="">ติดต่อเรา</a></li>
                <li><a href="">เกี่ยวกับเรา</a></li>
                <li><a href="">แจ้งการชำระเงิน</a></li>
            </ul>
            <div class="search">
                <ul>
                    <li><a href="{{url('/search')}}" class="search-icon"><i class="fas fa-search "></i></a></li>
                    <li><a href=""><i class="far fa-heart"></i></a></li>
                    <div class="sum-cart" id="cart-quantity-display">
                        <!-- Display total_quantity from Session -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Check if session variable is available
                                let totalQuantity = {{ session('total_quantity', 0) }};
                                let cartQuantityDisplay = document.getElementById('cart-quantity-display');

                                // Display the quantity or hide the element if 0
                                if (totalQuantity > 0) {
                                    cartQuantityDisplay.textContent = totalQuantity > 99 ? '99+' : totalQuantity;
                                } else {
                                    cartQuantityDisplay.style.display = 'none'; // Hide the div when totalQuantity is 0
                                }
                            });
                        </script>
                    </div>
                    <li><a href="{{ url('cart') }}"><i class="fas fa-shopping-cart"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="breadcrum">
            <ul>
                @yield('breadcrum')
            </ul>
        </div>
        <div class="main_content">
            @yield('content')
        </div>
    </div>
    <footer>
        <hr>
        <div class="footer-main">
            <div class="card-footer">
                <h5>ติดตามพัสดุ</h5>
                {{-- <p>แจ้งชำระเงิน</p> --}}
                <p><a href="">ติดต่อเรา</a> </p>
                {{-- <p>ใบกำกับภาษี :</p> --}}
            </div>
            <div class="card-footer">
                <h5>ติดตามเรา</h5>
                <p>Facebook : Nbt Supply </p>
                {{-- <p>TIKTOK</p> --}}
            </div>
            <div class="card-footer">
                <h5>ติดต่อเรา</h5>
                <p>โทร : 038-337085-6</p>
                <p>อีเมล : nbtsupply@gmail.com</p>
                <p>LINE : <a href="">Tawee NBT</a></p>
            </div>
        </div>
        <p class="footer-button"> &copy;NBTSUPPLY สงวนลิขสิทธิ์</p>
    </footer>

</body>

</html>
