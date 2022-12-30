<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use App\Http\Controllers\Traits\ResponseTrait;

class RuleApiController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        $rules = Rule::all();

        return $this->successResponse("success fetching data", $rules);
    }

}
