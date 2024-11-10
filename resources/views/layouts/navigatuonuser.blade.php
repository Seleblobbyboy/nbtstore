<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile | </title>
    <link rel="stylesheet" href="{{ url('assets/CSS/Profile/Profile.css') }}">
</head>

<body>
    @extends('layouts.navigation')
    @section('content')
    <div class="container">
        <div class="card-profile">
            <div class="name">
                <p><b>ชื่อ</b> : {{$customer->CustomerName}} </p>
                <p><b>อีเมล</b> : {{$customer->Users->Email}} </p>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="{{url('/profile')}}">ข้อมูลของฉัน</a></li>
                    <li><a href="{{url('/profile/order')}}">ประวัติการสั่งซื้อ</a></li>
                    <li><a href="">ที่อยู่</a></li>
                    <li><a href="">คูปองส่วนลดของฉัน</a></li>
                </ul>
            </div>
        </div>
        <div class="card-details">
            @yield('content-user')
        </div>
    </div>

    @endsection
</body>

</html>
