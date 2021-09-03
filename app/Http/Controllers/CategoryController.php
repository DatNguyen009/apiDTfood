<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\ncc;

class CategoryController extends Controller
{
    //
    public function postCategory(Request $request) {
        category::insert(["product_id" => $request->slug, "category_name" => $request->category_name]);
        return "success";
    }
   
    public function show($id) {
        return category::where("product_id", $id)->get();
    }

    
}
