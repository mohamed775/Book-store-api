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
        $credential = array('name' => $request->name,'email'=>$request->email,'password'=>$request->password);
        if(isset($credential))
        {
            return response()->json([
                'Token' => Admin::select('token')->first(),
                'messsage'=>__('messages.Login'),
                'code'=>200]
                ,200);
        }
        else
        {
            return response()->json([
                'message'=>__('messages.Unauthorized'),
                'code' => 201]
                ,201);
        }   
        
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
