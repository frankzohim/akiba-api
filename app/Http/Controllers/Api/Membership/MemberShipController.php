<?php

namespace App\Http\Controllers\Api\Membership;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberShipResource;
use App\Http\Requests\MemberShipRequest;
use App\Models\Membership;
use Illuminate\Http\Request;

class MemberShipController extends Controller
{
    public function index()
    {
        return MemberShipResource::collection(Membership::where('id',"!=",4)->get());
    }

    public function showPremium(){
        return MemberShipResource::collection(Membership::where('id',"=",4)->get());
    }
    public function show($id){
        $membership = Membership::where('id',$id)->first();
        return $membership;
    }

    public function store(MemberShipRequest $request){

        $validatedData=$request->validated();
        $membership = MemberShip::create([
            'membership_name' => $request->membership_name,
            'period' => $request->period,
            'price' => $request->price,

        ]);

        return new MemberShipResource($membership);
    }

    public function update(Request $request, Membership $membership){

        $membership->update([
            'membership_name' => $request->membership_name,
            'period' => $request->period,
            'price' => $request->price
        ]);

         return new MemberShipResource($membership);
    }

    public function destroy(Membership $membership){
        $membership->delete();
        return response(null, 204);
    }

}
