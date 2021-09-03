<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qtvnccs extends Model
{
    use HasFactory;
    protected $fillable = [
        "ID",
        "materials_name",
        "materials_amount",
        "materials_price",
        "materials_unit",
        "NCC_dateCreated",
    ];
}
