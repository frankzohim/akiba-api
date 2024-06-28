<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class UpdatePriceController extends Controller
{
    public function updatePrice(Request $request,$id){

        $membership=Membership::find($id);
        $membership->price=$request->price;
        $membership->save();

        return response()->json(['message'=>"price update"]);
    }
}
