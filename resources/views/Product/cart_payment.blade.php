<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>สินค้า | ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/product.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/product/cart.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/product/shopping.css') }}">

    <style>
        /* ซ่อนส่วนของฟอร์มใบกำกับภาษีในตอนเริ่มต้น */
        .form-invoice {
            display: none;
        }
    </style>
</head>

<body>
    @extends('layouts.navigation')
    @section('breadcrum')
    @endsection
    @section('content')
        <div class="hea-cart">
            <div class="head-Condition">
                <div class="group">
                    <div class="pass">
                        <i class="fas fa-check"></i>
                    </div>
                    <a href="{{ url('/cart/shopping') }}" class="active">ข้อมูลจัดส่ง</a>
                </div>
                <div class="line"></div>
                <div class="group">
                    <div class="select">
                        <i class="far fa-credit-card"></i>
                    </div>
                    <a href="{{ url('/cart/payment') }}" class="active">การชำระเงิน</a>

                </div>
                <div class="line"></div>
                <div class="group">
                    <div class="select-no">
                        <i class="fas fa-dolly-flatbed"></i>
                    </div>
                    <a href="{{ url('/cart/payment') }}" class="active">ยืนยันการสั่งซื้อ</a>
                </div>
            </div>
            <div class="card-cart">
                <div class="card-left">
                    <h5>วิธีการชำระเงิน</h5>
                    <p class="p-h"><b><span>*</span>ระบบการชำระเงิน</b> ปัจจุบันรองรับการชำระเงินผ่าน PromptPay เท่านั้น</p>
                    <div class="prompay-card">
                        <div class="p-p">
                            <i class="fa-solid fa-qrcode fa-xl me-4"></i> ชำระเงินด้วย QR-Code
                        </div>
                        <i class="fas fa-check-square"></i>
                    </div>
                </div>
                <div class="card-rigth">
                    <h5>ที่อยู่ในการจัดส่ง</h5>
                    <div class="card-method2">
                        <div class="g1">
                            <div class="card-name2">
                                <p><b>{{ $CustomerAddress->CustomerName }}</b> {{ $CustomerAddress->PhoneNumber }}</p>
                                <small>{{ $CustomerAddress->Address }},
                                    {{ $CustomerAddress->PostalCode }},{{ $CustomerAddress->Province }},
                                    {{ $CustomerAddress->District }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="sum">
                        <p>จำนวนสินค้า: <span id="total-quantity">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                            ชิ้น</p>
                        <p class="sum-total">
                            ${{ number_format(array_sum(array_map(fn($Product) => $Product['Price'] * $Product['quantity'], $cart)), 2) }}
                        </p>
                    </div>
                    <div class="sum">
                        <p>ค่าจัดส่งสินค้า</p>
                        <p>$65</p>
                    </div>
                    <div class="totle">
                        <p>ยอดรวมสุทธิ</p>
                        <p id="cart-total">
                            ${{ number_format(array_sum(array_map(fn($Product) => $Product['Price'] * $Product['quantity'], $cart)) + 65, 2) }}
                        </p>
                    </div>
                    <form id="checkoutForm" action="{{ route('cart.checkout') }}" method="POST" style="display: inline;">
                        @csrf
                    </form>
                    <a href="javascript:void(0);" onclick="document.getElementById('checkoutForm').submit();"
                        class="Order">ถัดไป</a>
                </div>
            </div>
        </div>
    @endsection

    {{-- <script>
        const promptPayPhone = "0652763408"; // ใส่เบอร์ PromptPay ที่คุณต้องการ
        let productTotal = {{ array_sum(array_map(fn($Product) => $Product['Price'] * $Product['quantity'], $cart)) }};
        let shippingCost = 65; // ค่าจัดส่ง
        let totalAmount = productTotal + shippingCost;

        // ฟังก์ชันอัปเดต QR Code ของ PromptPay
        function updatePromptPayQRCode() {
            // URL ของ PromptPay.io สำหรับสร้าง QR Code (แปลงยอดรวมเป็น 2 ทศนิยม)
            const qrCodeURL = `https://promptpay.io/${promptPayPhone}/${totalAmount.toFixed(2)}`;

            // ตั้งค่า src ของ <img> แท็ก เพื่อแสดง QR Code
            document.getElementById('promptpay-qr-code').src = qrCodeURL;
        }

        // เรียกใช้ฟังก์ชันเมื่อโหลดหน้า
        document.addEventListener("DOMContentLoaded", function() {
            updatePromptPayQRCode(); // สร้าง QR Code
        });
    </script> --}}
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
    <script>
        let productTotal = {{ array_sum(array_map(fn($Product) => $Product['Price'] * $Product['quantity'], $cart)) }};
        let shippingCost = 65; // ค่าจัดส่ง

        // ฟังก์ชันอัปเดตยอดรวมของรถเข็นที่รวมค่าจัดส่ง
        function updateCartTotal() {
            // อัปเดตยอดรวมที่ยังไม่รวมค่าจัดส่ง
            document.getElementById('sum-total').textContent = `$${productTotal.toFixed(2)}`;

            // แสดงยอดรวมสุทธิที่รวมค่าจัดส่งแล้ว
            document.getElementById('cart-total').textContent = `$${(productTotal + shippingCost).toFixed(2)}`;
        }

        // เรียกใช้ฟังก์ชันเมื่อโหลดหน้า
        document.addEventListener("DOMContentLoaded", function() {
            updateCartTotal();
        });
    </script>
    <script>
        // ฟังก์ชันเปิด/ปิดการแสดงฟอร์มใบกำกับภาษี
        function toggleInvoiceForm() {
            const invoiceForm = document.getElementById('form-invoice');
            const needInvoice = document.getElementById('need-invoice').checked;
            // Toggle form display
            invoiceForm.style.display = needInvoice ? 'block' : 'none';

            // Toggle required attribute
            document.getElementById('invoice_full_name').required = needInvoice;
            document.getElementById('id_card').required = needInvoice;
            document.getElementById('invoice_phone').required = needInvoice;
            document.getElementById('invoice_address').required = needInvoice;
            document.getElementById('invoice_postal_code').required = needInvoice;
            document.getElementById('invoice_province').required = needInvoice;
            document.getElementById('invoice_district').required = needInvoice;
            document.getElementById('invoice_sub_district').required = needInvoice;
        }

        // ฟังก์ชันเปิด/ปิดการป้อนข้อมูลที่อยู่
        function toggleAddressFields() {
            const sameAddress = document.getElementById('same-address').checked;
            const addressFields = [
                document.getElementById('invoice_address'),
                document.getElementById('invoice_postal_code'),
                document.getElementById('invoice_province'),
                document.getElementById('invoice_district'),
                document.getElementById('invoice_sub_district')
            ];

            addressFields.forEach(field => {
                field.disabled = sameAddress;
                field.style.backgroundColor = sameAddress ? '#e9e9e9' : '';
            });
        }
    </script>
</body>

</html>
