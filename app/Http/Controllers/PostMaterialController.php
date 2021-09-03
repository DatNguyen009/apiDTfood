<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materials;
use Illuminate\Support\Str;


class PostMaterialController extends Controller
{
    //

    public function test(Request $request)
    {
     
        materials::insert([
            "product_id" => $request->slug,
            "materials_name" => $request->name,
            "materials_amount" => $request->amount,
            "materials_unit" => $request->unit,
            "materials_image" => $request->image_url,

        ]);
         
        return "success";
    }
}
