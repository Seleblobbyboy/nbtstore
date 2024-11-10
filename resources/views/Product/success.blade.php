<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>สินค้า | ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/product/cart.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/product/shopping.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/product/success.css') }}">

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
                    <a href="{{ url('/cart/success', $Orders->OrderID) }}" class="active">ข้อมูลจัดส่ง</a>
                </div>
                <div class="line"></div>
                <div class="group">
                    <div class="pass">
                        <i class="fas fa-check"></i>
                    </div>
                    <a href="{{ url('/cart/success', $Orders->OrderID) }}" class="active">การชำระเงิน</a>
                </div>
                <div class="line"></div>
                <div class="group">
                    @if ($Orders->SlipImage)
                        <div class="pass">
                            <i class="fas fa-check"></i>
                        </div>
                    @else
                        <div class="select">
                            <i class="fas fa-dolly-flatbed"></i>
                        </div>
                    @endif

                    <a href="{{ url('/cart/success', $Orders->OrderID) }}" class="active">ยืนยันการสั่งซื้อ</a>
                </div>
            </div>
            <div class="card-cart">
                <div class="card-width">
                    <div class="head-h1">
                        <h1>ยืนยันการสั่งซื้อ</h1>
                        <div class="head-p">
                            <p>หมายเลขสั่งซื้อ : {{ $Orders->OrderID }}</p>
                            <p>วันที่สั่งซื้อ :
                                {{ \Carbon\Carbon::parse($Orders->OrderDate)->locale('th')->isoFormat('D MMMM YYYY เวลา HH:mm') }}
                            </p>
                        </div>
                    </div>
                    <div class="data-user">
                        <div class="address">
                            <h3><b>ข้อมูลจัดส่ง</b></h3>
                            <p>ชื่อ-นามสกุล : {{ $Orders->CustomerAddress->CustomerName }}</p>
                            <p>ที่อยู่ : {{ $Orders->CustomerAddress->Address }},
                                {{ $Orders->CustomerAddress->PostalCode }}, {{ $Orders->CustomerAddress->Province }},
                                {{ $Orders->CustomerAddress->District }}, {{ $Orders->CustomerAddress->Subdistrict }}</p>
                            <p>เบอร์โทรศัพท์ : {{ $Orders->CustomerAddress->PhoneNumber }}</p>
                            <p>อีเมล : {{ $Customers->Users->Email }}</p>
                        </div>
                        <div class="address-invoice">
                            <h3><b>ข้อมูลในการออกใบกำกับภาษี</b></h3>
                            @if (!$Invoice)
                                <p>- ไม่ต้องการรับใบกำกับภาษี -</p>
                            @else
                                <p>ชื่อ-นามสกุล : {{ $Invoice->FullName }}</p>
                                <p>รหัสบัตรประชาชน : {{ $Invoice->IDCardNumber }}</p>
                                <p>เบอร์โทรศัพท์ : {{ $Invoice->PhoneNumber }}</p>
                                @if ($Invoice->Address == null)
                                    <p>ที่อยู่ : {{ $Orders->CustomerAddress->Address }},
                                        {{ $Orders->CustomerAddress->PostalCode }},
                                        {{ $Orders->CustomerAddress->Province }},
                                        {{ $Orders->CustomerAddress->District }},
                                        {{ $Orders->CustomerAddress->Subdistrict }}</p>
                                @else
                                    <p>ที่อยู่ : {{ $Invoice->Address }}, {{ $Invoice->PostalCode }},
                                        {{ $Invoice->Province }}, {{ $Invoice->District }}, {{ $Invoice->Subdistrict }}
                                    </p>
                                @endif
                                <p>อีเมล : {{ $Customers->Users->Email }}</p>
                            @endif
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">สินค้า</th>
                                <th style="vertical-align: middle; text-align: center;" scope="col">ราคา/หน่วย</th>
                                <th style="vertical-align: middle; text-align: center;" scope="col">จำนวน</th>
                                <th style="vertical-align: middle; text-align: center;" scope="col">ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($OrderDetails as $OrderDetail)
                                <tr>
                                    <td scope="row" style="width: 7%;">
                                        <img src="{{ asset('storage/' . $OrderDetail->Products->productImages->first()->ImagePath ?? '') }}"
                                            alt="" style="width: 100%;">
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        {{ $OrderDetail->Products->ProductName }}</td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        {{ $OrderDetail->Products->Price }}</td>
                                    <td style="vertical-align: middle; text-align: center;">{{ $OrderDetail->Quantity }}
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">{{ $OrderDetail->SubTotal }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="summary">
                        <div class="group-sum">
                            <div class="everything-2">
                                <div class="details">
                                    <p>มูลค่าทียกเว้นภาษีมูลค่าเพิ่ม</p> <!-- ยอดรวมสินค้า -->
                                    <p>มูลค่าที่เสียภาษีมูลค่าเพิ่ม</p>
                                    <p>ภาษีมูลค่าเพิ่ม (7 %)</p>
                                    <p>* V - ภาษี,N - ภาษียกเว้น</p>
                                </div>
                                <div class="details-totle">
                                    <p>${{ number_format($totalProductAmount, 2) }}</p>
                                    <p>${{ number_format(9.35, 2) }}</p>
                                    <p>${{ number_format(0.65, 2) }}</p>
                                </div>
                            </div>
                            <div class="summary-t1">
                                <div class="details">
                                    <p>ยอกรวมสินค้า</p>
                                    <p>ค่าจัดส่งสินค้า</p>
                                </div>
                                <div class="details-totle">
                                    <p>${{ number_format($totalProductAmount, 2) }}</p>
                                    <p>${{ number_format(65, 2) }}</p> <!-- ค่าจัดส่งสินค้า -->
                                </div>
                            </div>
                            <div class="everything">
                                <p>ยอดรวมสุทธิ</p>
                                <p>${{ number_format($totalProductAmount + 65, 2) }}</p> <!-- ยอดรวมสุทธิ -->
                            </div>
                            <div class="Confirm-payment">
                                @if ($Orders->confirm == 2)
                                    <form action="{{ route('orders.editloadSlip', $Orders->OrderID) }}"
                                        method="POST"enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" id="file-upload" name="slip_image" accept="image/*"
                                            onchange="previewImage(event)" style="display:none;">
                                        <label for="file-upload" class="custom-file-upload">อัปโหลดสลิปการโอนเงิน</label>
                                        <input type="submit" value="ยืนยันการชำระเงินอีกครั้ง" class="btn-warning">
                                    </form>
                                @else
                                    <form action="{{ route('orders.uploadSlip', $Orders->OrderID) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <!-- ใช้ input หนึ่งตัวสำหรับการเลือกและแสดงตัวอย่างรูป -->
                                        <input type="file" id="file-upload" name="slip_image" accept="image/*"
                                            onchange="previewImage(event)" style="display:none;">

                                        <!-- ปุ่มสำหรับเลือกไฟล์ โดยคลิกที่ label นี้จะไปเปิด input file -->
                                        <label for="file-upload" class="custom-file-upload">อัปโหลดสลิปการโอนเงิน</label>



                                        <input type="submit" value="ยืนยันการชำระเงิน">

                                    </form>
                                @endif

                            </div>

                        </div>
                        <div class="summary-t2">

                            <div class="status">
                                @if ($Orders->confirm == 1)
                                    <h5> สถานะการชำระเงิน : <span class="text-success">ชำระเงินสำเร็จ</span></h5>
                                    <p>สามารถติดตามสถานะการจัดส่งได้ที่หน้า <a href="">รายการสินค้าที่สั่งซื้อ</a></p>
                                @elseif ($Orders->confirm == 2)
                                    <h5> สถานะการชำระเงิน : <span class="text-danger">ชำระเงินไม่สำเร็จ</span></h5>
                                    <p>{{ $Orders->Comment }}</p>
                                @elseif ($Orders->SlipImage)
                                    <h5> สถานะการชำระเงิน : <span class="text-warning">รอการตรวจสอบ</span></h5>
                                    <p>เจ้าหน้าที่ตรวจสอบสลีปการชำระเงิน ตรงกับสินค้าหรือไหม โปรดตรวจสอบ</p>
                                @else
                                    <h5> สถานะการชำระเงิน : <span>รอการชำระเงิน</span></h5>
                                @endif
                            </div>
                            <div class="accordion accordion-flush" id="accordionFlush">
                                <div class="accordion-item bg-dark2 mb-3">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed border" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapse1"
                                            aria-expanded="false" aria-controls="flush-collapse1">
                                            <i class="fa-solid fa-qrcode fa-xl me-4"></i> ชำระเงินด้วย QR-Code
                                        </button>
                                    </h2>
                                    <div id="flush-collapse1" class="accordion-collapse collapse text-center mt-3"
                                        data-bs-parent="#accordionFlush">
                                        <div class="pay">
                                            <div class="head-pay">
                                                <img src="{{ url('assets/img/ThaiQR.png') }}" alt="">
                                            </div>
                                            <div class="prompay">
                                                <div class="prom-img">
                                                    <img src="{{ url('assets/img/prompt-pay-logo.png') }}"
                                                        alt="">
                                                </div>
                                                <img id="promptpay-qr-code" src="" style="width: 40%;"
                                                    alt="QR Code สำหรับ PromptPay">
                                            </div>
                                            <div class="name-pay">
                                                <small>สแกน QR เพื่อ โอนเงินเข้าบัญชี</small>
                                                <h3>บริษัท NBT SUPPLY</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion accordion-flush" id="accordionFlush">
                                <div class="accordion-item bg-dark2 mb-3"">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed border" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapse3"
                                            aria-expanded="false" aria-controls="flush-collapse2">
                                            <i class="fas fa-file-upload fa-xl me-4"></i>รูปภาพสลีปที่อัปโหลด
                                        </button>
                                    </h2>
                                    <div id="flush-collapse3" class="accordion-collapse collapse text-center mt-3"
                                        data-bs-parent="#accordionFlush">
                                        <div id="photo-container">
                                            <!-- ถ้าไม่มีรูปภาพ ให้แสดงข้อความ -->
                                            @if ($Orders->confirm == 2)
                                            <div id="no-image-placeholder" style="display: flex;" class="show-img">
                                                ไม่มีภาพที่อัปโหลด
                                            </div>
                                            @else
                                            <div id="no-image-placeholder" style="display: flex;" class="show-img">
                                                ไม่มีภาพที่อัปโหลด
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($Orders->SlipImage)
                                <div class="accordion accordion-flush" id="accordionFlush">
                                    <div class="accordion-item bg-dark2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed border" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapse2"
                                                aria-expanded="false" aria-controls="flush-collapse2">
                                                <i class="fas fa-check fa-xl me-4"></i></i> รูปภาพสลีปที่อัปโหลดแล้ว
                                            </button>
                                        </h2>
                                        <div id="flush-collapse2" class="accordion-collapse collapse text-center mt-3"
                                            data-bs-parent="#accordionFlush">
                                            <div id="photo-container">
                                                @if ($Orders->SlipImage)
                                                    <!-- ถ้ามีรูปภาพในระบบแล้ว ให้แสดงตรงนี้เลย -->
                                                    <img src="{{ asset('storage/' . $Orders->SlipImage) }}"
                                                        alt="Slip Image" style="max-width: 100%; max-height: 400px;">
                                                @else
                                                    <!-- ถ้าไม่มีรูปภาพ ให้แสดงข้อความ -->
                                                    <div id="no-image-placeholder" style="display: flex;"
                                                        class="show-img">
                                                        ไม่มีภาพที่อัปโหลด
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection

    <script>
        function previewImage(event) {
            const container = document.getElementById('photo-container');
            const placeholder = document.getElementById('no-image-placeholder');

            // ล้างภาพที่เคยอัปโหลดมาก่อน (ถ้ามี)
            container.innerHTML = '';

            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function() {
                    const newImage = document.createElement('img');
                    newImage.src = reader.result;
                    newImage.alt = 'Uploaded Image';
                    newImage.style.maxWidth = '100%';
                    newImage.style.maxHeight = '400px';

                    // เพิ่มภาพใหม่ใน container และซ่อน placeholder
                    container.appendChild(newImage);
                    placeholder.style.display = 'none';
                };

                reader.readAsDataURL(file);
            } else {
                // ถ้าไม่ได้เลือกไฟล์รูปภาพ ให้แสดงข้อความ placeholder
                placeholder.style.display = 'flex';
            }
        }
    </script>
    <script>
        function updateImage(event) {
            const container = document.getElementById('photo-container');
            const placeholder = document.getElementById('no-image-placeholder');

            // ล้างภาพที่เคยอัปโหลดมาก่อน (ถ้ามี)
            container.innerHTML = '';

            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function() {
                    const newImage = document.createElement('img');
                    newImage.src = reader.result;
                    newImage.alt = 'Uploaded Image';
                    newImage.style.maxWidth = '100%';
                    newImage.style.maxHeight = '400px';

                    // เพิ่มฟังก์ชันคลิกเพื่อลบภาพ
                    newImage.onclick = function() {
                        container.innerHTML = ''; // ลบภาพออกจาก container
                        placeholder.style.display = 'flex'; // แสดงข้อความ placeholder
                    };

                    // เพิ่มภาพใหม่ใน container และซ่อน placeholder
                    container.appendChild(newImage);
                    placeholder.style.display = 'none';
                };

                reader.readAsDataURL(file);
            } else {
                // ถ้าไม่ได้เลือกไฟล์รูปภาพ ให้แสดงข้อความ placeholder
                placeholder.style.display = 'flex';
            }

            // ล้างค่า input file เพื่อให้สามารถเลือกไฟล์เดียวกันได้อีกครั้ง
            event.target.value = '';
        }
    </script>
    <script>
        const promptPayPhone = "0652763408"; // หมายเลข PromptPay ที่คุณต้องการ
        let productTotal = {{ $Orders->TotalAmount }};
        let shippingCost = 0; // ค่าจัดส่ง
        let totalAmount = (productTotal + shippingCost).toFixed(2); // จำกัดทศนิยมสองตำแหน่ง

        // ฟังก์ชันอัปเดต QR Code ของ PromptPay
        function updatePromptPayQRCode() {
            const qrCodeURL = `https://promptpay.io/${promptPayPhone}/${totalAmount}`;
            document.getElementById('promptpay-qr-code').src = qrCodeURL;
        }

        document.addEventListener("DOMContentLoaded", function() {
            updatePromptPayQRCode(); // สร้าง QR Code
        });
    </script>
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
    @if (session('success'))
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
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            });
        </script>
    @endif
</body>

</html>
