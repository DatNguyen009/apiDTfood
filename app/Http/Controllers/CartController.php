<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\products;
use App\Models\images;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cart = cart::all();
      
        $newCart = $cart->map(function ($item) {
            return[
                'product_id' => $item->product_id,
                'product_info' => products::select('product_name')->where('product_slug', $item->product_id)->get(),
                'product_image' => images::select('images_url')->where('product_id', $item->product_id)->get(),
                'customers_id' => $item->customers_id,
                'product_amount' => $item->product_amount,
                'product_totalPrice' => $item->product_totalPrice,
                'isDeleted' => $item->isDeleted,
              
            ];
        });

        return $newCart;
       
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
        $productExits = cart::where('product_id', $request->product_id)->where('customers_id', $request->customers_id)->get()->count();
        if ($productExits == 0) {
            # code...
            cart::insert(['product_id' => $request->product_id, 'customers_id' => $request->customers_id, 'product_amount' => $request->product_amount, 'product_totalPrice' => $request->product_totalPrice]);
            return "success";
        } else {
            # code...
            $getItem = cart::where('product_id', $request->product_id)->where('customers_id', $request->customers_id)->get();
            
            cart::where('product_id', $request->product_id)->where('customers_id', $request->customers_id)->update(['product_amount' => $getItem[0]['product_amount'] + $request->product_amount, 'product_totalPrice' => $getItem[0]['product_totalPrice'] + $request->product_totalPrice]);
            return "error";
        }
        
        
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
        $cart = cart::where('customers_id',$id)->get();
      
        $newCart = $cart->map(function ($item) {
            return[
                'product_id' => $item->product_id,
                'product_info' => products::select('product_name')->where('product_slug', $item->product_id)->get(),
                'product_image' => images::select('images_url')->where('product_id', $item->product_id)->get(),
                'customers_id' => $item->customers_id,
                'product_amount' => $item->product_amount,
                'product_totalPrice' => $item->product_totalPrice,
                'isDeleted' => $item->isDeleted,
              
            ];
        });

        return $newCart;
    
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
        $array = explode('_', $id);
        cart::where('product_id', $array[0])->where('customers_id', $array[1])->delete();
        return "success";
    }
}
