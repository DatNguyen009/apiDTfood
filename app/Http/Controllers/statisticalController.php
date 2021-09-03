<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\orderdetail;
use App\Models\ncc;
use App\Models\products;
use App\Models\materials;

class statisticalController extends Controller
{
    //
    public function statistical($id) {
        $dateInput = explode("-", $id);
        $dt = Carbon::create($dateInput[0], $dateInput[1], 1);
        
        $startDay = explode(" ",$dt->startOfMonth());
        $endDay = explode(" ",$dt->endOfMonth());
        
        $order =  order::whereDate("order_dateReceived",'>=', $startDay[0])->whereDate("order_dateReceived",'<=', $endDay[0])->where("order_status", "Giao thành công")->get();
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
                
            ];
        }); 

        return $mapOrder1;
    }
    public function statisticalCost($id) {
        $dateInput = explode("-", $id);
        $dt = Carbon::create($dateInput[0], $dateInput[1], 1);
        
        $startDay = explode(" ",$dt->startOfMonth());
        $endDay = explode(" ",$dt->endOfMonth());
        $order = order::whereDate("order_dateReceived",'>=', $startDay[0])->whereDate("order_dateReceived",'<=', $endDay[0])->where("order_status", "Giao thành công")->get();
       
        if ($order->count() > 0) {
            $FilterDate = $order->reduce(function ($a ,$item) {
               
                $key = substr($item->order_dateReceived, 0,10);
                if (!in_array($key, $a)) {
                    array_push($a, $key);
                }
                return $a;
            }, []);
            
            $array = [];
            for ($i=0; $i < \count($FilterDate); $i++) { 
                $getData =  ncc::whereDate("NCC_dateCreated", $FilterDate[$i])->get();
                array_push($array, $getData);
            }
            
            if (count($array) > 0) {
                $costStatistical = collect($array)->reduce(function ($a ,$item) {
                    foreach ($item as $key => $value) {
                        $a = $a + (float)$value->materials_price;
                    }
                    return $a;
                }, 0);
               return $costStatistical;
            }
        }

    }
}
