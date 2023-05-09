<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->Token = \Str::random(32);
        $user->save();

        return response()->json([
            'Token' => $user->Token,
            'code'=>200]
            ,200);
    }


    public function login (Request $request)
    {

        $credential = array('name' => $request->name,'email'=>$request->email,'password'=>$request->password);
        if(Auth::attempt($credential))
        {
            return response()->json([
                'name'=>Auth::user()->name,
                'Token'=>Auth::user()->token,
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

}
