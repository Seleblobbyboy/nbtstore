// ฟังก์ชันเปลี่ยนภาพหลัก
function changePhoto(element) {
    const mainPhoto = document.getElementById("main-photo");
    mainPhoto.src = element.src; // เปลี่ยนภาพหลักให้เป็นภาพที่คลิก
}

// ฟังก์ชันเพิ่มจำนวน
function increment() {
    let quantity = document.getElementById("quantity");
    let currentValue = parseInt(quantity.value);
    quantity.value = currentValue + 1;
}

// ฟังก์ชันลดจำนวน
function decrement() {
    let quantity = document.getElementById("quantity");
    let currentValue = parseInt(quantity.value);
    if (currentValue > 1) { // ห้ามให้ค่าลดลงต่ำกว่า 1
        quantity.value = currentValue - 1;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const photo = document.querySelector(".photo");
    const img = photo.querySelector("img");
    const imagePaths = Array.from(document.querySelectorAll(".product-photo-mini img")).map(img => img.src);
    let currentImageIndex = 0;
    let isZooming = false;

    // ฟังก์ชันซูมภาพตามเมาส์
    photo.addEventListener("mousemove", function (e) {
        const photoRect = photo.getBoundingClientRect();
        const x = e.clientX - photoRect.left;
        const y = e.clientY - photoRect.top;

        const xPercent = (x / photoRect.width) * 100;
        const yPercent = (y / photoRect.height) * 100;

        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        isZooming = true; // กำลังซูมอยู่
    });

    photo.addEventListener("mouseleave", function () {
        img.style.transformOrigin = "center center";
        isZooming = false; // หยุดซูม
    });

    // ฟังก์ชันเปลี่ยนภาพอัตโนมัติ
    function changeImageAuto() {
        if (!isZooming) { // เปลี่ยนภาพเฉพาะเมื่อไม่ได้ซูม
            currentImageIndex = (currentImageIndex + 1) % imagePaths.length;
            img.src = imagePaths[currentImageIndex];
        }
    }

    setInterval(changeImageAuto, 10000); // เปลี่ยนภาพทุกๆ 3 วินาที
});