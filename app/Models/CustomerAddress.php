<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $primaryKey = 'AddressID'; // ระบุ Primary Key
    protected $fillable = [
        'CustomerID',
        'CustomerName',
        'Address',
        'PhoneNumber',
        'PostalCode',
        'Province',
        'District',
        'Subdistrict',
    ];
    public function Customers()
    {
        return $this->belongsTo(Customers::class, 'CustomerID', 'CustomerID');
    }
    function Orders(){
        return $this->hasOne(Orders::class,'AddressID','AddressID');
    }
    function Invoices()
    {
        return $this->hasOne(Invoices::class, 'AddressID ', 'AddressID');
    }
}
