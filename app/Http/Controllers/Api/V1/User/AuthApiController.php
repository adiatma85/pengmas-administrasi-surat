<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Kependudukan;

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

    public function selfInformation(Request $request){
        $user = User::find($this->extractUserIdFromToken());
        $dataKependudukan = $user->kependudukan;

        if(!$dataKependudukan){
            // Change this to return route or return view instead
            return $this->notFoundFailResponse();
        }

        $value = [
            'name' => $dataKependudukan->name ?? "",
            'nik' => $dataKependudukan->nik ?? "",
            'address' => $dataKependudukan->address ?? "",
            'phone_number' => $dataKependudukan->phone_number ?? "",
            'religion' => Kependudukan::RELIGION_SELECT[$dataKependudukan->religion] ?? "",
            'gender' => Kependudukan::GENDER_SELECT[$dataKependudukan->gender] ?? "",
            'birthplace' => $dataKependudukan->birthplace ?? "",
            'latest_education' => $dataKependudukan->latest_education ?? "",
            'marital_status' => $dataKependudukan->marital_status ?? "",
            'occupation' => $dataKependudukan->occupation ?? "",
            'citizenship' => 'WNI',
            'disease' => $dataKependudukan->disease ?? "",
            // Ayah
            'father_name' => $dataKependudukan->father_name ?? "",
            'father_religion' => $dataKependudukan->father_religion ?? "",
            'father_occupation' => $dataKependudukan->father_occupation ?? "",
            // Ibu
            'mother_name' => $dataKependudukan->mother_name ?? "",
            'mother_religion' => $dataKependudukan->mother_religion ?? "",
            'mother_occupation' => $dataKependudukan->mother_occupation ?? "",
        ];
        return $this->successResponse('success fetching user data', $value);
    }

    private function extractUserIdFromToken(){
        return auth('sanctum')->user()->id;
    }
}
