<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\Categories;
use App\Models\Customers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // แชร์ข้อมูล Categories และ Customer ไปยัง views layout.navigation และ layout.navigationAdmin
        View::composer(['layouts.navigation', 'layouts.navigationAdmin','layouts.navigatuonuser'], function ($view) {
            $view->with('categories', Categories::all());

            // ตรวจสอบว่ามี UserID ใน session หรือไม่
            $userId = Session::get('Users');

            if ($userId) {
                // ดึงข้อมูลลูกค้าตาม UserID จาก session
                $customer = Customers::where('CustomerID', $userId)->first(); // ตรวจสอบด้วย where
                $view->with('customer', $customer);
            } else {
                $view->with('customer', null); // หากไม่มี UserID ให้ส่งค่าเป็น null
            }
        });
    }
}
