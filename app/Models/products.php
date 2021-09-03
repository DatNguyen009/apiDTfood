<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_name',
        'product_slug',
        'product_price',
       
        'product_status',
        'product_description',
        'product_sold',
        'isDeleted'
    ];

    protected $casts = [
      
        'product_price' => 'integer',
        'product_sold' => 'integer',

    ];
}
