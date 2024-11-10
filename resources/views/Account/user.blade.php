<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('assets/CSS/Profile/profiledata.css')}}">
</head>

<body>
    @extends('layouts.navigatuonuser')
    @section('content-user')
        <h3>ข้อมูลของฉัน</h3>

        <div class="name-data">
            @if ($CustomerAddress)
            <p><b>ชื่อ </b>: {{ $CustomerAddress->CustomerName}}</p>
            <p><b>อีเมล</b> : {{ $customers->Users->Email}}</p>

            <p><b>เบอร์</b> : {{$CustomerAddress->PhoneNumber}}</p>
            <p><b>ที่อยู่</b> : {{$CustomerAddress->Address}}</p>
            <p><b>รหัสไปรษณีย์</b> : {{$CustomerAddress->PostalCode}}, <b>จังหวัด</b> : {{$CustomerAddress->Province}}
                ,<b>อำเภอ</b> : {{$CustomerAddress->District}}, <b>ตำบล</b> : {{$CustomerAddress->Subdistrict}}</p>
            @else
            <p><b>ชื่อ </b>: {{ $customers->CustomerName}}</p>
            <p><b>อีเมล</b> : {{ $customers->Users->Email}}</p>
            <p>ที่อยู่ : ไม่มีข้อมูล</p>
            @endif

            {{-- @if (session('address') == )

            @endif --}}
        </div>
    @endsection
</body>

</html>
