<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ncc;

class NccController extends Controller
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
            for ($i=0; $i < count($request->data); $i++) { 
                ncc::insert(['materials_name' => $request->data[$i]['material_name'], 'materials_amount' => $request->data[$i]['material_amount'],'materials_unit' => $request->data[$i]['material_unit'], 'NCC_dateCreated' => $request->data[$i]['order_created']]);
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
