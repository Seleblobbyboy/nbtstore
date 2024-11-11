<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>หน้าแรก</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/Homepage.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png">
</head>

<body>
    @extends('layouts.navigation')
    @section('content')
        <div class="search">
            <form action="{{ url('/search/product') }}" method="POST">
                @csrf
                <input type="search" name="search"  value="{{$query}}" placeholder="ค้นหาสินค้า...">
                <input type="submit" value="ค้นหา">
            </form>
        </div>
        <div class="shop-show">
            @if ($Products->isNotEmpty())
                <h3 class="p">ผลการค้นหาสำหรับ "{{ $query }}"</h3>
                <hr>
                @foreach ($Products as $item)
                    <div class="row">
                        <div class="col-md-3 col-sm-6 d-flex justify-content-center mt-3">
                            <a href="{{ url('/product', $item->ProductID) }}" class="crad">
                                <div class="name-product">
                                    <div class="product-img">
                                        <img src="{{ asset('storage/' . $item->productImages->first()->ImagePath) }}" alt="">
                                    </div>
                                    <b class="p">{{ Str::limit($item->ProductName, 25, '...') }}</b>
                                    <p class="p">{{ Str::limit($item->ProductName_ENG, 20, '...') }}</p>
                                    <small class="p">หมวดหมู่ :
                                        {{ $item->category ? Str::limit($item->category->CategoryName, 10, '...') : 'ไม่มีหมวดหมู่' }}
                                    </small>
                                </div>
                                <div class="monny-product">
                                    <p class="p">${{ number_format($item->Price, 2) }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <h3 class="p">ไม่พบสินค้าที่ตรงกับ "{{ $query }}"</h3>
            @endif
        </div>
    @endsection
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
</body>

</html>
