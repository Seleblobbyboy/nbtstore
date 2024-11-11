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
        <div class="banner">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ url('assets/img/bacnner.jpg') }}" class="d-block w-100" alt="Slide 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ url('assets/img/bacnner.jpg') }}" class="d-block w-100" alt="Slide 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ url('assets/img/bacnner.jpg') }}" class="d-block w-100" alt="Slide 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <div class="shop-show">
            @foreach ($Products as $item)
                @if ($item->showproduct == '1')
                    <h3 class="p">สินค้าแนะนำ</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 d-flex justify-content-center mt-3">
                            <a href="{{ url('/product', $item->ProductID) }}" class="crad">
                                <div class="name-product">
                                    <div class="product-img">
                                        <img src="{{ asset('storage/' . $item->productImages->first()->ImagePath) }}"
                                            alt="">
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
                @elseif ($item->showproduct == '2')
                    <div class="row">
                        <h3 class="p">สินค้าทั้งหมด</h3>
                        <hr>
                        <div class="col-md-3 col-sm-6 d-flex justify-content-center mt-3">
                            <a href="{{ url('/product', $item->ProductID) }}" class="crad">
                                <div class="name-product">
                                    <div class="product-img">
                                        <img src="{{ asset('storage/' . $item->productImages->first()->ImagePath) }}"
                                            alt="">
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
                @endif
            @endforeach
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
