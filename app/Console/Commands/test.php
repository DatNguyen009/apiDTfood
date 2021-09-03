<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\order;
use App\Models\orderdetail;
use App\Models\materials;
use App\Models\ncc;
use App\Models\materialnorms;
use App\Models\supplierprices;
use App\Models\tests;
use App\Models\qtvnccs;




class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'chuyen du lieu qua cho nha cung cap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $timeTomorrow = explode(" ",  Carbon::tomorrow());
        $order =  order::where("order_status", "chua giao hang")->whereDate('order_dateReceived', $timeTomorrow[0])->get();

        if (count($order) > 0) {
        
            $getPrice =  supplierprices::all();

            $mapOrder =  $order->map(function ($item)  {
                return[
                    "order_id" => $item->order_id,
                    "customers_id" => $item->customers_id,

                    "order_detail" => orderdetail::where("order_id",$item->order_id)->get()->map(function ($itemA) use($item) {
                        return[
                            "order_id" => $itemA->order_id,
                            "product_id" => $itemA->product_id,
                            "order_materials" =>  materials::where('product_id',$itemA->product_id)->get()->map(function ($itemB) use($itemA, $item) {
                                return[
                                    "materials_name" => $itemB->materials_name,
                                    "materials_amount" => (float)$itemB->materials_amount * $itemA->orderDetail_amount,
                                    "materials_unit" => $itemB->materials_unit,
                                    "order_dateReceived" => $item->order_dateReceived,
                                ];
                            }),
                            "orderDetail_amount" => $itemA->orderDetail_amount,
                            "orderDetail_price" => $itemA->orderDetail_price,
                            "orderDetail_totalMoney" => $itemA->orderDetail_totalMoney,
                        ];
                    }),
                
                    "order_status" => $item->order_status,
                    "order_dateCreated" => $item->order_dateCreated,
                
                ];
            });

            $array = [];
            for ($i=0; $i <count($mapOrder) ; $i++) { 
                # code...
                for ($j=0; $j < count($mapOrder[$i]['order_detail']) ; $j++) { 
                    for ($k=0; $k < count($mapOrder[$i]['order_detail'][$j]["order_materials"]) ; $k++) { 
                        array_push($array, (object)[
                            'material_name' => $mapOrder[$i]['order_detail'][$j]["order_materials"][$k]["materials_name"],
                            'material_amount' => $mapOrder[$i]['order_detail'][$j]["order_materials"][$k]["materials_amount"],
                            'material_price' => 0,
                            'material_unit' => $mapOrder[$i]['order_detail'][$j]["order_materials"][$k]["materials_unit"],
                            'order_created' => $mapOrder[$i]['order_detail'][$j]["order_materials"][$k]["order_dateReceived"]
                        ]);
                    }
                    
                }
            }

            $test = [];
            $r = [];
            
            for ($i=0; $i < count($array) ; $i++) { 
                # code...
                $key = $array[$i]->material_name;
                $amount = $array[$i]->material_amount;
                if (!in_array($key, $test)) {   
                    array_push($r, $array[$i]);
                    array_push($test, $key);
                }
                else {
                    collect($r)->filter(function($item) use($key, $amount) {
                        if ($item->material_name == $key) {
                            $item->material_amount += $amount;
                        }
                    });
                }
            }
            
            for ($i=0; $i < \count($r); $i++) { 
                $key = $r[$i]->material_name;
                $amount = $r[$i]->material_amount;
                $materialNorm = materialnorms::where("material_name",$key)->get();
                if ($materialNorm->count() > 0) {
                    $materialNorm->filter(function($item) use($key, $amount,$r, $i) {
                        if (($key == $item->material_name) && (($item->material_dms < $amount) && ($item->material_dmt > $amount))) {
                            $r[$i]->material_amount += $item->material_slhh;
                        }
                    });
                }
            }
        
            $a = [];

            $b = collect($r)->reduce(function($a, $item) use($getPrice){
                
                for ($i=0; $i < count($getPrice) ; $i++) { 
                    if ($item->material_name === $getPrice[$i]["materials_name"]) {
                        if ($item->material_unit == "gram") {
                            $item->material_price = ($item->material_amount * $getPrice[$i]["materials_price"]) / 1000;
                            
                            array_push($a, (object)[
                                "material_name" =>  $item->material_name,
                                "material_amount" =>  $item->material_amount,
                                "material_price" =>  $item->material_price,
                                "material_unit" =>  $item->material_unit,
                                "order_created" =>  $item->order_created,
                            ]); 
                            
                        } else {
                            if ($item->material_unit == "miếng" || $item->material_unit == "củ" || $item->material_unit == "cái" || $item->material_unit == "trái") {
                                $item->material_price = ($item->material_amount * $getPrice[$i]["materials_price"]);
                                array_push($a, (object)[
                                    "material_name" =>  $item->material_name,
                                    "material_amount" =>  $item->material_amount,
                                    "material_price" =>  $item->material_price,
                                    "material_unit" =>  $item->material_unit,
                                    "order_created" =>  $item->order_created,
                                ]); 
                            }
                        }
                    }
                }
                
                return $a;
            },[]);



            $c =  collect($b)->map(function ($item)  {
                return[
                    "material_name" =>  $item->material_name,
                    "material_amount" =>  $item->material_amount,
                    "material_price" =>  supplierprices::select("materials_price")->where("materials_name", $item->material_name)->get(),
                    "material_unit" =>  $item->material_unit,
                    "order_created" =>  $item->order_created,
                    "total_cost" => $item->material_price
                ];
            });
    
            for ($i=0; $i <count($c) ; $i++) { 
                ncc::insert(["materials_name" => $c[$i]["material_name"], "materials_amount" => $c[$i]["material_amount"],"materials_price" => $c[$i]["total_cost"] ,"materials_unit" => $c[$i]["material_unit"], "NCC_dateCreated" => $c[$i]["order_created"] ]);
            }
        }
      
    }
}
