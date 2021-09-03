<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customers;

class UserManagementControllerr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user  = customers::all();
        if ($user->count() > 0) {
            return response()->json(["status" => 200, "data" => $user ], 200);
        } else {
            return response()->json(["msg" => "Không có dữ liệu!!!"], 200);
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
        $infor = customers::where("customers_email", $id)->get();
        if ($infor->count() > 0) {
            return response()->json(["status" => 200, "data" => $infor ], 200);
        } else {
            return response()->json(["msg" => "Không có dữ liệu!!!"], 200);
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
     
        $deleteUser = customers::where("customers_id",$id)->delete();
           
        if ($deleteUser) {
            return response()->json(["status" => 200, "msg" => "Successfully"], 200);
        } 
    }
}
