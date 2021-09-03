<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\products;
use App\Models\images;
use App\Models\materials;


class RelatedFoodController extends Controller
{
    //
    public function relatedFood()
    {
       
        $products = products::where("isDeleted","0")->get();;
        $image = images::all();

        
        $mapProduct = $products->map(function($products, $key) {

            return[
                "product_id" => $products->product_id,
                "product_name" => $products->product_name,
                "product_slug" => $products->product_slug,
                "product_image" => images::where("product_id",$products->product_slug)->get(),
                "product_material" => materials::where("product_id",$products->product_slug)->get(),
                "product_price" => $products->product_price,
                "product_category" => category::where("product_id",$products->product_slug)->get(),
                "product_status" => $products->product_status,
                "product_description" => $products->product_description,
                "product_sold" => $products->product_sold,
              
            ];
        });
      

        return $mapProduct;
    }
    public function trendingFood()
    {
        $products = products::where("isDeleted","0")->take(6)->get();;
        $image = images::all();

        
        $mapProduct = $products->map(function($products, $key) {

            return[
                "product_id" => $products->product_id,
                "product_name" => $products->product_name,
                "product_slug" => $products->product_slug,
                "product_image" => images::where("product_id",$products->product_slug)->get(),
                "product_material" => materials::where("product_id",$products->product_slug)->get(),
                "product_price" => $products->product_price,
                "product_category" => category::where("product_id",$products->product_slug)->get(),
                "product_status" => $products->product_status,
                "product_description" => $products->product_description,
                "product_sold" => $products->product_sold,
              
            ];
        });
      

        return $mapProduct;
    }
}
