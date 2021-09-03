<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materials extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'materials_name',
        'materials_unit',
        'materials_amount',
        'materials_image',
    ];
    
}
