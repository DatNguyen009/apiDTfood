<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\orderdetail;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return order::where("order_status", "chua giao hang")->orderBy("order_dateReceived","desc")
        ->paginate(3);
        
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
        if ($id === "orderSuccess") {
            return order::where("order_status", "Giao thành công")->orderBy("order_dateReceived","desc")
            ->paginate(3);
        }
        else {
            if ($id === "orderPacking") {
                return order::where("order_status", "Đang giao hàng")->orderBy("order_dateReceived","desc")
                ->paginate(3);
            }
            else {
                return order::where("order_status", "Đơn hàng đã hủy")->orderBy("order_dateReceived","desc")
                ->paginate(3);
            }
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
        if ($request->update == "pack") {
            
            order::where("order_id",$request->data)->update(["order_status" => "Đang giao hàng"]);
            return "success";
        } else {
            if ($request->update == "giao") {
                order::where("order_id",$request->data)->update(["order_status" => "Giao thành công"]);
                return "success";
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
        Carbon::setLocale('vi');
        $dt = Carbon::tomorrow('Asia/Ho_Chi_Minh');
        $now = Carbon::now('Asia/Ho_Chi_Minh');

        $a = explode(" ",$dt);
    
        $checkdate = order::where("order_id", $id)->whereDate("order_dateReceived",$a[0])->get();
       
       
        if ($checkdate->count() > 0) {
            if ($now->hour.":".$now->minute < "19:30" ) {
                order::where("order_id", $id)->update(["order_status" => "Đơn hàng đã hủy"]);
                return "success";
            }
            else{
                return "faildate";
            }
        }
        else{
            $checkdate = order::where("order_id", $id)->whereDate("order_dateReceived",">",$a[0])->get();
            if ($checkdate->count() > 0) {
                order::where("order_id", $id)->update(["order_status" => "Đơn hàng đã hủy"]);
                return "success";
            }
            else{
                return "faildate";
            }
           
          
        }
        
    }
}
