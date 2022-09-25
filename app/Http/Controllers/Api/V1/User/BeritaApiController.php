<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Beritum;
use App\Http\Controllers\Traits\ResponseTrait;

class BeritaApiController extends Controller
{

    use ResponseTrait;

     /**
     * @OA\Get(
     *      path="/berita",
     *      operationId="getProjectsList",
     *      tags={"Berita"},
     *      summary="Get list of Berita",
     *      description="Returns list of Berita",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Berita")
     *       ),
     *     )
     */

    public function index()
    {
        $beritas = Beritum::all();
        $returnValue = [];

        foreach ($beritas as $berita) {
            $item = [
                'title' => $berita->title,
                'content' => $berita->content,
                'image_url' => $berita->image ? $berita->image->url : '',
            ];

            array_push($returnValue, $item);
        }

        return $this->successResponse("success fetching data", $returnValue);
    }

}
