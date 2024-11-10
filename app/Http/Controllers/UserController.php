<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Customers;
use App\Models\CustomerAddress;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\Invoices;

class UserController extends Controller
{
    function User()
    {
        $userId = Session::get('Users');
        $address = Session::get('address');
        $customers = Customers::where('CustomerID', $userId)->first();
        $CustomerAddress = CustomerAddress::where('AddressID', $address)->first();
        return view('Account.user', compact('customers', 'CustomerAddress'));
    }
    public function order(Request $request)
    {
        $userId = Session::get('Users');
        $address = Session::get('address');
        $customers = Customers::where('CustomerID', $userId)->first();
        $CustomerAddress = CustomerAddress::where('AddressID', $address)->first();

        if ($request->has('select') && $request->select == '4') {
            $Orders = Orders::where('CustomerID', $userId)
                ->whereNull('SlipImage')
                ->get();
        } elseif ($request->has('select') && $request->select) {
            $Orders = Orders::where('CustomerID', $userId)
                ->where('confirm', $request->select)
                ->get();
        } else {
            $Orders = Orders::where('CustomerID', $userId)->get();
        }

        $OrderDetails = OrderDetails::whereIn('OrderID', $Orders->pluck('OrderID'))->get();

        $orderDetailsSummary = $OrderDetails->groupBy('OrderID')->map(function ($details) {
            return $details->sum('Quantity');
        });

        return view('Account.order', compact('customers', 'CustomerAddress', 'Orders', 'OrderDetails', 'orderDetailsSummary'));
    }

    public function success($id)
    {

        $check = $id;
        $Users = Orders::where('OrderID', $check)->first();
        $userID = $Users->CustomerID;
        $address = CustomerAddress::where('CustomerID', $userID)->first();
        $addressID = $address->AddressID;
        $cart = session()->get('cart', []);
        $Orders = Orders::find($check);
        $Invoice = Invoices::where('AddressID', $addressID)->first();
        $OrderDetails = OrderDetails::where('OrderID', $check)->get();
        $OrderIMG = OrderDetails::where('OrderID', $check)->get();
        // dd($OrderDetail->ProductID);
        $Customers = Customers::find($userID);
        // คำนวณยอดรวมสินค้า

        $totalProductAmount = $OrderDetails->sum(function ($detail) {
            return $detail->Products->Price * $detail->Quantity;
        });

        return view('Product.check_product', compact('cart', 'Orders', 'Customers', 'Invoice', 'OrderDetails', 'totalProductAmount'));
    }
}
