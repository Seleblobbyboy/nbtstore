<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $fillable = [
        'OrderID',
        'ProductID',
        'Quantity',
        'SubTotal',
    ];
    
    protected $primaryKey = 'OrderDetailID'; // หากใช้ `OrderDetailID` เป็น primary key
    public $incrementing = true; // ตั้งค่าเป็น false ถ้าต้องการกำหนดเอง
    function Orders(){
        return $this->belongsTo(Orders::class,'OrderID','OrderID');
    }
    function Products(){
        return $this->belongsTo(Products::class,'ProductID','ProductID');
    }
}
