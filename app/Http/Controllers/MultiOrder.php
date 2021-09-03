<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\cart;
use App\Models\orderdetail;


class MultiOrder extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        if (\count($request->data) == 0) {
            return "error";
        } else {
            order::insert(['customers_id' => $request->data[0]['customers_id'], 'order_status' => 'chua giao hang' ,'order_dateCreated' => $request->order_dateCreated, 'order_dateReceived' => $request->order_dateReceived]);

            $order_id = order::select("order_id")->where("customers_id",$request->data[0]['customers_id'])->where("order_dateCreated", $request->order_dateCreated)->get();

            for ($i=0; $i < count($request->data); $i++) { 
                $order_id->each(function($item) use($request, $i) {
                    orderdetail::insert(['order_id' => $item->order_id,'product_id' => $request->data[$i]['product_id'],'orderDetail_amount' =>  $request->data[$i]['product_amount'], 'orderDetail_totalMoney' => $request->data[$i]['product_totalPrice'],'orderDetail_price' => (int)$request->data[$i]['product_totalPrice']/$request->data[$i]['product_amount'] ]);
                });
                cart::where("product_id", $request->data[$i]['product_id'])->where("customers_id", $request->data[$i]['customers_id'])->delete();
            }

            return "success";
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
