<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ncc;
use App\Models\supplierprices;


class HistoryPrice extends Controller
{
    //
    public function historyPriceSub($id)
    {
       
        $ncc = ncc::whereDate("NCC_dateCreated", $id)->get();
        $mapncc = $ncc->map(function($item) {
            return[
                "materials_name" => $item->materials_name,
                "materials_amount" => $item->materials_amount,
                "materials_total" => $item->materials_price,
                "materials_price" => supplierprices::select("materials_price")->where("materials_name", $item->materials_name)->get(),
                "materials_unit" => $item->materials_unit,
                "NCC_dateCreated" => $item->NCC_dateCreated,
            ];
        });
        return $mapncc;        
       
    }
}
