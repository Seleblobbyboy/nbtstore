<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $primaryKey = 'ImageID'; // กำหนดให้ใช้ ImageID เป็น primary key
        public function Products()
    {
        return $this->belongsTo(Products::class, 'ProductID','ProductID');
    }
}
