<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customers;
use App\Models\User;
use Crypt;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all post 
        $getAll = customers::all();
        return $getAll;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create a post 
        return customers::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // show a post
        $find = customers::where('customers_email',$id)->get();
        if (count($find) == 0) {
            return response()->json(['message' => "Không tìm thấy kết quả"], 200); 
        } else {
            return response()->json($find, 201); 
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
        // update a post 
        $find = User::where("email",$request->email)->get();
        if (count($find) == 0) {
            return response()->json(['message' => "Cập nhật mật khẩu không thành công"], 200); 
        } else {
            $update = User::where('email', $request->email)->update(['password' => bcrypt($request->newPass)]);
            return response()->json(['message' => "Cập nhật mật khẩu thành công", 'status' => 'successfully'], 200); 
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
        // delete a post
        return customers::delete($id);
    }
}
