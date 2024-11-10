<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductImage;
use App\Models\CustomerAddress;
use App\Models\Customers;
use App\Models\OrderDetails;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Invoices;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        // ส่งตัวแปร $cart ไปยัง View
        return view('product.cart', compact('cart'));
    }
    public function shopping()
    {
        $cart = session()->get('cart', []);
        $userId = Session::get('Users');
        $CustomerAddress = CustomerAddress::where('CustomerID', $userId)->get();
        $Locations = Location::all();

        return view('product.cart_shopping', compact('cart', 'CustomerAddress', 'Locations'));
    }
    public function payment()
    {
        $cart = session()->get('cart', []);
        $AddressID = Session::get('address');
        $CustomerAddress = CustomerAddress::find($AddressID);

        return view('product.cart_payment', compact('cart', 'CustomerAddress'));
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

        return view('product.success', compact('cart', 'Orders', 'Customers', 'Invoice', 'OrderDetails', 'totalProductAmount'));
    }
    public function addToCart(Request $request, $id)
    {
        $product = Products::with('productImages')->where('ProductID', $id)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'ไม่พบสินค้าที่คุณต้องการ');
        }

        $cart = session()->get('cart', []);
        $totalQuantity = session()->get('total_quantity', 0); // Get current total quantity

        if (isset($cart[$id])) {
            // เพิ่มจำนวนสินค้าในตะกร้า
            $newQuantity = $cart[$id]['quantity'] + $request->input('quantity', 1);

            // เช็คจำนวนในสต็อก
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'จำนวนสินค้าที่ต้องการมากเกินไป');
            }

            $cart[$id]['quantity'] = $newQuantity; // อัปเดตจำนวนในตะกร้า
            $totalQuantity += $request->input('quantity', 1); // Update total quantity
        } else {
            $cart[$id] = [
                "ProductID" => $product->ProductID,
                "ProductName" => $product->ProductName,
                "Price" => $product->Price,
                "quantity" => $request->input('quantity', 1),
                "stock" => $product->stock,
                "ImagePath" => $product->productImages->first()->ImagePath ?? 'default.jpg',
            ];
            $totalQuantity += $request->input('quantity', 1); // Update total quantity
        }

        session()->put('cart', $cart); // บันทึกตะกร้าใน session
        session()->put('total_quantity', $totalQuantity); // Store updated quantity in session
        return redirect()->back()->with('success', 'เพิ่มสินค้าลงในตะกร้าแล้ว');
    }
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        // ตรวจสอบว่าสินค้าอยู่ในตะกร้าหรือไม่
        if (isset($cart[$id])) {
            // อัปเดตจำนวนสินค้า
            $cart[$id]['quantity'] = $request->input('quantity', 1);

            // ตรวจสอบจำนวนสินค้าไม่ให้เกิน stock
            $product = Products::find($id);
            if ($cart[$id]['quantity'] > $product->stock) {
                return response()->json(['success' => false, 'message' => 'จำนวนสินค้าสูงสุดที่สามารถสั่งได้คือ ' . $product->stock]);
            }
        }

        session()->put('cart', $cart); // บันทึกตะกร้าใน session

        return response()->json(['success' => true]);
    }
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function updateTotalQuantity(Request $request)
    {
        $totalQuantity = $request->input('total_quantity');
        session(['total_quantity' => $totalQuantity]);

        return response()->json(['success' => true]);
    }
    public function updateTotalQuantityAndAmount(Request $request)
    {
        session(['total_quantity' => $request->input('total_quantity')]);
        session(['total_amount' => $request->input('total_amount')]);

        return response()->json(['success' => true]);
    }

    public function placeOrder()
    {
        $customerID = Session::get('Users');
        $addressID = Session::get('address');
        $cart = Session::get('cart');

        if (empty($customerID) || empty($addressID) || empty($cart)) {
            return redirect()->back()->with('error', 'ข้อมูลไม่ครบถ้วน กรุณาตรวจสอบอีกครั้ง');
        }

        $productTotal = array_sum(array_map(function ($product) {
            return $product['Price'] * $product['quantity'];
        }, $cart));
        $shippingCost = 65;
        $totalAmount = $productTotal + $shippingCost;

        session(['TotalAmount' => $totalAmount]);
        DB::beginTransaction();
        $orderID = 'ORD' . time(); // ตัวอย่างการสร้าง OrderID ที่มีรูปแบบ

        try {
            // ตรวจสอบว่ามีข้อมูลใบกำกับภาษีหรือไม่
            $invoice = Invoices::where('CustomerID', $customerID)->first();
            $invoiceID = $invoice ? $invoice->InvoiceID : null;

            // สร้างคำสั่งซื้อใหม่
            $order = Orders::create([
                'OrderID' => $orderID,
                'CustomerID' => $customerID,
                'AddressID' => $addressID,
                'InvoiceID' => $invoiceID, // เพิ่ม InvoiceID ถ้ามีข้อมูลใบกำกับภาษี
                'TotalAmount' => $totalAmount,
                'OrderDate' => Carbon::now()->toDateTimeString(),
            ]);

            if (!$order || !$order->OrderID) {
                throw new \Exception("ไม่สามารถสร้างคำสั่งซื้อได้");
            }

            foreach ($cart as $item) {
                OrderDetails::create([
                    'OrderID' => $order->OrderID,
                    'ProductID' => $item['ProductID'],
                    'Quantity' => $item['quantity'],
                    'SubTotal' => $item['Price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            Session::forget('cart');
            Session::forget('total_quantity');

            return redirect('/cart/success/' . $orderID)->with('orderNumber', $order->OrderID);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการทำรายการ: ' . $e->getMessage());
        }
    }


    public function uploadSlip(Request $request, $orderID)
    {
        $request->validate([
            'slip_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $order = Orders::find($orderID);

        if ($request->hasFile('slip_image')) {
            // ลบรูปเก่าถ้ามีอยู่แล้ว
            if ($order->SlipImage) {
                Storage::delete('public/' . $order->SlipImage);
            }

            // ตั้งชื่อไฟล์ใหม่โดยใช้ UUID
            $file = $request->file('slip_image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('slips', $filename, 'public');

            $order->SlipImage = $path;
            $order->save();
        }

        return redirect()->back()->with('success', 'อัปโหลดสลิปการโอนเงินเรียบร้อยแล้ว');
    }
    public function editloadSlip(Request $request, $orderID)
    {
        $request->validate([
            'slip_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $order = Orders::find($orderID);

        if ($request->hasFile('slip_image')) {
            // ลบรูปเก่าถ้ามีอยู่แล้ว
            if ($order->SlipImage) {
                Storage::delete('public/' . $order->SlipImage);
            }

            // ตั้งชื่อไฟล์ใหม่โดยใช้ UUID
            $file = $request->file('slip_image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('slips', $filename, 'public');

            $order->SlipImage = $path;
            $order->confirm = 3;
            $order->Comment = "โปรดตรวจสอบการแก้ไขการโอนเงินของลูกค้า";
            $order->save();
        }

        return redirect()->back()->with('success', 'อัปโหลดสลิปการโอนเงินเรียบร้อยแล้ว');
    }
}
