<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $user = User::select('id')->where('token', $request->token)->first();
        Cart::insert([
            'book_id' => $request->book_id,
            'user_id' => $user->id,
        ]);
        return response()->json([
            'message' => __('messages.Added'),
            'code'=> 200],
            200);       
    }

    public function showCart(Request $request)
    {
        $user = User::select('id')->where('token', $request->token)->first();
        $cartItems = Cart::where('user_id',$user->id)->with('book')->get();
        $total_price = $this->totalPrice($request);
        return response()->json([
            'Order' => $cartItems,
            'Total Price' =>$total_price,
            'code'=> 200],
            200);   
    }

    public function totalPrice($request)
    {
        $user = User::select('id')->where('token', $request->token)->first();
        $book_price = Cart::with('book')->where('user_id',$user->id)->get();
        $total_price = 0;
            if(count($book_price)>0){
                foreach($book_price as $item){
                    $total_price +=$item->book->price;
            }
        }
        return $total_price;
    }

    public function delete($id)
    {
        if($cartItem=Cart::find($id))
        {
            $cartItem->delete();
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


    






    

    private function getPaymentStatus($id, $resourcepath)
    {
        $url = config('payment.hyperpay.url');
        $url .= $resourcepath;
        $url .= "?entityId=" . config('payment.hyperpay.entity_id');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . config('payment.hyperpay.auth_key')));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, config('payment.hyperpay.production'));// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
}
