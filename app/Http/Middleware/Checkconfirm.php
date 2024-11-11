<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders;
use Illuminate\Support\Facades\Session;


class Checkconfirm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {



        $orderId = $request->route('id');
        $Orsers = Orders::where('OrderID',$orderId)->first();
        if ($Orsers->confirm != 1 && $Orsers->confirm != 6 && $Orsers->confirm != 7) {
            return redirect('/cart/success/'.$orderId);
        }
        return $next($request);
    }
}
