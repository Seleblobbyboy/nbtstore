// firebaseConfig ที่กำหนดค่าไว้แล้ว
const firebaseConfig = {
    apiKey: "AIzaSyCDTZ6FvxEWiubk5ifoD6RogaGc-j-IfE8",
    authDomain: "nbtsupply-1981d.firebaseapp.com",
    projectId: "nbtsupply-1981d",
    storageBucket: "nbtsupply-1981d.firebasestorage.app",
    messagingSenderId: "644288587591",
    appId: "1:644288587591:web:75e967440a1c4340c54e62",
    measurementId: "G-GCRS02WZT9"
};

// เริ่มต้น Firebase
firebase.initializeApp(firebaseConfig);

// ฟังก์ชัน Google Sign-In
function googleSignIn() {
    const provider = new firebase.auth.GoogleAuthProvider();
    provider.setCustomParameters({
        prompt: 'consent' // ขอการยืนยันจากผู้ใช้ทุกครั้ง
    });

    // เรียกใช้การ sign-in ด้วยป๊อปอัป
    firebase.auth().signInWithPopup(provider)
        .then((result) => {
            let user = result.user;
            let name = user.displayName;
            let email = user.email;

            // เก็บข้อมูลชื่อและอีเมลไว้ใน localStorage
            localStorage.setItem('userName', name);
            localStorage.setItem('userEmail', email);

            // ใส่ค่าลงในฟอร์มและส่งฟอร์มทันที
            document.querySelector('#update input[name="name"]').value = name;
            document.querySelector('#update input[name="email"]').value = email;
            document.getElementById('update').submit();
        })
        .catch((error) => {
            console.error("เกิดข้อผิดพลาดระหว่างการเข้าสู่ระบบ:", error);

            // แสดงข้อความข้อผิดพลาด
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'การเข้าสู่ระบบไม่สำเร็จ กรุณาลองใหม่อีกครั้ง',
                confirmButtonText: 'ตกลง'
            });
        });
}
