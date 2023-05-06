<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthAdminController extends Controller
{
    public function login(Request $request)
    {
       
        $name = $request->name;
        $email=$request->email;
        $pass=Hash::make($request->password);
        $admin= Admin::select()->where('name',$name)->where('email',$email)->where('password',$pass)->first();

        if(!isset($admin)){
            return response()->json([
                'message'=>__('messages.Unauthorized'),
                'code' => 201]
                ,201);
        }

        $token = \Str::random(60);
        Admin::where('email',$email)->update([
            'Token'=>$token
        ]);
        // $admin=Admin::where('email',$email)->first();
            return response()->json([
                'Token'=>$admin->token,
                'messsage'=>'has login',
                'username'=>$admin->name,
                'code'=>200]
                ,200);
        }

    // public function register(Request $request)
    // {
    //     $admin = new Admin();
    //     $admin->name = $request->name;
    //     $admin->email = $request->email;
    //     $admin->password = Hash::make($request->password);
    //     $admin->Token = \Str::random(32);
    //     $admin->save();

    //     return response()->json(['Token' => $admin->Token]);
    // }
}
