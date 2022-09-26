<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthApiController extends Controller
{

    use ResponseTrait;

    public function login(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return $this->badRequestFailResponse($validateUser);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return $this->badRequestFailResponse(null);
            }

            $user = User::where('email', $request->email)->first();

            $data = [
                'token' => $user->createToken("API TOKEN")->plainTextToken,
            ];
            return $this->successResponse('user logged successfully', $data);
            
        } catch (\Throwable $th) {
            return $this->internalServerFailResponse();
        }
    }
}
