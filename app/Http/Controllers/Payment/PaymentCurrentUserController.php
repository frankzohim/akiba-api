<?php

namespace App\Http\Controllers\Payment;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentCurrentUserController extends Controller
{
    public function list(){
        $payment=Payment::orderBy('id','DESC')->where('user_id',Auth::guard('api')->user()->id)->get();

        return $payment;
    }
}
