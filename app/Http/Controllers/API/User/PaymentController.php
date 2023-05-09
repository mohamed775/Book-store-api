<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function buy(Request $request){
        $price=$request->amount;
           $url = "https://eu-test.oppwa.com/v1/checkouts";
           $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                       "&amount=".$price .
                       "&currency=EUR" .
                       "&paymentType=DB";



           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                           'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
           curl_setopt($ch, CURLOPT_POST, 1);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           $responseData = curl_exec($ch);
           if(curl_errno($ch)) {
               return curl_error($ch);
           }
           curl_close($ch);
           // return $responseData;
           $response=json_decode($responseData,true);
           $book_id=$request->book_id;

           return response()->json([
               'status' => true,
               'content'=> $response
            ]);
       }


       public function storeTransaction(Request $request){
           return $request;
       }
}
