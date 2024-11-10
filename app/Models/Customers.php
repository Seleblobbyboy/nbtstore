<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $primaryKey = 'CustomerID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'CustomerName',
        'Address',
        'PhoneNumber',
        'PostalCode',
        'Province',
        'District',
        'Subdistrict'
    ];

    function Users(){
        return $this->belongsTo(Users::class,'UserID','UserID');
    }
    function Orders(){
        return $this->hasMany(Orders::class,'CustomerID','CustomerID');
    }
    public function Invoices()
    {
        return $this->hasMany(Invoices::class, 'CustomerID', 'CustomerID');
    }
    public function CustomerAddress()
    {
        return $this->hasMany(CustomerAddress::class, 'CustomerID', 'CustomerID');
    }
    
}
