<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\products;

class UploadFoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $allSlug = products::select("product_slug")->get();
        return $allSlug;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $allSlug = products::select("product_slug")->get();
        $slug = Str::slug($request->name, "-");
        $check = [];
        for ($i=0; $i < count($allSlug) ; $i++) { 
            array_push($check,$allSlug[$i]->product_slug);
        }
       
        if (in_array($slug, $check)) {
            $original = $slug;
            $count = 2;
            while (in_array($slug, $check)) {
                $slug = "$original-".$count++;
            }

        }

        products::create([
            "product_name" => $request->name,
            "product_slug" => $slug,
            "product_price" => $request->price,
            "product_status" => "còn",
            "product_description" => $request->description,
            "product_sold" => "0",
        ]);
         
        return "success";
        
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
        
        if ($request->data["type"] == "updateProduct") {
            $updateProduct =  products::where("product_slug", $request->data["slug"])->update(["product_name" => $request->data["name"],"product_price" => $request->data["price"], "product_description" => $request->data["description"] ]);
            if ($updateProduct == 1) {
                return true;
            }else {
                return false;
            }
        }
        
        
        
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
