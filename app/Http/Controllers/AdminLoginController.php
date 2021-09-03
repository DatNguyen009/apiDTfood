<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\administrator;
use App\Models\User;
use Crypt;
use Auth;
use Carbon\Carbon;
use App\Models\ncc;
use App\Models\qtvnccs;
use App\Models\tests;


class AdminLoginController extends Controller
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
        //dang ky tai khoan admin
        // User::insert([
        //     "name" => $request->name,
        //     "email" => $request->name,
        //     "password" => bcrypt($request->password),
        //     "remember_token" => Str::random(60),
        // ]);
        
        // return "success";
        if (Auth::attempt(['email' => $request->name, 'password' => $request->password])) {
            $infor = User::where('email', $request->name)->get();
            return $infor;
        }
        else {
            return 'error';
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
