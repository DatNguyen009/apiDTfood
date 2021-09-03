<?php
// co lien quan
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\order;
use App\Models\ncc;
use Illuminate\Http\Request;

use App\Models\orderdetail;
use App\Models\products;


class DataChart extends Controller
{
    //
   public function DataChartOrder($id)
   {
      
        $array = [];
        
        for ($i=1; $i < 13; $i++) { 
            $dt = Carbon::create($id, $i, 1);
            $startDay = explode(" ",$dt->startOfMonth());
            $endDay = explode(" ",$dt->endOfMonth());
            $DataOrder = order::where("order_status","Giao thành công")->whereDate("order_dateReceived",'>=', $startDay[0])->whereDate("order_dateReceived",'<=', $endDay[0])->get();

            $mapDataOrder = $DataOrder->map(function($item) {
                return[
                    "order_id" => $item->order_id,
                    "customers_id" => $item->customers_id ,
                    "order_status" => $item->order_status,
                    "order_totalMoney" => orderdetail::select("orderDetail_totalMoney")->where("order_id", $item->order_id)->get(),
                    "order_dateCreated" => $item->order_dateCreated,
                    "order_dateReceived" => $item->order_dateReceived,
                    
                ];
            });
         
            $getData =  ncc::whereDate("NCC_dateCreated",'>=', $startDay[0])->whereDate("NCC_dateCreated",'<=', $endDay[0])->get();
            
            $FilterDate = $DataOrder->reduce(function ($a ,$item) {
               
                $key = substr($item->order_dateReceived, 0,10);
                if (!in_array($key, $a)) {
                    array_push($a, $key);
                }
                return $a;
            }, []);
            
            $dat = [];
            for ($j=0; $j < \count($FilterDate); $j++) { 
               
                $getData =  ncc::whereDate("NCC_dateCreated", $FilterDate[$j])->get();
                array_push($dat, $getData);
            }

            $costStatistical = collect($dat)->reduce(function ($b ,$item) {
                foreach ($item as $key => $value) {
                    $b = $b + (float)$value->materials_price;
                }
                return $b;
            }, 0);
            
            $doanhthu = collect($mapDataOrder)->reduce(function ($a ,$item) {
                for ($k=0; $k < count($item["order_totalMoney"]); $k++) { 
                    $a = $a + (float)$item["order_totalMoney"][$k]["orderDetail_totalMoney"];
                }
                return $a;
            }, 0);

            array_push($array, (object)[
                'nameMonth' => 'Tháng'.' '.$i,
                'orderMonths' => $DataOrder->count(),
                'chiphi' => $costStatistical,
                'doanhthu' => $doanhthu
            ]);
            
        }
        return $array;

        
   }

   public function OrderDetail($id)
   {
       $orderdetail = orderdetail::where('order_id', $id)->get();
       $mapOrderDetail = $orderdetail->map(function ($item) {
            return[
                'order_id' => $item->order_id,
                'product_id' => $item->product_id,
                'product_name' => products::where("product_slug", $item->product_id)->select("product_name")->get(),
                'orderDetail_amount' => $item->orderDetail_amount,
                'orderDetail_price' => $item->orderDetail_price,
                'orderDetail_totalMoney' => $item->orderDetail_totalMoney,
            ];
       });

       return $mapOrderDetail;
   }
}
