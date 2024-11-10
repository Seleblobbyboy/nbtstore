<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class SearchController extends Controller
{
    function SearchrStatus(Request $request){
        // dd($request->select);
        $OrdersSearch = Orders::where('confirm',$request->select)->get();
        
        return redirect()->back();
    }
}
