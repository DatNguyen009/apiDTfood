<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'customers_id',
        'review_content',
        'review_dateCreated',
        'review_star'
    ];

    protected $casts = [
        'review_star' => 'integer'
    ];
}
