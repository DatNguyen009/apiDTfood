<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\orderdetail;
use App\Models\materials;
use App\Models\products;

class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $timenow = explode(" ",  Carbon::now());
        $timeTomorrow = explode(" ",  Carbon::tomorrow());
        if ($timenow[1] <= "19:30:00") {
            
            $order = order::whereDate('order_dateReceived', $timenow[0])->where("order_status", "chua giao hang")->orwhereDate('order_dateReceived', $timenow[0])->where("order_status", "Giao thành công")->orwhereDate('order_dateReceived', $timenow[0])->where("order_status", "Đang giao hàng")->get();

            if (count($order) == 0) {
                return response()->json(["message" => "Hôm nay không có đơn hàng nào cả!!!!"]);
            } else {
            
                $mapOrder =  $order->map(function ($item)  {
                    return[
                    
                        "order_id" => $item->order_id,
                        "customers_id" => $item->customers_id,
                        
                        "order_status" => $item->order_status,
                        "order_detail" => orderdetail::where("order_id", $item->order_id)->get(),
                        "order_dateCreated" => $item->order_dateCreated,
                        "order_dateReceived" => $item->order_dateReceived,
                    ];
                });

            
                $kitchen = collect($mapOrder)->reduce(function ($a ,$item) {
                    for ($i=0; $i < count($item["order_detail"]); $i++) { 
                        $key = $item["order_detail"][$i]["product_id"];
                        $amount = $item["order_detail"][$i]["orderDetail_amount"];
                        if (!in_array($key, $a[0])) {
                            array_push($a[0],$key);
                            array_push($a[1],$item["order_detail"][$i]);
                        }
                        else{
                            collect($a[1])->filter(function($item) use($key, $amount) {
                                if ($item->product_id == $key) {
                                    $item->orderDetail_amount += $amount;
                                }
                            });
                        }
                    }
                    return $a;
                }, [[],[]]);
        
                $mapOrder1 = collect($kitchen[1])->map(function($item) {
                    return[
                        "order_id" => $item->order_id,
                        "product_name" => products::select('product_name')->where('product_slug',$item->product_id)->get(),
                        "orderDetail_amount" => $item->orderDetail_amount,
                        "product_price" => products::select('product_price')->where('product_slug',$item->product_id)->get(),
                        "product_id" => $item->product_id,
                        "order_dateReceived" => order::select("order_dateReceived")->where("order_id",$item->order_id)->get(),
                        "order_materials" =>  materials::where('product_id',$item->product_id)->get()->map(function ($itemA) use($item) {
                            return[
                                "materials_name" => $itemA->materials_name,
                                "materials_amount" => (float)$itemA->materials_amount * $item->orderDetail_amount,
                                "materials_unit" => $itemA->materials_unit,
                            ];
                        }),
                    ];
                }); 

                return response()->json($mapOrder1, 200);
            }

        }else {
            
            $order = order::whereDate('order_dateReceived', $timeTomorrow[0])->where("order_status", "chua giao hang")->orwhereDate('order_dateReceived', $timeTomorrow[0])->where("order_status", "Giao thành công")->orwhereDate('order_dateReceived', $timeTomorrow[0])->where("order_status", "Đang giao hàng")->get();
            if (count($order) == 0) {
                return response()->json(["message" => "Hôm nay không có đơn hàng nào cả!!!!"]);
            } else {
            
                $mapOrder =  $order->map(function ($item)  {
                    return[
                    
                        "order_id" => $item->order_id,
                        "customers_id" => $item->customers_id,
                        
                        "order_status" => $item->order_status,
                        "order_detail" => orderdetail::where("order_id", $item->order_id)->get(),
                        "order_dateCreated" => $item->order_dateCreated,
                        "order_dateReceived" => $item->order_dateReceived,
                    ];
                });

            
                $kitchen = collect($mapOrder)->reduce(function ($a ,$item) {
                    for ($i=0; $i < count($item["order_detail"]); $i++) { 
                        $key = $item["order_detail"][$i]["product_id"];
                        $amount = $item["order_detail"][$i]["orderDetail_amount"];
                        if (!in_array($key, $a[0])) {
                            array_push($a[0],$key);
                            array_push($a[1],$item["order_detail"][$i]);
                        }
                        else{
                            collect($a[1])->filter(function($item) use($key, $amount) {
                                if ($item->product_id == $key) {
                                    $item->orderDetail_amount += $amount;
                                }
                            });
                        }
                    }
                    return $a;
                }, [[],[]]);
        
                $mapOrder1 = collect($kitchen[1])->map(function($item) {
                    return[
                        "order_id" => $item->order_id,
                        "product_name" => products::select('product_name')->where('product_slug',$item->product_id)->get(),
                        "orderDetail_amount" => $item->orderDetail_amount,
                        "product_price" => products::select('product_price')->where('product_slug',$item->product_id)->get(),
                        "product_id" => $item->product_id,
                        "order_dateReceived" => order::select("order_dateReceived")->where("order_id",$item->order_id)->get(),
                        "order_materials" =>  materials::where('product_id',$item->product_id)->get()->map(function ($itemA) use($item) {
                            return[
                                "materials_name" => $itemA->materials_name,
                                "materials_amount" => (float)$itemA->materials_amount * $item->orderDetail_amount,
                                "materials_unit" => $itemA->materials_unit,
                            ];
                        }),
                    ];
                }); 

                return response()->json($mapOrder1, 200);
            }

        }
        
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
       $order = order::whereDate('order_dateReceived', $id)->get();
        
       $mapOrder =  $order->map(function ($item)  {
            return[
            
                "order_id" => $item->order_id,
                "customers_id" => $item->customers_id,
                
                "order_status" => $item->order_status,
                "order_detail" => orderdetail::where("order_id", $item->order_id)->get(),
                "order_dateCreated" => $item->order_dateCreated,
                "order_dateReceived" => $item->order_dateReceived,
            ];
        });

    
        $kitchen = collect($mapOrder)->reduce(function ($a ,$item) {
            for ($i=0; $i < count($item["order_detail"]); $i++) { 
                $key = $item["order_detail"][$i]["product_id"];
                $amount = $item["order_detail"][$i]["orderDetail_amount"];
                if (!in_array($key, $a[0])) {
                    array_push($a[0],$key);
                    array_push($a[1],$item["order_detail"][$i]);
                }
                else{
                    collect($a[1])->filter(function($item) use($key, $amount) {
                        if ($item->product_id == $key) {
                            $item->orderDetail_amount += $amount;
                        }
                    });
                }
            }
            return $a;
        }, [[],[]]);

        $mapOrder1 = collect($kitchen[1])->map(function($item) {
            return[
                "order_id" => $item->order_id,
                "product_name" => products::select('product_name')->where('product_slug',$item->product_id)->get(),
                "orderDetail_amount" => $item->orderDetail_amount,
                "product_id" => $item->product_id,
                "order_dateReceived" => order::select("order_dateReceived")->where("order_id",$item->order_id)->get(),
                "order_materials" =>  materials::where('product_id',$item->product_id)->get()->map(function ($itemA) use($item) {
                    return[
                        "materials_name" => $itemA->materials_name,
                        "materials_amount" => (float)$itemA->materials_amount * $item->orderDetail_amount,
                        "materials_unit" => $itemA->materials_unit,
                    ];
                }),
            ];
        }); 

        return response()->json($mapOrder1, 200);
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
