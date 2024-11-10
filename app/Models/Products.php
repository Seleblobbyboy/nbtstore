<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $primaryKey = 'ProductID'; // ระบุคอลัมน์ primary key
    public $incrementing = false; // ถ้า primary key ไม่ใช่ auto-increment ให้ตั้งค่าเป็น false
    protected $keyType = 'string'; // กำหนดประเภทของ primary key ถ้าเป็น string

    // เพิ่มตัวแปร $fillable เพื่อระบุฟิลด์ที่อนุญาตให้ทำการกำหนดค่าแบบกลุ่ม
    protected $fillable = [
        'ProductID', 'ProductName', 'Price', 'stock', 'Description', 'CategoryID'
    ];

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'ProductID', 'ProductID');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'ProductID', 'ProductID');
    }

    public function category()
    {
        return $this->hasOne(Categories::class, 'CategoryID', 'CategoryID');
    }
}
