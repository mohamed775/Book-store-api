<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select()->paginate(PAGINATION_COUNTER);

        return response()->json([
            $users,
            'code'=> 200],
            200);
    }

    public function delete($id)
    {
        if($user=User::find($id))
        {
            $user->delete();
            return response()->json([
                'message' =>__('messages.Deleted'),
                'code'=> 200],
                200);  
        }  
        else 
        {
            return response()->json([
                'message' =>__('messages.deleteFailed'),
                'code'=> 201],
                201); 
        }
    }
}
