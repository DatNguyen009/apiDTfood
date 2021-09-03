<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\customers;
use App\Models\User;
use Mail;
use Crypt;
use Auth;


class LoginController extends Controller
{
    //
    public function login(Request $request) {

        if (Auth::attempt(['email' => $request->customers_email, 'password' => $request->customers_password])) {
            $customer = customers::where('customers_email', $request->customers_email)->get();
            return response()->json(['statusCode' => 200,"msg" => "Successfuly", "data" => $customer], 200);
        }
        else {
            return  response()->json(['statusCode' => 401, 'msg' => "Đăng nhập thất bại"], 401);;
        }
        
    }

    public function PostRegister(Request $request) {

        $checkusername = customers::where('customers_email', $request->customers_email)->get();
        if (count($checkusername) > 0 ) {
            return response()->json(['statusCode' => 200,'result' => "fail", 'msg' => "User đã tồn tại!!!"], 200);
        } else {
           
            customers::insert([
                "customers_name" => $request->customers_name,
                "customers_email" => $request->customers_email,
                "customers_address" => $request->customers_address,
                "customer_phone" => $request->customers_phone,
                "customers_password" => bcrypt($request->customers_password),
                "remember_token" => Str::random(60),
            ]);

            User::insert([
                "name" => $request->customers_name,
                "email" => $request->customers_email,
                "password" => bcrypt($request->customers_password),
                "remember_token" => Str::random(60),
            ]);
            
            return response()->json(['statusCode' => 200, 'msg' => "Successfuly"], 200);
        }
        
    }

    
    public function ForgetPass(Request $request) {
        $findUser = customers::where('customers_email', $request->email)->get();
        if ($findUser->count() > 0) {
            $email = $request->email;
            $data = [
                'name' => "",
            ];
            Mail::send('EmailUser',$data ,function ($message) use ($email) {
                $message->from('datseto2018@gmail.com', 'DT Food');
            
                $message->to($email);
            
                $message->subject('Xác nhận Email của Speedy');
            
            });
    
            return response()->json(['status' => 200, 'message' => "Successfully"], 200);
            
        } else {
            return response()->json(['status' => 200, 'message' => "Fail"], 200);
        }
        
    }
    
}
