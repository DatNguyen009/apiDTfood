<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\images;
use App\Models\materials;
use App\Models\category;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //


        $products = products::where("product_slug", $id)->get();
        
        if ($products->count() == 0) {
            return \response()->json(['message' => 'Không tìm thấy kết quả']);
        } else {
            $image = images::all();

            $mapProduct = $products->map(function($products, $key) use($image) {
                return[
                    "product_id" => $products->product_id,
                    "product_name" => $products->product_name,
                    "product_slug" => $products->product_slug,
                    "product_image" => images::where("product_id",$products->product_slug)->get(),
                    "product_material" => materials::where("product_id",$products->product_slug)->get(),
                    "product_price" => $products->product_price,
                    "product_category" => category::where("product_id", $products->product_slug)->get(),
                    "product_status" => $products->product_status,
                    "product_description" => $products->product_description,
                    "product_sold" => $products->product_sold,
                    "isDeleted" => $products->isDeleted,
                    "created_at" => $products->created_at,
                    "updated_at" => $products->updated_at,
    
    
                ];
            });
            return \response()->json($mapProduct, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
