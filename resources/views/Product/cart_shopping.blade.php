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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <div class="select">
                        <i class="fas fa-truck"></i>
                    </div>
                    <a href="{{ url('/cart/shopping') }}" class="active">ข้อมูลจัดส่ง</a>
                </div>
                <div class="line">
                </div>
                <div class="group">
                    <div class="select-no">
                        <i class="far fa-credit-card"></i>
                    </div>
                    <a href="{{ url('/cart/payment') }}" class="active">การชำระเงิน</a>
                </div>

                <div class="line">

                </div>
                <div class="group">
                    <div class="select-no">
                        <i class="fas fa-dolly-flatbed"></i>
                    </div>
                    <a href="{{ url('/cart/success') }}" class="active">ยืนยันการสั่งซื้อ</a>

                </div>

            </div>

            <div class="card-cart">
                <div class="card-left">
                    <h5>ที่อยู่ในการจัดส่ง</h5>
                    <form action="{{ route('store.customer.info') }}" method="post">
                        @csrf
                        <div class="group-from">
                            <div class="g2-group">
                                <label for="full_name">ชื่อนามสกุล</label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>
                            <div class="g2-group">
                                <label for="phone">เบอร์โทรศัพท์</label>
                                <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}"
                                    placeholder="ตัวอย่าง: 0812345678">
                            </div>
                        </div>

                        <label for="address">ที่อยู่</label>
                        <textarea name="Description" id="Description" cols="30" rows="5" placeholder="Enter product description"
                            style="resize: none;" required></textarea>

                        <div class="group-from">
                            <div class="g1-group">
                                <label for="postal_code">รหัสไปรษณีย์</label>
                                <input type="number" id="postal_code" name="postal_code" required
                                    placeholder="ตัวอย่าง: 33140">
                            </div>
                            <div class="g1-group">
                                <label for="province">จังหวัด</label>
                                <select id="province" name="province" required>
                                    <option value="">- กรุณาเลือก -</option>
                                </select>
                            </div>
                            <div class="g1-group">
                                <label for="district">เขต/อำเภอ</label>
                                <select id="district" name="district" required>
                                    <option value="">- กรุณาเลือก -</option>
                                </select>
                            </div>
                            <div class="g1-group">
                                <label for="sub_district">แขวง/ตำบล</label>
                                <select id="sub_district" name="sub_district" required>
                                    <option value="">- กรุณาเลือก -</option>
                                </select>
                            </div>

                        </div>

                        <div class="button-submit">
                            <div class="Need-invoice">
                                <input type="checkbox" id="need-invoice" name="need_invoice" onclick="toggleInvoiceForm()">
                                ต้องการใบกำกับภาษี
                            </div>
                            <input type="submit" value="บันทึก">
                        </div>
                        <!-- ส่วนฟอร์มใบกำกับภาษี -->
                        <div class="form-invoice" id="form-invoice">
                            <h3>เพิ่มข้อมูลสำหรับออกใบกำกับภาษี</h3>
                            <p>กรุณาตรวจสอบข้อมูลของท่านก่อนยืนยันการทำรายการสั่งซื้อ...</p>

                            <div class="group-from">
                                <div class="g2-group">
                                    <label for="invoice_full_name">ชื่อนามสกุล</label>
                                    <input type="text" id="invoice_full_name" name="invoice_full_name">
                                </div>
                                <div class="g2-group">
                                    <label for="id_card">เลขที่บัตรประชาชน*</label>
                                    <input type="text" id="id_card" name="id_card" maxlength="13" pattern="\d{13}"
                                        placeholder="กรอก 13 ตัวเลข">
                                </div>
                            </div>

                            <div class="group-from">
                                <div class="g2-group">
                                    <label for="invoice_phone">เบอร์โทรศัพท์</label>
                                    <input type="tel" id="invoice_phone" name="invoice_phone" pattern="[0-9]{10}"
                                        placeholder="ตัวอย่าง: 0812345678">
                                </div>
                            </div>

                            <div class="Need-invoice">
                                <input type="checkbox" id="same-address" onclick="toggleAddressFields()">
                                ใช้ที่อยู่เดียวกับที่อยู่ในการจัดส่ง
                            </div>


                            <label for="invoice_address">ที่อยู่</label>
                            <textarea name="invoice_address" id="invoice_address" cols="30" rows="5" placeholder="Enter address"
                                style="resize: none;"></textarea>



                            <div class="group-from">
                                <div class="g1-group">
                                    <label for="invoice_postal_code">รหัสไปรษณีย์</label>
                                    <input type="number" id="invoice_postal_code" name="invoice_postal_code" required
                                        placeholder="ตัวอย่าง: 10110">
                                </div>
                                <div class="g1-group">
                                    <label for="invoice_province">จังหวัด</label>
                                    <select id="invoice_province" name="invoice_province" required>
                                        <option value="">- กรุณาเลือก -</option>
                                    </select>
                                </div>
                                <div class="g1-group">
                                    <label for="invoice_district">เขต/อำเภอ</label>
                                    <select id="invoice_district" name="invoice_district" required>
                                        <option value="">- กรุณาเลือก -</option>
                                    </select>
                                </div>
                                <div class="g1-group">
                                    <label for="invoice_sub_district">แขวง/ตำบล</label>
                                    <select id="invoice_sub_district" name="invoice_sub_district" required>
                                        <option value="">- กรุณาเลือก -</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </form>


                </div>
                <div class="card-rigth">
                    <h5>สรุปรายการสั่งซื้อ</h5>
                    <div class="Shipping-method">
                        <p>วิธีการจัดส่ง</p>
                        <div class="card-method">

                            <div class="select-card">
                                <input type="radio" id="option1" name="shipping_method" value="option1" checked>
                            </div>

                            <div class="select-img">
                                <div class="img">
                                    <img src="{{ url('assets/img/Screenshot.png') }}" alt="">
                                </div>
                            </div>
                            <div class="card-name">
                                <p><b>ไปรษณีย์ไทย</b> - EMS โอนเงิน ขนส่งด่วน ค่าจัดส่งเริ่มต้น 39 บาท</p>
                                <small>ระยะเวลาขนส่ง 1-2 วัน</small>
                            </div>
                            <div class="price">
                                <p>$65</p>
                            </div>
                        </div>
                        {{-- <div class="card-method">

                            <div class="select-card">
                                <input type="radio" id="option1" name="shipping_method" value="option1">
                            </div>

                            <div class="select-img">
                                <div class="img">
                                    <img src="{{ url('assets/img/Screenshot.png') }}" alt="">
                                </div>
                            </div>
                            <div class="card-name">
                                <p><b>ไปรษณีย์ไทย</b> - EMS เก็บเงินปลายทาง ขนส่งด่วน เรื่มต้น 47 บาท</p>
                                <small>ระยะเวลาขนส่ง 1-2 วัน</small>
                                <small>(รองรับการชำระเงินปลายทาง)</small>
                            </div>
                            <div class="price">
                                <p>$65</p>
                            </div>
                        </div> --}}
                    </div>
                    <div class="sum">
                        <p>จำนวนสินค้า: <span id="total-quantity">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                            ชิ้น</p>
                        <p class="sum-total" id="sum-total">
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
                            ${{ number_format(array_sum(array_map(fn($Product) => $Product['Price'] * $Product['quantity'], $cart)), 2) }}
                        </p>
                    </div>
                    <a href="{{ route('cart.payment') }}" class="Order">ถัดไป</a>
                </div>
            </div>
        </div>

        @if ($CustomerAddress)
            @foreach ($CustomerAddress as $item)
                <div class="card-method2">
                    <div class="g1">
                        <div class="select-card2">
                            @if (session('address') == $item->AddressID)
                                <a href="{{ url('/cart/address', $item->AddressID) }}" class="select-btn2"><i
                                        class="fas fa-check-square"></i></a>
                            @else
                                <a href="{{ url('/cart/address', $item->AddressID) }}" class="select-btn2"><i
                                        class="far fa-check-square"></i></a>
                            @endif
                        </div>
                        <div class="card-name2">
                            <p><b>{{ $item->CustomerName }}</b> {{ $item->PhoneNumber }}</p>
                            <small>{{ Str::limit($item->Address, 35, '...') }},{{ $item->PostalCode }},{{ $item->Province }},{{ $item->District }},{{ $item->Subdistrict }}</small>
                        </div>
                    </div>
                    <div class="edit">
                        <a href="{{ route('customer.destroy', $item->AddressID) }}"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            @endforeach
        @endif

        {{-- {{ dd(session('address')) }} --}}

    @endsection
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
                });

                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            });
        </script>
    @endif
    <script>
        function limitLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const postalCodeInput = document.getElementById("postal_code");
            const provinceSelect = document.getElementById("province");
            const districtSelect = document.getElementById("district");
            const subDistrictSelect = document.getElementById("sub_district");

            const locations = @json($Locations);

            function populateProvinces() {
                const provinces = [...new Set(locations.map(location => location.province_thai))];
                let provinceOptions = '<option value="">- กรุณาเลือก -</option>';
                provinces.forEach(province => {
                    provinceOptions += `<option value="${province}">${province}</option>`;
                });
                provinceSelect.innerHTML = provinceOptions;
            }

            function populateDistricts(province) {
                const filteredLocations = locations.filter(location => location.province_thai === province);
                const districts = [...new Set(filteredLocations.map(loc => loc.district_thai_short))];

                let districtOptions = '<option value="">- กรุณาเลือก -</option>';
                districts.forEach(district => {
                    districtOptions += `<option value="${district}">${district}</option>`;
                });
                districtSelect.innerHTML = districtOptions;

                subDistrictSelect.innerHTML = '<option value="">- กรุณาเลือก -</option>';
            }

            function populateSubDistricts(district) {
                const selectedProvince = provinceSelect.value;
                const filteredLocations = locations.filter(location => location.province_thai ===
                    selectedProvince && location.district_thai_short === district);
                const subDistricts = [...new Set(filteredLocations.map(loc => loc.tambon_thai_short))];

                let subDistrictOptions = '<option value="">- กรุณาเลือก -</option>';
                subDistricts.forEach(subDistrict => {
                    subDistrictOptions += `<option value="${subDistrict}">${subDistrict}</option>`;
                });
                subDistrictSelect.innerHTML = subDistrictOptions;
            }

            function populatePostalCode(subDistrict) {
                const selectedProvince = provinceSelect.value;
                const selectedDistrict = districtSelect.value;
                const filteredLocation = locations.find(location =>
                    location.province_thai === selectedProvince &&
                    location.district_thai_short === selectedDistrict &&
                    location.tambon_thai_short === subDistrict
                );

                postalCodeInput.value = filteredLocation ? filteredLocation.post_code : postalCodeInput.value;
            }

            postalCodeInput.addEventListener("input", function() {
                const postalCode = postalCodeInput.value;
                const filteredLocations = locations.filter(location => location.post_code === postalCode);

                if (filteredLocations.length > 0) {
                    const province = filteredLocations[0].province_thai;
                    provinceSelect.value = province;
                    populateDistricts(province);

                    const districts = [...new Set(filteredLocations.map(loc => loc.district_thai_short))];
                    districtSelect.innerHTML = districts.map(district =>
                        `<option value="${district}">${district}</option>`).join('');
                    districtSelect.value = districts[0];

                    const subDistricts = filteredLocations.filter(loc => loc.district_thai_short ===
                            districts[0])
                        .map(loc => loc.tambon_thai_short);
                    subDistrictSelect.innerHTML = subDistricts.map(subDistrict =>
                        `<option value="${subDistrict}">${subDistrict}</option>`).join('');
                    subDistrictSelect.value = subDistricts[0];
                }
            });

            provinceSelect.addEventListener("change", function() {
                populateDistricts(provinceSelect.value);
            });

            districtSelect.addEventListener("change", function() {
                populateSubDistricts(districtSelect.value);
            });

            subDistrictSelect.addEventListener("change", function() {
                populatePostalCode(subDistrictSelect.value);
            });

            populateProvinces();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const invoicePostalCodeInput = document.getElementById("invoice_postal_code");
            const invoiceProvinceSelect = document.getElementById("invoice_province");
            const invoiceDistrictSelect = document.getElementById("invoice_district");
            const invoiceSubDistrictSelect = document.getElementById("invoice_sub_district");

            const locations = @json($Locations);

            function populateInvoiceProvinces() {
                const provinces = [...new Set(locations.map(location => location.province_thai))];
                let provinceOptions = '<option value="">- กรุณาเลือก -</option>';
                provinces.forEach(province => {
                    provinceOptions += `<option value="${province}">${province}</option>`;
                });
                invoiceProvinceSelect.innerHTML = provinceOptions;
            }

            function populateInvoiceDistricts(province) {
                const filteredLocations = locations.filter(location => location.province_thai === province);
                const districts = [...new Set(filteredLocations.map(loc => loc.district_thai_short))];

                let districtOptions = '<option value="">- กรุณาเลือก -</option>';
                districts.forEach(district => {
                    districtOptions += `<option value="${district}">${district}</option>`;
                });
                invoiceDistrictSelect.innerHTML = districtOptions;

                invoiceSubDistrictSelect.innerHTML = '<option value="">- กรุณาเลือก -</option>';
            }

            function populateInvoiceSubDistricts(district) {
                const selectedProvince = invoiceProvinceSelect.value;
                const filteredLocations = locations.filter(location => location.province_thai ===
                    selectedProvince && location.district_thai_short === district);
                const subDistricts = [...new Set(filteredLocations.map(loc => loc.tambon_thai_short))];

                let subDistrictOptions = '<option value="">- กรุณาเลือก -</option>';
                subDistricts.forEach(subDistrict => {
                    subDistrictOptions += `<option value="${subDistrict}">${subDistrict}</option>`;
                });
                invoiceSubDistrictSelect.innerHTML = subDistrictOptions;
            }

            function populateInvoicePostalCode(subDistrict) {
                const selectedProvince = invoiceProvinceSelect.value;
                const selectedDistrict = invoiceDistrictSelect.value;
                const filteredLocation = locations.find(location =>
                    location.province_thai === selectedProvince &&
                    location.district_thai_short === selectedDistrict &&
                    location.tambon_thai_short === subDistrict
                );

                invoicePostalCodeInput.value = filteredLocation ? filteredLocation.post_code :
                    invoicePostalCodeInput.value;
            }

            invoicePostalCodeInput.addEventListener("input", function() {
                const postalCode = invoicePostalCodeInput.value;
                const filteredLocations = locations.filter(location => location.post_code === postalCode);

                if (filteredLocations.length > 0) {
                    const province = filteredLocations[0].province_thai;
                    invoiceProvinceSelect.value = province;
                    populateInvoiceDistricts(province);

                    const districts = [...new Set(filteredLocations.map(loc => loc.district_thai_short))];
                    invoiceDistrictSelect.innerHTML = districts.map(district =>
                        `<option value="${district}">${district}</option>`).join('');
                    invoiceDistrictSelect.value = districts[0];

                    const subDistricts = filteredLocations.filter(loc => loc.district_thai_short ===
                            districts[0])
                        .map(loc => loc.tambon_thai_short);
                    invoiceSubDistrictSelect.innerHTML = subDistricts.map(subDistrict =>
                        `<option value="${subDistrict}">${subDistrict}</option>`).join('');
                    invoiceSubDistrictSelect.value = subDistricts[0];
                }
            });

            invoiceProvinceSelect.addEventListener("change", function() {
                populateInvoiceDistricts(invoiceProvinceSelect.value);
            });

            invoiceDistrictSelect.addEventListener("change", function() {
                populateInvoiceSubDistricts(invoiceDistrictSelect.value);
            });

            invoiceSubDistrictSelect.addEventListener("change", function() {
                populateInvoicePostalCode(invoiceSubDistrictSelect.value);
            });

            populateInvoiceProvinces();
        });
    </script>

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
        function toggleInvoiceForm() {
            const invoiceForm = document.getElementById('form-invoice');
            const needInvoice = document.getElementById('need-invoice').checked;

            // Toggle form display
            invoiceForm.style.display = needInvoice ? 'block' : 'none';

            // Toggle required attribute based on checkbox status
            document.getElementById('invoice_full_name').required = needInvoice;
            document.getElementById('id_card').required = needInvoice;
            document.getElementById('invoice_phone').required = needInvoice;
            document.getElementById('invoice_address').required = needInvoice;
            document.getElementById('invoice_postal_code').required = needInvoice;
            document.getElementById('invoice_province').required = needInvoice;
            document.getElementById('invoice_district').required = needInvoice;
            document.getElementById('invoice_sub_district').required = needInvoice;
        }

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

        function validateForm() {
            const needInvoice = document.getElementById('need-invoice').checked;
            let isValid = true;

            if (needInvoice) {
                // Validate invoice fields
                const invoiceFields = [
                    'invoice_full_name',
                    'id_card',
                    'invoice_phone',
                    'invoice_address',
                    'invoice_postal_code',
                    'invoice_province',
                    'invoice_district',
                    'invoice_sub_district'
                ];

                invoiceFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field.required && !field.value) {
                        isValid = false;
                        field.style.borderColor = 'red'; // Highlight empty required fields
                    } else {
                        field.style.borderColor = ''; // Reset border if filled
                    }
                });
            }

            return isValid; // Return the validation status
        }

        // Call the toggle function on page load to set the initial state
        document.addEventListener("DOMContentLoaded", function() {
            toggleInvoiceForm(); // Initialize visibility of the invoice form
        });
    </script>
</body>

</html>
