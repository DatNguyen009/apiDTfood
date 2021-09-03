<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\images;

class PostImageController extends Controller
{
    //
    public function postImage(Request $request) {
        images::insert(["product_id" => $request->slug, "images_url" => $request->image_url]);
        return "success";
    }
}
