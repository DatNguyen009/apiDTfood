<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ncc;

class SetPriceNccController extends Controller
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
        $timeTomorrow =explode(" ",  Carbon::tomorrow()); 
      
        if ($timenow[1] <= "19:30:00") {
            $ncc = ncc::whereDate("NCC_dateCreated", $timenow[0])->get();
            return $ncc;
        }else {
            $ncc = ncc::whereDate("NCC_dateCreated", $timeTomorrow[0])->get();
            return $ncc;
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
        ncc::where('materials_name',$request->name)->where('NCC_dateCreated',$request->day)->update(['materials_price' => $request->valuePrice]);
        return "success";
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
