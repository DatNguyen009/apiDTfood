<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ncc extends Model
{
    use HasFactory;
    protected $fillable = [
       "materials_name",
       "materials_amount",
       "materials_price",
       "materials_unit",
       "NCC_dateCreated" 
    ];
    
    public $timestamps = false;

    protected $casts = [
        "materials_price" => 'integer'
    ];
}
