<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\IpUtils;

class CreateUserController extends Controller
{

    public function createUser(UserRequest $request){


        // $recaptcha_response = $request->input('recaptcha');


        // if (is_null($recaptcha_response)) {

        //      return response("{error:Please Complete the Recaptcha to proceed}", 400)
        //           ->header('Content-Type', 'application/json');
        // }

        // $url = "https://www.google.com/recaptcha/api/siteverify";

        // $body = [
        //     'secret' => config('services.recaptcha.secret'),
        //     'response' => $recaptcha_response,
        //     'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        // ];

        // $response = Http::asForm()->post($url, $body);

        // $result = json_decode($response);

        // if (!$response->successful() && $result->success == false) {

        //    return response("{error:Please Complete the Recaptcha Again to proceed}", 400)
        //           ->header('Content-Type', 'application/json');

        // }

        $validatedData=$request->validated();

        //Validation passed, processing with storage

        $user = new User;
        $user->username = $request->username;
        $user->role_id = $request->role_id;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);

        if($user->save()){

             return response($user, 200)
                  ->header('Content-Type', 'application/json');
        }
        else{
            return response("{error:error}", 500)
                  ->header('Content-Type', 'application/json');
        }
    }
}
