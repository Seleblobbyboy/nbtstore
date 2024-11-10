<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Users;
use App\Models\Customers;
use App\Models\Admin;
use Illuminate\Support\Facades\Session; // Import Session


class LoginController extends Controller
{
    function login()
    {
        return view('login.login');
    }
    function register()
    {
        return view('login.register');
    }
    function forgot()
    {
        return view('login.forgot');
    }
    function reset()
    {
        return view('login.reset');
    }
    function add(Request $request)
    {
        // ค้นหาผู้ใช้ในระบบตามอีเมลที่ส่งเข้ามา
        $existingUser = Users::where('Email', $request->email)->first();

        if ($existingUser) {
            // ตรวจสอบว่ามีรหัสผ่านหรือไม่
            if (!is_null($existingUser->Password)) {
                return redirect('/login')->with('error', 'อีเมลนี้ถูกใช้ลงทะเบียนในระบบด้วยวิธีอื่นโปรดติดต่อเจ้าหน้าที่');
            } else {
                // หากไม่มีรหัสผ่าน แสดงว่าผู้ใช้เข้าสู่ระบบผ่าน Google สามารถเข้าระบบได้ปกติ
                $UserID = $existingUser->UserID;
                $Customer = Customers::where('UserID', $UserID)->first();

                if ($Customer) {
                    // บันทึกข้อมูลชื่อผู้ใช้ลงใน session และเปลี่ยนเส้นทางไปหน้าแรก
                    Session::put('Users', $Customer->CustomerID);

                    Session::put('UsersName', $Customer->CustomerID);
                    return redirect('/')->with('success', 'เข้าสู่ระบบสำเร็จ');
                }
            }
        } else {
            // หากไม่มีผู้ใช้ที่มีอีเมลนี้ ให้สร้างผู้ใช้ใหม่ใน Users
            $User = new Users();
            $User->Email = $request->email;
            $User->save();

            // ดึง UserID ที่เพิ่งบันทึก
            $userID = $User->UserID;

            // สร้างข้อมูลลูกค้าใหม่ในตาราง Customers
            $Customer = new Customers();
            $Customer->UserID = $userID;
            $Customer->CustomerName = $request->name;
            $Customer->save();

            // ตั้งค่า Session ด้วย CustomerName หลังจากสร้างข้อมูลสำเร็จ
            Session::put('Users', $Customer->CustomerID);
            return redirect('/');
        }
    }

    function add_register(Request $request)
    {
        $existingUser = Users::where('Email', $request->email)->first();

        if ($existingUser) {
            return redirect('/register')->with('error', 'อีเมลนี้มีอยู่แล้วในระบบ');
        } else {
            $Users = new Users();
            $Users->Email = $request->email;
            $Users->Password = md5($request->password);
            $Users->save();

            $userID = $Users->UserID;

            // สร้างข้อมูลลูกค้าใหม่ในตาราง Customers
            $Customer = new Customers();
            $Customer->UserID = $userID;
            $Customer->CustomerName = $request->name;
            $Customer->save();

            Session::put('Users', $Customer->CustomerID);
            return redirect('/')->with('success', 'สมัครสมาชิกสำเร็จ');
        }
    }
    function check(Request $request)
    {
        $md5Password = md5($request->password);

        // ตรวจสอบว่าเป็นการเข้าสู่ระบบของ Admin หรือไม่
        $admin = Admin::where('username', $request->email)->where('password', $md5Password)->first();
        if ($admin) {
            Session::put('Admin', 1);
            return redirect('/admin')->with('success', 'เข้าสู่ระบบสำเร็จ');
        }

        // ตรวจสอบว่าเป็นผู้ใช้ทั่วไปหรือไม่
        $user = Users::where('Email', $request->email)->where('Password', $md5Password)->first();
        if ($user) {
            $UserID = $user->UserID;
            $Customer = Customers::where('UserID', $UserID)->first();
            if ($Customer) {
                Session::put('Users', $Customer->CustomerID);
                return redirect('/')->with('success', 'เข้าสู่ระบบสำเร็จ');
            }
        }

        return redirect('/login')->with('error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง');
    }

    function check_forgot(Request $request)
    {
        $Email = Users::where('Email', $request->email)->first();
        if ($Email) {
            Session::put('UserID', $Email->UserID);
            return redirect('/reset');
        }
        return redirect('/forgot')->with('error', 'ไม่พบ Email ในระบบสมาชิก');
    }
    function check_reset(Request $request)
    {
        // ค้นหาผู้ใช้โดยตรวจสอบรหัสผ่านเก่าที่เข้ารหัส
        $Users = Users::where('Password', md5($request->password))->first();

        if ($Users) {
            $Users->Password = md5($request->confirm_password); // เข้ารหัส MD5 ให้รหัสผ่านใหม่
            $Users->save(); // ใช้ save() แทน update() เพื่อความถูกต้อง

            return redirect('/login')->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ');
        }

        return redirect('/reset')->with('error', 'รหัสผ่านไม่ถูกต้อง');
    }

    function logout()
    {
        Session::forget('Users');
        Session::forget('total_quantity');
        Session::forget('cart');
        Session::forget('address');
        return redirect('/login')->with('success', 'ออกจากระบบสำเร็จ');
    }
    function logout_admin()
    {
        Session::forget('Admin');
        return redirect('/login')->with('success', 'ออกจากระบบสำเร็จ');
    }
}
