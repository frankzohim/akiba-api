<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Payment;
use App\Events\MakePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PurchaseCreditController extends Controller
{
    public function purchaseCredit($price,$user_id,$transaction_id){
        $user=User::find($user_id);
        $paymentExist=Payment::where('transaction_id',$transaction_id)->first();
        if(!isset($paymentExist)){
            $data=[
                'payment_type'=>"Momo",
                'price'=>$price,
                "payment_of"=>"credit",
                'transaction_id'=>$transaction_id,
                'membership_id'=>null,
                'announcement_id'=>null,
                'status'=>"0",
                'user_id'=>$user_id
            ];
            $payment=event(new MakePayment($data));
            return response()->json(['message'=>"payment Pending"]);
    }

    }
}
