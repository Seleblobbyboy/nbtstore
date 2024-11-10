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
}
