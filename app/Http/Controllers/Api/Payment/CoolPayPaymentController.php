<?php

namespace App\Http\Controllers\Api\Payment;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Membership;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CoolPayPaymentController extends Controller
{
    public function payAds(Request $request){
        $response=Http::acceptJson()->withBody(
            json_encode(
                [
                    "transaction_amount"=>$request->price,
                    "transaction_currency"=>"XAF",
                    "transaction_reason"=> "Abonnement Annonce",
                    "app_transaction_ref"=>$request->transaction_id,
                    "customer_phone_number"=>Auth::guard('api')->user()->phone_number,
                    "customer_name"=>Auth::guard('api')->user()->username,
                    "customer_email"=>Auth::guard('api')->user()->email,
                    "customer_lang"=>"fr",
                  ]),'application/json')->post('https://my-coolpay.com/api/058196db-98d7-4fc2-9988-82e2e14b2b8e/paylink',[

        ]);

        return json_decode($response);
    }

    public function payCredit(Request $request){
        $response=Http::acceptJson()->withBody(
            json_encode(
                [
                    "transaction_amount"=>$request->price,
                    "transaction_currency"=>"XAF",
                    "transaction_reason"=> "Abonnement Annonce",
                    "app_transaction_ref"=>$request->transaction_id,
                    "customer_phone_number"=>Auth::guard('api')->user()->phone_number,
                    "customer_name"=>Auth::guard('api')->user()->username,
                    "customer_email"=>Auth::guard('api')->user()->email,
                    "customer_lang"=>"fr",
                  ]),'application/json')->post('https://my-coolpay.com/api/929cc610-94ba-40ff-9970-56e1f6e891ac/paylink',[

        ]);

        return json_decode($response);
    }
    public function payPlan(Request $request){
        $response=Http::acceptJson()->withBody(
            json_encode(
                [
                    "transaction_amount"=>$request->price,
                    "transaction_currency"=>"XAF",
                    "transaction_reason"=> "Abonnement Annonce",
                    "app_transaction_ref"=>$request->transaction_id,
                    "customer_phone_number"=>Auth::guard('api')->user()->phone_number,
                    "customer_name"=>Auth::guard('api')->user()->username,
                    "customer_email"=>Auth::guard('api')->user()->email,
                    "customer_lang"=>"fr",
                  ]),'application/json')->post('https://my-coolpay.com/api/e2743f08-469a-4945-ae2b-d5a724ec75ae/paylink',[

        ]);

        return json_decode($response);
    }

    public function callbackAds(Request $request){
        $payment=Payment::where('transaction_ref',$request->transaction_ref)
        ->where('payment_of','=',"Ads")->first();

        if($request->transaction_status==="SUCCESS"){

           $payment->status="2";
           $payment->save();
           $membership=Membership::find($payment->membership_id);
            $announcement=Announcement::find($payment->announcement_id);
            $newDateTime = Carbon::now()->addDay(intval($membership->period));
            $newDateTime->setTimezone('Africa/Douala');
            $announcement->status=1;
            $announcement->isSubscribe=1;
            $announcement->expire=null;
            $announcement->subscribe_id=$membership->id;
            if($announcement->save()){
                DB::table('memberships_users')->insert([
                    'user_id'=>$payment->user_id,
                    'membership_id'=>$membership->id,
                    'payment_id'=>$payment->id,
                    'expire_at'=>$newDateTime,
                    'announcement_id'=>$announcement->id,
                    'status'=>1
                ]);
            }
        }else if($request->transaction_status==="FAILED"){
            $payment->status="1";
            $payment->save();
        }
    }
    public function callbackCredits(Request $request){
        $payment=Payment::where('transaction_ref',$request->transaction_ref)
        ->where('payment_of','=',"credit")->first();

        if($request->transaction_status==="SUCCESS"){
            $payment->status="2";
            $payment->save();
            $user=User::find($payment->user_id);
            $user->balance=$user->balance+$payment->price;
            $user->save();
        }else if($request->transaction_status==="FAILED"){
            $payment->status="1";
            $payment->save();
        }
    }
    public function callbackPlan(Request $request){
        $payment=Payment::where('transaction_ref',$request->transaction_ref)
        ->where('payment_of','=',"premium")->first();

        if($request->transaction_status==="SUCCESS"){
            $user=User::find($payment->user_id);
            $memberShip=Membership::find($payment->membership_id);
            $user->isSubscribe=1;
            $payment->status="2";
            $payment->save();
        if($user->save()){


            $newDateTime = Carbon::now()->addDay(intval($memberShip->period));
            $newDateTime->setTimezone('Africa/Douala');
            DB::table('members')->insert([
                'user_id'=>$user->id,
                'membership_id'=>4,
                'payment_id'=>$payment->id,
                'expire_at'=>$newDateTime,
                'status'=>1
            ]);
        }
        }else if($request->transaction_status==="FAILED"){
            $payment->status="1";
            $payment->save();
        }
    }
}
