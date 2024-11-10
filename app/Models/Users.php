<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users'; // ชื่อตาราง
    protected $primaryKey = 'UserID'; // ระบุ primary key ให้ตรงกับฐานข้อมูล
    public $timestamps = true; // ถ้าคุณใช้ timestamps

    // ควรตั้งค่า fillable fields สำหรับการอัปเดต
    protected $fillable = ['Email', 'Password'];
    function Customers()
    {
        return $this->hasOne(Customers::class, 'UserID', 'UserID');
    }
}
