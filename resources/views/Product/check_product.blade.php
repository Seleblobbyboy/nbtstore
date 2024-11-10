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
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <a href="{{ url('/cart/success', $Orders->OrderID) }}" class="active">ยืนยันการชำระเงิน</a>
                </div>
                <div class="line"></div>
                <div class="group">
                    <div class="select-no">
                        <i class="fas fa-truck"></i>
                    </div>
                    <a href="{{ url('/cart/success', $Orders->OrderID) }}" class="active">เตรียมจัดส่ง</a>
                </div>
                <div class="line"></div>
                <div class="group">

                    <div class="select-no">
                        <i class="fas fa-shipping-fast"></i>
                    </div>

                    <a href="{{ url('/cart/success', $Orders->OrderID) }}" class="active">จัดส่งสินค้า</a>
                </div>
            </div>
            <div class="card-cart">
                <div class="card-width">
                    <div class="head-h1">
                        @if ($Orders->confirm == 1)
                        <h1 class="text-success">ยืนยันการชำระเงินสำเร็จ</h1>
                        @else
                        <h1>คำสั่งซื้อสินค้า</h1>
                        @endif
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


                        </div>
                        <div class="summary-t2">

                            <div class="status">
                                @if ($Orders->confirm == 1)
                                    <h5> สถานะการชำระเงิน : <span class="text-success">ชำระเงินสำเร็จ</span></h5>
                                    <p>ทางพนักงานของเรากำลังเร่งดำเนินการจัดเตรียมสินค้าให้กับคุณอย่างพิถีพิถัน
                                        เพื่อให้แน่ใจว่าสินค้าทุกชิ้นจะถูกบรรจุและจัดส่งอย่างสมบูรณ์แบบ
                                        โปรดวางใจได้ว่าคำสั่งซื้อของคุณอยู่ในมือที่เชื่อถือได้
                                        และเราจะจัดส่งให้คุณโดยเร็วที่สุด ขอบคุณที่ไว้วางใจเลือกใช้บริการของเรา</a>
                                    </p>
                                @endif
                            </div>
                            @if ($Orders->SlipImage)
                                <div class="accordion accordion-flush" id="accordionFlush">
                                    <div class="accordion-item bg-dark2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed border border-danger border-3" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapse2"
                                                aria-expanded="false" aria-controls="flush-collapse2">
                                                @if ($Orders->confirm == 1)
                                                <i class="fas fa-check fa-xl me-4 text-success"></i></i>
                                                <p class="text-success">รูปภาพสลีปที่ผ่านการตรวจสอบแล้ว</p>
                                                @else
                                                <i class="fas fa-check fa-xl me-4 text-danger"></i></i>
                                                <p class="text-danger">รูปภาพสลีปที่ยังไม่ผ่านการตรวจสอบ</p>
                                                @endif

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
                                                    <div id="no-image-placeholder" style="display: flex;" class="show-img">
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