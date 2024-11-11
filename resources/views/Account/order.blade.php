<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ url('assets/CSS/Profile/profiledata.css') }}">

    <title>Document</title>
</head>

<body>
    @extends('layouts.navigatuonuser')
    @section('content-user')
        <h3>ประวัติการสั่งซื้อ</h3>
        <div class="search">
            <form action="{{ url('/profile/order') }}" method="get">
                <select name="select" id="">
                    <option value="">- สถานะทั้งหมด -</option>
                    <option value="1" {{ request('select') == '1' ? 'selected' : '' }}>ชำระเงินสำเร็จ</option>
                    <option value="2" {{ request('select') == '2' ? 'selected' : '' }}>ชำระเงินไม่สำเร็จ</option>
                    <option value="3" {{ request('select') == '3' ? 'selected' : '' }}>แก้ไขการชำระเงินแล้ว</option>
                    <option value="4" {{ request('select') == '4' ? 'selected' : '' }}>ยังไม่ได้ชำระเงิน</option>
                    <option value="5" {{ request('select') == '5' ? 'selected' : '' }}>รอตรวจสอบ</option>
                    <option value="6" {{ request('select') == '6' ? 'selected' : '' }}>เตรียมจัดส่ง</option>
                    <option value="7" {{ request('select') == '7' ? 'selected' : '' }}>จัดส่งสินค้า</option>
                </select>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="name-data">
            <div class="accordion accordion-flush" id="accordionFlush">
                <div class="accordion-item bg-dark2">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed border" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
                            <i class="fas fa-shopping-cart fa-xl me-4"></i>
                            รายการประวัติการสั่งซื้อ
                        </button>
                    </h2>
                    <div id="flush-collapse2" class="accordion-collapse collapse text-center mt-3"
                        data-bs-parent="#accordionFlush">
                        <table class="table ">
                            <thead class="table-dark">
                                <tr>
                                    <th>
                                        รหัสออเดอร์
                                    </th>
                                    <th>
                                        ผู้สั่งซื้อ
                                    </th>
                                    <th>
                                        รายการสินค้า
                                    </th>
                                    <th>
                                        ราคาทั้งหมด
                                    </th>
                                    <th>
                                        สถานะ
                                    </th>
                                    <th>
                                        จัดการ
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Orders as $order)
                                    <tr>
                                        <td>{{ $order->OrderID }}</td>
                                        <td>{{ $order->CustomerAddress->CustomerName }}</td>
                                        <td>{{ $orderDetailsSummary[$order->OrderID] ?? 'ไม่มีข้อมูล' }}</td>
                                        <td>{{ $order->TotalAmount }}</td>
                                        <td>
                                            @if ($order->confirm == 1)
                                                <span class="text-success">ชำระเงินสำเร็จ</span>
                                            @elseif ($order->confirm == 6)
                                            <span class="text-success">เตรียมจัดส่ง
                                            </span>
                                            @elseif ($order->confirm == 7)
                                            <span class="text-success">จัดส่งสินค้า</span>
                                            @elseif ($order->confirm == 2)
                                                <span class="text-danger">ชำระเงินไม่สำเร็จ</span>
                                            @elseif ($order->confirm == 3)
                                                <span class="text-warning">แก้ไขการชำระเงินแล้ว</span>
                                            @elseif ($order->SlipImage == null)
                                                <span class="text-danger">ยังไม่ได้ชำระเงิน</span>
                                            @else
                                                <span class="text-warning">รอตรวจสอบ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->confirm == 1)
                                                <a href="{{ url('/profile/check', $order->OrderID) }}"
                                                    class="btn btn-success text-white"><i
                                                        class="fas fa-shopping-basket"></i></a>
                                            @elseif ($order->confirm == 6)
                                                <a href="{{ url('/profile/check', $order->OrderID) }}"
                                                    class="btn btn-success text-white"><i class="fas fa-truck"></i></a>
                                            @elseif ($order->confirm == 7)
                                                <a href="{{ url('/profile/check', $order->OrderID) }}"
                                                    class="btn btn-success text-white">                                <i class="fas fa-shipping-fast"></i>
                                                </i></a>
                                            @else
                                                <a href="{{ url('/cart/success', $order->OrderID) }}"
                                                    class="btn btn-warning text-white"><i class="fas fa-bars"></i></a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    @endsection
</body>

</html>
