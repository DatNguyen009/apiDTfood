<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materialnorms extends Model
{
    use HasFactory;
    protected $fillable = [
        "material_id",
        "material_name",
        "material_dmt",
        "material_dms",
        "material_slhh" 
     ];
     
     public $timestamps = false;
 
     protected $casts = [
         "material_dmt" => 'integer',   
         "material_dms" => 'integer',
         "material_slhh" => 'integer',
     ];

}
