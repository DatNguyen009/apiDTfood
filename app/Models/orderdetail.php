<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderdetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'orderDetail_amount',
        'orderDetail_price',
        'orderDetail_totalMoney'
    ];
    public $timestamps = false;
}
