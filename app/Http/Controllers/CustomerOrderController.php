<?php
// co lieen quan
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\order;
use App\Models\orderdetail;

class CustomerOrderController extends Controller
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
        order::insert(['customers_id' => $request->customers_id, 'order_status' => 'chua giao hang' ,'order_dateCreated' => $request->order_dateCreated, 'order_dateReceived' => $request->order_dateReceived]);
        $order_id = order::select("order_id")->where("customers_id",$request->customers_id)->where("order_dateCreated", $request->order_dateCreated)->get();
        $order_id->each(function($item) use($request) {
            orderdetail::insert(['order_id' => $item->order_id,'product_id' => $request->product_id,'orderDetail_amount' => $request->order_amount, 'orderDetail_totalMoney' => $request->order_totalMoney,'orderDetail_price' => $request->order_price]);
        });
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
        $order = order::where("customers_id",$id)->get(); 
        
        if (count($order) != 0) {
            return response()->json($order, 201); 
        } else {
            return response()->json(['message' => "Không tìm thấy kết quả"], 404); 
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
