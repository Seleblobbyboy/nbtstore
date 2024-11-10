<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Orders; // เพิ่ม use Orders ตรงนี้

class CheckOrderuser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userCustomerID = session('Users');
        $orderId = $request->route('id');
        $order = Orders::find($orderId);

        if (!$order || $order->CustomerID != $userCustomerID) {
            return redirect('/')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงคำสั่งซื้อนี้');
        }

        return $next($request);
    }
}
