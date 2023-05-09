<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function cartDetails($request)
    {
        $user = User::select('id')->where('token', $request->token)->first();
        $cartItems = Cart::where('user_id',$user->id)->with('book')->get();
        return $cartItems;
    }

    public function totalPrice($request)
    {
        $book_price = $this->cartDetails($request);
        $total_price = 0;
            if(count($book_price)>0){
                foreach($book_price as $item){
                    $total_price +=$item->book->price;
            }
        }
        return $total_price;
    }


    public function showCart(Request $request)
    {
        // $transaction = $this->transaction($request);
        $cartItems = $this->cartDetails($request);
        $total_price = $this->totalPrice($request);
        return response()->json([
            'Order' => $cartItems,
            'Total Price' =>$total_price,
            // $transaction,
            'code'=> 200],
            200);  
            
    }
     
    public function transaction(Request $request)
    {
        $user = User::select('id')->where('token', $request->token)->first();
        if (request('id') && request('resourcePath')) {
            $payment_id=request('id');
            $resourcePath=request('resourcePath');
            if (isset($payment_id)) {
                $showSuccessPaymentMessage = true;
                Payment::create([
                    'transation_id'=>$payment_id,
                    'user_id'=> $user->id
                ]);
                Cart::where('user_id',$user->id)->delete();
                return response()->json(['success' => 'Transaction Successfully']);
            } else {
                $showFailPaymentMessage = true;
                return response()->json(['fail' => 'Transaction failed!']);
            }
        }
        return response()->json(['message' => 'Invalid request']);
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
