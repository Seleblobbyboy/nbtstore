<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>สินค้า | {{ $product->ProductName }}</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/product.css') }}">
</head>

<body>
    @extends('layouts.navigation')
    @section('breadcrum')
        <li><a href="">หน้าหลัก</a></li>
        <span>/</span>
        <li><a href="">{{ $product->category ? $product->category->CategoryName : 'ไม่มีหมวดหมู่' }}</a></li>
        <span>/</span>
        <li><a href="">{{ $product->ProductName }}</a></li>
    @endsection

    @section('content')
        <div class="product">
            <div class="product-img">
                <div class="product-photo">
                    <div class="photo">
                        <img id="main-photo" src="{{ asset('storage/' . $ProductImage_Main->ImagePath) }}" alt="">
                    </div>
                </div>
                <div class="product-photo-mini">
                    @foreach ($ProductImage as $items)
                        <div class="mini-img">
                            <img src="{{ asset('storage/' . $items->ImagePath) }}" alt="" onclick="changePhoto(this)">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="product-content">
                <div class="head-content">
                    <h1>{{ $product->ProductName }}</h1>
                    <p>{{ $product->ProductName_ENG }}</p>
                </div>
                <hr class="hr">
                <div class="product-price">
                    <p>${{ number_format($product->Price, 2) }}</p>
                </div>
                <div class="stock">
                    <p>สินค้ามีจำนวน : {{ number_format($product->stock, 0) }} ชิ้น</p>
                </div>
                <div class="quantity">
                    <small>จำนวน</small>
                    <div class="quantity-selector">
                        <button onclick="decrement()" class="minus-btn">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                            style="text-align: center;" oninput="validateStock(this)" onblur="resetIfEmpty(this)">
                        <button onclick="increment()" class="plass-btn">+</button>
                    </div>
                    <small id="quantity-warning" style="color: red; display: none;">คุณสั่งจำนวนเกินจากที่มีในสต็อก</small>
                </div>
                <div class="button">
                    <div class="button-Order">
                        <form id="add-to-cart-form" action="{{ route('cart.add', $product->ProductID) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1" id="quantity-input">
                        </form>
                        <a href="javascript:void(0);" onclick="addToCart();">
                            <i class="fas fa-shopping-cart"></i> เพิ่มในตะกร้า
                        </a>
                    </div>
                    <div class="button-forever">
                        <a href=""><i class="far fa-heart"> รายการโปรด</i></a>
                    </div>
                </div>
                <div class="Category">
                    <small>หมวดหมู่ : {{ $product->category ? $product->category->CategoryName : 'ไม่มีหมวดหมู่' }}</small>
                </div>
            </div>
        </div>
        <hr>
        <div class="Product-description">
            <h3>รายละเอียดสินค้า</h3>
            <ul>
                @foreach (explode("\n", $product->Description) as $line)
                    @if (trim($line) !== '')
                        <li>{{ $line }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endsection

    <script src="{{ url('assets/Js/product.js') }}"></script>
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            });
        </script>
    @endif

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
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            });
        </script>
    @endif

    <script>
        const maxStock = {{ $product->stock }};

        function increment() {
            let quantity = document.getElementById("quantity");
            let quantityInput = document.getElementById("quantity-input");
            let currentValue = parseInt(quantity.value);
            if (currentValue < maxStock) {
                quantity.value = currentValue + 1;
                document.getElementById("quantity-warning").style.display = "none";
            } else {
                document.getElementById("quantity-warning").style.display = "block";
                quantity.value = maxStock; // Set to max stock
            }
            quantityInput.value = quantity.value; // Update the hidden input
        }

        function decrement() {
            let quantity = document.getElementById("quantity");
            let quantityInput = document.getElementById("quantity-input");
            let currentValue = parseInt(quantity.value);
            if (currentValue > 1) {
                quantity.value = currentValue - 1;
                document.getElementById("quantity-warning").style.display = "none";
            }
            quantityInput.value = quantity.value; // Update the hidden input
        }

        function validateStock(input) {
            let currentValue = parseInt(input.value);
            if (currentValue > maxStock) {
                input.value = maxStock;
                document.getElementById("quantity-warning").style.display = "block";
            } else {
                document.getElementById("quantity-warning").style.display = "none";
            }
        }

        function resetIfEmpty(input) {
            if (input.value === "" || parseInt(input.value) < 1) {
                input.value = 1;
                document.getElementById("quantity-warning").style.display = "none";
            }
        }

        function addToCart() {
            const quantity = document.getElementById("quantity").value;
            document.getElementById("quantity-input").value = quantity; // Update the hidden input before submitting
            document.getElementById('add-to-cart-form').submit();
        }
    </script>

</body>

</html>
