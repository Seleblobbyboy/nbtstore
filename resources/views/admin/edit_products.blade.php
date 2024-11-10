<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Edit New Product</title>
    <link rel="stylesheet" href="{{ url('assets/CSS/add_product.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- เพิ่ม SweetAlert2 Library -->
</head>

<body>
    <div class="">
        @extends('layouts.navigationAdmin')
        @section('content')
            <form action="{{ url('/update_products/' . $product->ProductID) }}" method="POST" enctype="multipart/form-data"
                onsubmit="return validateForm()">
                @csrf
                @method('PUT')
                <div class="head-add">
                    <h1><i class="fas fa-shopping-basket"></i> Edit New Product</h1>
                    <div class="add">
                        <input type="submit" value="Update Product" id="submit-button">
                    </div>
                </div>
                <div class="content-product">
                    <div class="from">
                        <label for="Product ID">รหัสสินค้า 5 หลัก</label>
                        <input type="text" name="product_id" value="{{ $product->ProductID }}" maxlength="5"
                            id="product_id" placeholder="Enter product ID" required>

                        <label for="Product Name">ชื่อสินค้า</label>
                        <input type="text" name="ProductName" value="{{ $product->ProductName }}" id="ProductName"
                            placeholder="Enter product name" required>

                        <label for="Product Name ENG">ชื่อสินค้าภาษาอังกฤษ</label>
                        <input type="text" name="ProductName_ENG" value="{{ $product->ProductName_ENG }}"
                            id="ProductName_ENG" placeholder="Enter product name in English" required>

                        <label for="Category Name">หมวดหมู่</label>
                        <select name="CategoryName" id="CategoryName" required>
                            @foreach ($categories as $item)
                                <option value="{{ $item->CategoryID }}"
                                    {{ $product->CategoryID == $item->CategoryID ? 'selected' : '' }}>
                                    {{ $item->CategoryName }}</option>
                            @endforeach
                        </select>

                        <label for="Price">ราคาสินค้า</label>
                        <input type="number" name="Price" value="{{ $product->Price }}" id="Price"
                            placeholder="Enter price" min="0" step="0.01" required>

                        <label for="Stock">จำนวนสินค้า</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" id="stock"
                            placeholder="Enter stock quantity" min="1" required>

                        <label for="Description">Description (รายละเอียดสินค้า)</label>
                        <textarea name="Description" id="Description" cols="30" rows="5" placeholder="Enter product description"
                            style="resize: none;" required>{{ $product->Description }}</textarea>
                    </div>
                    <div class="photo">
                        <h3>Upload photo</h3>
                        <div class="photo-product" onclick="document.getElementById('main-file-input').click()">
                            <p id="photo-icon"
                                style="display: {{ $product->productImages && $product->productImages->isNotEmpty() ? 'none' : 'block' }};">
                                <i class="fas fa-image"></i>
                            </p>
                            <img id="preview-image"
                                src="{{ $product->productImages && $product->productImages->isNotEmpty() ? asset('storage/' . $product->productImages->first()->ImagePath) : asset('assets/img/default.jpg') }}"
                                alt="Selected Image"
                                style="display: {{ $product->productImages && $product->productImages->isNotEmpty() ? 'block' : 'none' }};">
                            <input type="file" id="main-file-input" name="main_image" accept="image/*"
                                style="display:none" onchange="previewMainImage(event)">
                        </div>
                        <div class="photo-img">
                            <div class="mini-photo" id="photo-mini-container">
                                <div class="no-images-placeholder" id="no-images-placeholder"
                                    style="display: {{ $product->productImages && $product->productImages->isEmpty() ? 'block' : 'none' }};">
                                    <b><i class="fas fa-image"></i> No images uploaded</b>
                                </div>
                                @foreach ($product->productImages as $image)
                                    <div class="img-mini">
                                        <img src="{{ asset('storage/' . $image->ImagePath) }}" alt="Mini Image"
                                            data-id="{{ $image->ImageID }}" onclick="removeImage(this)">
                                    </div>
                                @endforeach
                            </div>
                            <p onclick="addNewImageInput()"><i class="fas fa-plus"></i> Add More Images</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="deleted_images" name="deleted_images" value="">
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

        function removeImage(imageElement) {
            const container = document.getElementById('photo-mini-container');
            const imageId = imageElement.getAttribute('data-id'); // Get image ID

            // Append the image ID to the hidden input field
            const deletedImagesInput = document.getElementById('deleted_images');
            let deletedImages = deletedImagesInput.value ? deletedImagesInput.value.split(',') : [];
            deletedImages.push(imageId);
            deletedImagesInput.value = deletedImages.join(',');

            container.removeChild(imageElement.parentElement);
            const placeholder = document.getElementById('no-images-placeholder');
            if (container.querySelectorAll('.img-mini').length === 0) {
                placeholder.style.display = 'block';
            }
        }

        function validateForm() {
            const miniPhotoContainer = document.getElementById('photo-mini-container');
            const miniPhotos = miniPhotoContainer.querySelectorAll('.img-mini');
            if (miniPhotos.length === 0) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: 'error',
                    title: 'กรุณาอัปโหลดรูปภาพอย่างน้อยหนึ่งรูปก่อนบันทึก'
                });

                return false; // Prevent form submission
            }
            return true; // Allow form submission
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
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
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
