<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>สินค้า | ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/product.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/product/cart.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @extends('layouts.navigation')
    @section('breadcrum')
    @endsection
    @section('content')
        <div class="hea-cart">
            <h1>ตะกร้าสินค้า</h1>
            <div class="card-cart">
                <div class="card-left">
                    <h5>สินค้าในตะกร้า</h5>
                    <div class="table-cart">
                        <table>
                            <tr>
                                <th colspan="2" class="name">สินค้า</th>
                                <th>ราคา/ชิ้น</th>
                                <th>จำนวน</th>
                                <th colspan="2">ราคารวม</th>
                            </tr>
                            @foreach ($cart as $Product)
                                <tr id="product-row-{{ $Product['ProductID'] }}">
                                    <td class="img">
                                        <img src="{{ asset('storage/' . $Product['ImagePath']) }}" alt="">
                                    </td>
                                    <td><a href="{{ url('product', $Product['ProductID']) }}"
                                            class="ProductName">{{ $Product['ProductName'] }} </a></td>
                                    <td id="price-per-unit-{{ $Product['ProductID'] }}">
                                        ${{ number_format($Product['Price'], 2) }}
                                    </td>
                                    <td>
                                        <div class="quantity-selector" style="margin-left: 0px; margin-right: 0px;">
                                            <button onclick="decrement('{{ $Product['ProductID'] }}')"
                                                class="minus-btn">-</button>
                                            <input type="number" id="quantity-{{ $Product['ProductID'] }}"
                                                value="{{ $Product['quantity'] }}" min="1"
                                                max="{{ $Product['stock'] ?? 0 }}" style="text-align: center;"
                                                oninput="validateQuantity('{{ $Product['ProductID'] }}', this)"
                                                onblur="handleManualInput('{{ $Product['ProductID'] }}')" />
                                            <button onclick="increment('{{ $Product['ProductID'] }}')"
                                                class="plass-btn">+</button>
                                        </div>
                                    </td>
                                    <td id="total-price-{{ $Product['ProductID'] }}">
                                        ${{ number_format($Product['Price'] * $Product['quantity'], 2) }}
                                    </td>
                                    <td>
                                        <i class="fas fa-trash-alt" onclick="removeFromCart('{{ $Product['ProductID'] }}')"
                                            style="cursor: pointer;"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card-rigth">
                    <h5>ยอดรวมตะกร้าสินค้า</h5>
                    <div class="sum">
                        <p>จำนวนสินค้า: <span id="total-quantity">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                            ชิ้น</p>
                        <p class="sum-total" id="sum-total">
                            ${{ number_format(array_sum(array_map(fn($Product) => $Product['Price'] * $Product['quantity'], $cart)), 2) }}
                        </p>
                    </div>
                    <div class="totle">
                        <p>ยอดรวมตะกร้าสินค้า</p>
                        <p id="cart-total">
                            ${{ number_format(array_sum(array_map(fn($Product) => $Product['Price'] * $Product['quantity'], $cart)), 2) }}
                        </p>
                    </div>
                    <a href="{{url('/cart/shopping')}}" class="Order">สั่งซื้อสินค้า</a>
                </div>
            </div>
        </div>
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
    @endsection

    <script>
        function increment(productId) {
            let quantityInput = document.getElementById('quantity-' + productId);
            let currentValue = parseInt(quantityInput.value);
            let maxStock = parseInt(quantityInput.max);

            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
                updateTotalPrice(productId);
                updateCartTotal();
                updateCart(productId, quantityInput.value);
            } else {
                showToast('error', 'ไม่สามารถเพิ่มสินค้ามากกว่าที่มีในสต็อกได้');
            }
        }

        function decrement(productId) {
            let quantityInput = document.getElementById('quantity-' + productId);
            let currentValue = parseInt(quantityInput.value);

            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateTotalPrice(productId);
                updateCartTotal();
                updateCart(productId, quantityInput.value);
            }
        }

        function updateTotalPrice(productId) {
            let quantityInput = document.getElementById('quantity-' + productId);
            let pricePerUnit = parseFloat(document.getElementById('price-per-unit-' + productId).textContent.replace('$',
                ''));
            let totalPriceElement = document.getElementById('total-price-' + productId);

            let totalPrice = pricePerUnit * parseInt(quantityInput.value);
            totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
        }

        function updateCartTotal() {
            let totalQuantity = 0;
            let totalAmount = 0;

            document.querySelectorAll('[id^="quantity-"]').forEach(item => {
                totalQuantity += parseInt(item.value);
            });

            document.querySelectorAll('[id^="total-price-"]').forEach(item => {
                totalAmount += parseFloat(item.textContent.replace('$', ''));
            });

            document.getElementById('total-quantity').textContent = totalQuantity;
            document.getElementById('cart-total').textContent = `$${totalAmount.toFixed(2)}`;
            document.getElementById('sum-total').textContent = `$${totalAmount.toFixed(2)}`;

            const cartBadge = document.querySelector('.sum-cart');
            if (cartBadge) {
                if (totalQuantity > 0) {
                    cartBadge.textContent = totalQuantity;
                } else {
                    cartBadge.style.display = 'none';
                }
            }

            fetch(`/cart/updateTotalQuantityAndAmount`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        total_quantity: totalQuantity,
                        total_amount: totalAmount
                    })
                })
                .catch(error => console.error('Error updating session total quantity and amount:', error));
        }

        function updateCart(productId, quantity) {
            fetch(`/cart/update/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        showToast('error', 'เกิดข้อผิดพลาดในการอัปเดตจำนวนสินค้า');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function handleManualInput(productId) {
            const quantityInput = document.getElementById('quantity-' + productId);
            const maxStock = parseInt(quantityInput.max);
            let quantity = parseInt(quantityInput.value);

            if (quantity > maxStock) {
                quantity = maxStock;
                showToast('error', 'ไม่สามารถเพิ่มสินค้ามากกว่าที่มีในสต็อกได้');
            } else if (quantity < 1) {
                quantity = 1;
            }

            quantityInput.value = quantity;
            updateTotalPrice(productId);
            updateCartTotal();
            updateCart(productId, quantity);
        }

        function removeFromCart(productId) {
            fetch(`/cart/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('product-row-' + productId).remove();
                        updateCartTotal();
                        showToast('success', 'ลบสินค้าเสร็จสิ้น');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast('error', 'ไม่สามารถลบสินค้านี้ได้');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function showToast(icon, title) {
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
                icon: icon,
                title: title
            });
        }
    </script>
</body>

</html>
