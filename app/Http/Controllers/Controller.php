<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const ADMIN_ROLE_ID = 1;
    const BAPAK_RT_ID = 3;

    public function isSuperAdmin($roleId){
        return $roleId == $this->ADMIN_ROLE_ID;
    }

    public function isBapakRT($roleId){
        return $roleId == $this->BAPAK_RT_ID;
    }
}
