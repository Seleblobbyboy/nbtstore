<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Orders;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Invoices;
use App\Models\Customers;
use App\Models\CustomerAddress;




class AdminController extends Controller
{
    public function index()
    {
        $Orders = Orders::all();

        // Get order details and group them by OrderID
        $OrderDetails = OrderDetails::whereIn('OrderID', $Orders->pluck('OrderID'))->get();

        // Summarize order details by OrderID
        $orderDetailsSummary = $OrderDetails->groupBy('OrderID')->map(function ($details) {
            return $details->sum('Quantity'); // Sum the quantity for each order
        });

        return view('admin.admin', compact('Orders', 'orderDetailsSummary'));
    }

    function add_product()
    {
        $categories = Categories::all();
        return view('admin.Manage_products', compact('categories'));
    }
    function product()
    {
        $Products = Products::with('category')->get(); // ถ้าเป็นการดึงสินค้าหลายรายการ


        return view('admin.product', compact('Products'));
    }
    function categories()
    {
        $categories = Categories::all();
        $add_categories = null;
        return view('admin.categories', compact('categories', 'add_categories'));
    }
    public function edit_products($id)
    {
        $product = Products::with('productImages')->find($id);
        $categories = Categories::all();
        return view('admin.edit_products', compact('categories', 'product'));
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

        return view('admin.success', compact('cart', 'Orders', 'Customers', 'Invoice', 'OrderDetails', 'totalProductAmount'));
    }
    public function confirm($id)
    {

        $Orders = Orders::find($id);
        $Orders->confirm = 1;
        $Orders->save();
        return redirect('/admin/success/'. $id)->with('success', 'ยืนยันการชำระเงินแล้ว');
    }
    public function notConfirm($id)
    {

        $Orders = Orders::find($id);
        $Orders->confirm = 2;
        $Orders->Comment = "โปรดชำระเงินใหม่";
        $Orders->save();
        return redirect('/admin/success/' . $id)->with('success', 'ยกเลิกการยืนยันสินค้าแล้ว');
    }
    public function saveComment(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'order_id' => 'required|exists:orders,OrderID',
            'comment' => 'required|string'
        ]);

        // Find the order by its ID
        $order = Orders::find($request->order_id);

        // Update the Comment column with the provided comment text
        $order->Comment = $request->comment;
        $order->save();

        // Return a success response to the JavaScript fetch request
        return response()->json(['success' => true, 'message' => 'Comment saved successfully']);
    }

    function add_products(Request $request)
    {
        // ตรวจสอบว่ามี ProductID ซ้ำหรือไม่
        $existingProduct = Products::where('ProductID', $request->product_id)->first();

        if ($existingProduct) {
            return redirect('/admin/add_product')->with('error', 'รหัสสินค้านี้มีอยู่แล้ว กรุณาใช้รหัสสินค้าใหม่');
        }

        // สร้างข้อมูลในตาราง Products
        $product = new Products;
        $product->ProductID = $request->product_id;
        $product->ProductName = $request->ProductName;
        $product->ProductName_ENG = $request->ProductName_ENG;
        $product->Price = $request->Price;
        $product->stock = $request->stock;
        $product->Description = $request->Description;
        $product->CategoryID = $request->CategoryName;
        $product->save();

        // บันทึกภาพหลัก
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('product_images', 'public');

            $ProductImage = new ProductImage;
            $ProductImage->ProductID = $product->ProductID;
            $ProductImage->ImagePath = $path;
            $ProductImage->AltText = $request->ProductName;
            $ProductImage->save();
        }

        // บันทึกรูปย่อย
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('product_images', 'public');

                $ProductImage = new ProductImage;
                $ProductImage->ProductID = $product->ProductID;
                $ProductImage->ImagePath = $path;
                $ProductImage->AltText = $request->ProductName;
                $ProductImage->save();
            }
        }

        return redirect('/admin/add_product')->with('success', 'เพิ่มสินค้าเรียบร้อยแล้ว');
    }
    function update_products(Request $request, $productId)
    {
        // ค้นหาสินค้าที่จะทำการอัพเดต
        $product = Products::find($productId);

        if (!$product) {
            return redirect('/admin/edit_product/' . $productId)->with('error', 'ไม่พบสินค้าที่ต้องการอัพเดต');
        }

        // ตรวจสอบว่ามี ProductID ซ้ำหรือไม่ หากเปลี่ยน ProductID
        if ($product->ProductID !== $request->product_id) {
            $existingProduct = Products::where('ProductID', $request->product_id)->first();
            if ($existingProduct) {
                return redirect('/admin/edit_product/' . $productId)->with('error', 'รหัสสินค้านี้มีอยู่แล้ว กรุณาใช้รหัสสินค้าใหม่');
            }
        }

        // อัพเดตข้อมูลในตาราง Products
        $product->ProductID = $request->product_id;
        $product->ProductName = $request->ProductName;
        $product->ProductName_ENG = $request->ProductName_ENG;
        $product->Price = $request->Price;
        $product->stock = $request->stock;
        $product->Description = $request->Description;
        $product->CategoryID = $request->CategoryName;
        $product->save();

        // อัพเดตภาพหลัก
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('product_images', 'public');

            $ProductImage_Main = ProductImage::where('ProductID', $product->ProductID)->first();
            if ($ProductImage_Main) {
                $ProductImage_Main->ImagePath = $path;
                $ProductImage_Main->AltText = $request->ProductName;
                $ProductImage_Main->save();
            } else {
                $ProductImage = new ProductImage;
                $ProductImage->ProductID = $product->ProductID;
                $ProductImage->ImagePath = $path;
                $ProductImage->AltText = $request->ProductName;
                $ProductImage->save();
            }
        }

        // อัพเดตรูปย่อย
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('product_images', 'public');

                $ProductImage = new ProductImage;
                $ProductImage->ProductID = $product->ProductID;
                $ProductImage->ImagePath = $path;
                $ProductImage->AltText = $request->ProductName;
                $ProductImage->save();
            }
        }


        // ลบรูปภาพตาม ID ที่ส่งมา
        if ($request->deleted_images) {
            $deletedImageIds = explode(',', $request->deleted_images);
            ProductImage::whereIn('ImageID', $deletedImageIds)->delete();
        }

        return redirect('product')->with('success', 'อัพเดตสินค้าเรียบร้อยแล้ว');
    }
    function add_categories(Request $request)
    {
        $add_categories = new categories;
        $add_categories->CategoryName = $request->CategoryName;
        $add_categories->save();
        return redirect('/categories')->with('success', 'เพิ่มหมวดหมู่สินค้าเรียบร้อยแล้ว');
    }
    function edit_categories($id)
    {
        $add_categories = categories::find($id);
        return view('admin.categories', compact('add_categories'));
    }
    function update_categories(Request $request, $id)
    {
        $update_categories = categories::find($id); // ดึงข้อมูลตาม id
        if ($update_categories) { // ตรวจสอบว่าพบข้อมูลหรือไม่
            $update_categories->CategoryName = $request->CategoryName;
            $update_categories->save(); // ใช้ save() เพื่อบันทึกข้อมูลที่แก้ไข
            return redirect('/categories')->with('success', 'แก้ไขหมวดหมู่สินค้าเรียบร้อยแล้ว');
        } else {
            return redirect('/categories')->with('error', 'ไม่พบข้อมูลที่ต้องการแก้ไข');
        }
    }
    function delete_products($id)
    {
        $product = Products::find($id);
        $product->forceDelete();
        return redirect('/product')->with('success', 'ลบสินค้าสำเร็จ');
    }
    function delete_categories($id)
    {
        $product = categories::find($id);
        $product->forceDelete();
        return redirect('/categories')->with('success', 'ลบสินค้าสำเร็จ');
    }
}
