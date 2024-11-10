<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $primaryKey = 'CategoryID'; // Specify the primary key if it is not 'id'
    public $incrementing = false; // Set this if 'CategoryID' is not an auto-increment field (optional)
    function Products(){
        return $this->belongsTo(Products::class,'CategoryID','CategoryID');
    }
}
