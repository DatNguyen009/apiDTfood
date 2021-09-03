<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\materials;
use App\Models\images;

class ProductPaginationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = products::where("isDeleted","0")->get();

        $mapProduct = $products->map(function($products, $key)  {
            return[
                "product_id" => $products->product_id,
                "product_name" => $products->product_name,
                "product_slug" => $products->product_slug,
                "product_image" => images::where("product_id",$products->product_slug)->get(),
                "product_price" => $products->product_price,
                // "product_amount" => $products->product_amount,
                "product_status" => $products->product_status,
                "product_description" => $products->product_description,
                "product_sold" => $products->product_sold,
                "isDeleted" => $products->isDeleted,
                "created_at" => $products->created_at,
                "updated_at" => $products->updated_at,


            ];
        });
        
        return $mapProduct->paginate(6);

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
        products::where("product_slug", $id)->update(["isDeleted" => "1"]);
        return "success";
    }
}
