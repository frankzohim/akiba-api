<?php
/***
 * Author Frank Zohim
 * This file is intented to receive the request login from the 
 * client valid data and generate an access token
 */
namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Repositories\GetClientRepository;
use App\Services\Auth\LoginService;
use App\Services\GenerateTokenUserService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){

        try{
            //$data=$request->validate();
            $valid = validator($request->only('phone_number','password'), [
                'phone_number' => 'required|string|exists:users',
                'password' => 'required|string',
            ]);

            if ($valid->fails()) {
                return response()->json(['error'=>$valid->errors()], 400);

            }
            $data = request()->only('phone_number','password');
           $loginUser=(new LoginService())->login($data);
           if(isset($loginUser->suspended_at)){
            return response()->json(["code"=>203,'message'=>"votre compte à été suspendu veuillez contactez l'administrateur"],403);
        }else{
            $client=(new GetClientRepository())->getClient();
           $tokenUser=(new GenerateTokenUserService())->generate($client,$loginUser,$data['password'],$request);
           return $tokenUser;
        }

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'errors' => $e
              ], 500);
        }
    }
}
