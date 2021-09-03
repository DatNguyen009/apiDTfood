<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'customers_id',
        'product_amount',
        'product_totalPrice',
        'isDeleted'
    ];
    public $timestamps = false;

    protected $casts = [
        'product_amount' => 'integer',
        'product_totalPrice' => 'integer'
    ];
}
