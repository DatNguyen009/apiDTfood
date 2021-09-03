<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplierprices extends Model
{
    use HasFactory;
    protected $fillable = [
        "supplierprice_id ",
        "materials_name",
        "materials_amount",
        "materials_price",
        "materials_unit",
        "created_at",
    ];
    public $timestamps = false;
}
