<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Pengmas API Documentation",
     *      description="API Documentation for Pengmas Surat Menyurat",
     *      @OA\Contact(
     *          email="adiatma85@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )

     *
     * @OA\Tag(
     *     name="Pengmas",
     *     description="Pengmas API Docs"
     * )
     */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isSuperAdmin($roleId){
        return $roleId == User::ADMIN_ROLE_ID;
    }

    public function isBapakRT($roleId){
        return $roleId == User::BAPAK_RT_ROLE_ID;
    }
}
