<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isSuperAdmin($roleId){
        return $roleId == User::ADMIN_ROLE_ID;
    }

    public function isBapakRT($roleId){
        return $roleId == User::BAPAK_RT_ROLE_ID;
    }
}
