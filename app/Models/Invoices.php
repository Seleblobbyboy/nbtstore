<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $primaryKey = 'InvoiceID';

    // กำหนดฟิลด์ที่สามารถทำ mass-assigned ได้
    protected $fillable = [
        'AddressID',
        'CustomerID',
        'FullName',
        'IDCardNumber',  // ตรวจสอบว่าอยู่ใน fillable หรือไม่
        'PhoneNumber',
        'Address',
        'PostalCode',
        'Province',
        'District',
        'Subdistrict'
    ];

    // กำหนดความสัมพันธ์กับโมเดล Customer
    public function Customers()
    {
        return $this->belongsTo(Customers::class, 'CustomerID', 'CustomerID');
    }
    
    function CustomerAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'AddressID ', 'AddressID');
    }
}
