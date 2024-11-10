<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $primaryKey = 'OrderID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'OrderID',      // เพิ่ม OrderID ไว้ใน fillable
        'CustomerID',
        'AddressID',
        'TotalAmount',
        'OrderDate',
    ];

    function Customers(){
        return $this->belongsTo(Customers::class,'CustomerID','CustomerID');
    }
    function OrderDetails(){
        return $this->hasMany(OrderDetails::class,'OrderID','OrderID');
    }

    function CustomerAddress(){
        return $this->belongsTo(CustomerAddress::class,'AddressID','AddressID');
    }
}
