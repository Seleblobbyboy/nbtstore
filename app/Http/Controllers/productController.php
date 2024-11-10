<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\ProductImage;

class productController extends Controller
{
    public function index($id)
    {
        $product = Products::with('category')->where('ProductID', $id)->first();
        $ProductImage = ProductImage::where('ProductID', $id)->get();
        $ProductImage_Main = ProductImage::where('ProductID', $id)->first();
        return view('Product.product', compact('product', 'ProductImage', 'ProductImage_Main'));
    }
}
