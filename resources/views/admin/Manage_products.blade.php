<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Add New Product</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/add_product.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- เพิ่ม SweetAlert2 Library -->
</head>

<body>
    <div class="">
        @extends('layouts.navigationAdmin')
        @section('content')
            <form action="{{ url('/add_products') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                <div class="head-add">
                    <h1><i class="fas fa-shopping-basket"></i> Add New Product</h1>
                    <div class="add">
                        <select name="showindex" id="" class="select">
                            <option value="1">แสดงหน้าแรก</option>
                            <option value="2">ทั่วไป</option>
                        </select>
                        <input type="submit" value="Add Product">
                    </div>
                </div>
                <div class="content-product">
                    <div class="from">
                        <label for="Product ID">รหัสสินค้า 5 หลัก</label>
                        <input type="text" name="product_id" maxlength="5" id="product_id" placeholder="Enter product ID" required>

                        <label for="Product Name">ชื่อสินค้า</label>
                        <input type="text" name="ProductName" id="ProductName" placeholder="Enter product name" required>

                        <label for="Product Name ENG">ชื่อสินค้าภาษาอังกฤษ</label>
                        <input type="text" name="ProductName_ENG" id="ProductName_ENG" placeholder="Enter product name in English" required>

                        <label for="Category Name">หมวดหมู่</label>
                        <select name="CategoryName" id="CategoryName" required>
                            @foreach ($categories as $item)
                                <option value="{{ $item->CategoryID }}">{{ $item->CategoryName }}</option>
                            @endforeach
                        </select>

                        <label for="Price">ราคาสินค้า</label>
                        <input type="number" name="Price" id="Price" placeholder="Enter price" min="0" step="0.01" required>

                        <label for="Stock">จำนวนสินค้า</label>
                        <input type="number" name="stock" id="stock" placeholder="Enter stock quantity" min="1" required>

                        <label for="Description">Description (รายละเอียดสินค้า)</label>
                        <textarea name="Description" id="Description" cols="30" rows="5" placeholder="Enter product description" style="resize: none;" required></textarea>
                    </div>
                    <div class="photo">
                        <h3>Upload photo</h3>
                        <div class="photo-product" onclick="document.getElementById('main-file-input').click()">
                            <p id="photo-icon"><i class="fas fa-image"></i></p>
                            <img id="preview-image" src="" alt="Selected Image" style="display: none;">
                            <input type="file" id="main-file-input" name="main_image" accept="image/*" style="display:none" onchange="previewMainImage(event)" required>
                        </div>
                        <div class="photo-img">
                            <div class="mini-photo" id="photo-mini-container">
                                <div class="no-images-placeholder" id="no-images-placeholder">
                                    <b><i class="fas fa-image"></i> No images uploaded</b>
                                </div>
                            </div>
                            <p onclick="addNewImageInput()"><i class="fas fa-plus"></i> Add More Images</p>
                        </div>
                    </div>
                </div>
            </form>
        @endsection
    </div>

    <script>
        function previewMainImage(event) {
            const photoIcon = document.getElementById('photo-icon');
            const previewImage = document.getElementById('preview-image');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                previewImage.src = reader.result;
                previewImage.style.display = 'block';
                photoIcon.style.display = 'none';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function addNewImageInput() {
            const container = document.getElementById('photo-mini-container');
            const placeholder = document.getElementById('no-images-placeholder');
            if (placeholder) {
                placeholder.style.display = 'none';
            }

            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.accept = 'image/*';
            newInput.style.display = 'none';
            newInput.name = "additional_images[]";
            newInput.multiple = true;

            newInput.onchange = function(event) {
                const files = event.target.files;

                Array.from(files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function() {
                        const newDiv = document.createElement('div');
                        newDiv.classList.add('img-mini');

                        const newImage = document.createElement('img');
                        newImage.src = reader.result;
                        newImage.alt = 'Mini Image';

                        newImage.onclick = function() {
                            container.removeChild(newDiv);
                            if (container.querySelectorAll('.img-mini').length === 0) {
                                placeholder.style.display = 'flex';
                            }
                        };

                        newDiv.appendChild(newImage);
                        container.appendChild(newDiv);
                    };

                    reader.readAsDataURL(file);
                });
            };

            container.appendChild(newInput);
            newInput.click();
        }
    </script>

    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'ตกลง'
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
</body>

</html>
