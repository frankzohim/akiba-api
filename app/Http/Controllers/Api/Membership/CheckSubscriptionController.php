<?php

namespace App\Http\Controllers\Api\Membership;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Membership;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Events\EventCheckExpire;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Events\EventCheckUpgradePlan;
use App\Events\EventCheckAdsSubscribe;
use App\Events\EventCheckSubscription;
use App\Events\EventCheckPlanSubscribe;
use App\Events\EventCheckCreditSubscribe;
use App\Events\DeleteAnnounceBanAccountEvent;

class CheckSubscriptionController extends Controller
{
    public function check(){
        event(new EventCheckSubscription());
        event(new EventCheckExpire());
        event(new EventCheckUpgradePlan());
        event(new DeleteAnnounceBanAccountEvent());



    }
    public function checkPayAds(){
        $this->checkPlan();
        $this->checkCreditSubscribe();
        $this->checkAds();

    }

    public function checkPayCredit(){
        $this->checkCreditSubscribe();

    }

    public function checkPayPlan(){
        $this->checkPlan();
    }


    public function checkAds(){
        $payments=Payment::where('payment_of',"=","Ads")
        ->where('user_id','=',Auth()->guard('api')->user()->id)
        ->where('status','=',"0")
        ->get();
        if(isset($payments)){
            foreach($payments as $payment){

                $membership=Membership::find($payment->membership_id);
                $announcement=Announcement::find($payment->announcement_id);
                $response=Http::acceptJson()->withBody(
                    json_encode(
                        [
                            "apikey"=>"108089145655d2b949d7a99.42080516",
                            "site_id"=>"5866009",
                            "transaction_id"=>$payment->transaction_id
                          ]),'application/json')->post('https://api-checkout.cinetpay.com/v2/payment/check',[

                ]);

                $paymentStatus=json_decode($response);
                if(isset($code)){
                    if($code==="404"){
                        $payment->delete();
                    }
                }else{
                    $data=$paymentStatus->data ?? null;
                    $status=$data->status ?? null;
                }

                if($status==="ACCEPTED" && $payment->status=="0"){
                    $payment->status="2";
                    $payment->save();
                    //$currentDateTime = Carbon::now();
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


                }else if($status==="REFUSED" && $payment->status=="0"){

                    $payment->status="1";
                    $payment->save();
                }
            }
        }
    }

    public function checkCreditSubscribe(){
        $payments=Payment::where('payment_of',"=","credit")
        ->where('user_id','=',Auth()->guard('api')->user()->id)
        ->where('status','=',"0")
        ->get();
        if(isset($payments)){
            foreach($payments as $payment){

                $response=Http::acceptJson()->withBody(
                    json_encode(
                        [
                            "apikey"=>"108089145655d2b949d7a99.42080516",
                            "site_id"=>"5866009",
                            "transaction_id"=>$payment->transaction_id
                          ]),'application/json')->post('https://api-checkout.cinetpay.com/v2/payment/check',[

                ]);

                $paymentStatus=json_decode($response);
                $paymentStatus=json_decode($response);
                if(isset($code)){
                    if($code==="404"){
                        $payment->delete();
                    }
                }else{
                    $data=$paymentStatus->data ?? null;
                    $status=$data->status ?? null;
                }
                        if($status==="ACCEPTED" && $payment->status=="0"){
                            $payment->status="2";
                            $payment->save();
                            $user=User::find($payment->user_id);
                            $user->balance=$user->balance+$payment->price;
                            $user->save();
                }else if($status==="REFUSED" && $payment->status=="0"){
                    $payment->status="1";
                    $payment->save();
                }
            }
        }
    }

    public function checkPlan(){
        $payments=Payment::where('payment_of',"=","premium")
        ->where('user_id','=',Auth()->guard('api')->user()->id)
        ->where('status','=',"0")
        ->get();

        if(isset($payments)){

            foreach($payments as $payment){

                $response=Http::acceptJson()->withBody(
                    json_encode(
                        [
                            "apikey"=>"108089145655d2b949d7a99.42080516",
                            "site_id"=>"5866009",
                            "transaction_id"=>$payment->transaction_id
                          ]),'application/json')->post('https://api-checkout.cinetpay.com/v2/payment/check',[

                ]);
                $user=User::find($payment->user_id);
                $memberShip=Membership::find($payment->membership_id);
                $paymentStatus=json_decode($response);
                $paymentStatus=json_decode($response);
                if(isset($code)){
                    if($code==="404"){
                        $payment->delete();
                    }
                }else{
                    $data=$paymentStatus->data ?? null;
                    $status=$data->status ?? null;
                }

                if($status==="ACCEPTED" && $payment->status=="0"){
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
                }else if($status==="REFUSED" && $payment->status=="0"){
                    $payment->status="1";
                    $payment->save();
                }
            }
        }
    }
}
