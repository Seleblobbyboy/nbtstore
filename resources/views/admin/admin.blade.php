<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ url('assets/CSS/admin/home.css') }}">
    <title>Document</title>
</head>

<body>
    @extends('layouts.navigationAdmin')

    @section('content')
        <div class="container">
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
                            <td>{{ $orderDetailsSummary[$order->OrderID] ?? 0 }}</td>
                            <td>{{ $order->TotalAmount }}</td>
                            <td>
                                @if ($order->confirm == 1)
                                    <span class="text-success">ชำระเงินสำเร็จ</span>
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
                                <a href="{{ url('admin/success', $order->OrderID) }}"
                                    class="btn btn-warning text-white">ดูรายละเอียด</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

</body>

</html>
