<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\ProductCategory;
use App\Models\ProductImage;

class HomepageController extends Controller
{
    function index(){
        $Products = Products::with('productImages', 'category')->get();
        return view('homepage',compact('Products'));
    }
    function category($id){
        $Products = Products::with('productImages', 'category')->get();
        $Categories = Products::where('CategoryID',$id)->get();
        return view('category',compact('Products','Categories'));
    }
    function search(){
        $Products = Products::with('productImages', 'category')->get();
        $query = ''; // กำหนดค่าเริ่มต้น
        return view('search',compact('Products','query'));
    }

    public function search_product(Request $request)
    {
        $query = $request->input('search'); // รับค่าคำค้นจาก input ที่ส่งมา
        $Products = Products::where('ProductName', 'LIKE', "%{$query}%")
            ->orWhere('ProductName_ENG', 'LIKE', "%{$query}%")
            ->get();

        return view('search', compact('Products'))->with('query', $query); // ส่งค่าผลการค้นหาไปที่หน้าแสดงผล
    }
}
