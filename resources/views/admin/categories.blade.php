<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Categories</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/add_product.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/admin/product.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/admin/categories.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- เพิ่ม SweetAlert2 Library -->
</head>

<body>
    <div class="">
        @extends('layouts.navigationAdmin')
        @section('content')
            @if (!$add_categories)
                <div class="head-add">
                    <h1><i class="fas fa-shopping-basket"></i> Categories</h1>
                    <div class="group">
                        <a href="{{ url('/admin/add_product') }}" class="add">
                            New Product
                        </a>
                    </div>
                </div>
                <div class="menu-back">
                    <ul>
                        <li><a href="{{ url('/product') }}">All products</a></li>
                        <li>/</li>
                        <li><a href="{{ url('/categories') }}">Categoriess</a></li>
                    </ul>
                </div>
                <div class="add-categories">
                    <form action="{{ url('/add_categories') }}" method="POST">
                        @csrf
                        <label for="">เพิ่มหมวดมู่</label>
                        <div class="top">
                            <input type="text" name="CategoryName" placeholder="Category name">
                            <input type="submit" value="เพิ่ม">
                        </div>
                    </form>
                </div>
                <div class="table-product">
                    <table>
                        <tr>
                            <th>
                                รหัสหมวดหมู่
                            </th>
                            <th class="name-product">
                                ชื่อหมวดหมู่
                            </th>
                            <th>
                                จัดการ
                            </th>
                        </tr>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->CategoryID }}
                                </td>
                                <td>
                                    {{ $category->CategoryName }}
                                </td>
                                <td>
                                    <div class="btn-ation">
                                        <a href="{{ url('/edit_categories', $category->CategoryID) }}" class="edit-btn">
                                            แก้ไข
                                        </a>
                                        <a href="{{ url('/delete_categories',$category->CategoryID) }}" class="delete-btn" onclick="return false;">
                                            ลบ
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="head-add">
                    <h1><i class="fas fa-shopping-basket"></i> Edit Categories</h1>
                    <div class="group">
                        <a href="{{ url('/admin/add_product') }}" class="add">
                            New Product
                        </a>
                    </div>
                </div>
                <div class="menu-back">
                    <ul>
                        <li><a href="{{ url('/product') }}">All products</a></li>
                        <li>/</li>
                        <li><a href="{{ url('/categories') }}">Categoriess</a></li>
                        <li>/</li>
                        <li><a href="{{ url('edit_categories', $add_categories->CategoryID) }}">{{$add_categories->CategoryName}}</a></li>
                    </ul>
                </div>
                <div class="add-categories">
                    <form action="{{ url('/update_categories',$add_categories->CategoryID) }}" method="POST">
                        @csrf
                        <label for="">แก้ไขหมวดมู่</label>
                        <div class="top">
                            <input type="text" name="CategoryName" value="{{ $add_categories->CategoryName }}"
                                placeholder="Category name">
                            <input type="submit" value="อัพเดท">
                        </div>
                    </form>
                </div>
                <div class="table-product">
                    <table>
                        <tr>
                            <th>
                                รหัสหมวดหมู่
                            </th>
                            <th class="name-product">
                                ชื่อหมวดหมู่
                            </th>
                            <th>
                                จัดการ
                            </th>
                        </tr>

                        <tr>
                            <td>
                                {{ $add_categories->CategoryID }}
                            </td>
                            <td>
                                {{ $add_categories->CategoryName }}
                            </td>
                            <td>
                                <div class="btn-ation">
                                    <a href="{{ url('/delete_categories',$add_categories->CategoryID) }}" class="delete-btn" onclick="return false;">
                                        ลบ
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            @endif

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
