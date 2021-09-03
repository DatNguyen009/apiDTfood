<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\materials;
use App\Models\category;
use App\Models\ncc;

class GetSlug extends Controller
{
    //
    public function slugFood()
    {
        # code...
        return products::select('product_slug')->get();
    }
   
    public function slugMaterials()
    {
        # code...
        $slug = materials::select('product_id')->get();
        $total = $slug->reduce(function ($carry, $item) {
            $key = $item->product_id;
            if (!in_array($key, $carry)) {
                array_push($carry, $key);
            }
            return $carry;
        }, []);

        return $total;
    }
    public function slugCategory()
    {
        # code...
        $slug = category::select('product_id')->get();
        $total = $slug->reduce(function ($carry, $item) {
            $key = $item->product_id;
            if (!in_array($key, $carry)) {
                array_push($carry, $key);
            }
            return $carry;
        }, []);

        return $total;
    }
    public function getSlug($id)
    {
        # code...
        return category::where('product_id', $id)->get();
    }
    public function getMaterialfollowSlug($id)
    {
        # code...
        return materials::where('product_id', $id)->get();
    }

    
}
