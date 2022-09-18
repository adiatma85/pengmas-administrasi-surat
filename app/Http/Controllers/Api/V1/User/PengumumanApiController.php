<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Http\Controllers\Traits\ResponseTrait;

class PengumumanApiController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        $pengumuans = Pengumuman::all();
        $returnValue = [];

        foreach ($pengumuans as $berita) {
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
