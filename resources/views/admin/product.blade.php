<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | All products</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/add_product.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/admin/product.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- เพิ่ม SweetAlert2 Library -->
</head>

<body>
    <div class="">
        @extends('layouts.navigationAdmin')
        @section('content')
            <div class="head-add">
                <h1><i class="fas fa-shopping-basket"></i> All products</h1>
                <div class="group">
                    <a href="{{ url('/categories') }}" class="add-Categories">
                        Add Categories
                    </a>
                    <a href="{{ url('/admin/add_product') }}" class="add">
                        Add New Product
                    </a>
                </div>
            </div>
            <div class="table-product">
                <table class="table ">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                รหัสสินค้า
                            </th>
                            <th>
                                ชื่อสินค้า
                            </th>
                            <th>
                                ราคา
                            </th>
                            <th>
                                จำนวน
                            </th>
                            <th>
                                หมดหมู่
                            </th>
                            <th>
                                จัดการ
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Products as $product)
                            <tr>
                                <td>{{ $product->ProductID }}</td>
                                <td>{{ $product->ProductName }}</td>
                                <td>${{ $product->Price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->category ? $product->category->CategoryName : 'ไม่มีหมวดหมู่' }}</td>

                                <td>
                                    <div class="btn-ation">
                                        <a href="{{ url('/edit_products', $product->ProductID) }}" class="edit-btn">
                                            แก้ไข
                                        </a>
                                        <a href="{{ url('/delete_products', $product->ProductID) }}" class="delete-btn"
                                            onclick="return false;">
                                            ลบ
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <table>

                    @foreach ($Products as $product)
                        <tr>
                            <td>{{ $product->ProductID }}</td>
                            <td>{{ $product->ProductName }}</td>
                            <td>${{ $product->Price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->category ? $product->category->CategoryName : 'ไม่มีหมวดหมู่' }}</td>

                            <td>
                                <div class="btn-ation">
                                    <a href="{{ url('/edit_products', $product->ProductID) }}" class="edit-btn">
                                        แก้ไข
                                    </a>
                                    <a href="{{ url('/delete_products', $product->ProductID) }}" class="delete-btn"
                                        onclick="return false;">
                                        ลบ
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table> --}}
            </div>
        @endsection
    </div>
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
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: "success",
                    title: "{{ session('success') }}"
                });
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default action (redirect)

                    const url = this.href; // Get the URL from the button

                    Swal.fire({
                        title: "คุณแน่ใจหรือไม่?",
                        text: "คุณจะไม่สามารถเปลี่ยนกลับสิ่งนี้ได้",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "ต้องการที่จะลบ!",
                        cancelButtonText: "ยกเลิก" // Change "Cancel" text
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                            url; // Redirect to the delete URL if confirmed
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
