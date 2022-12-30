<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Beritum;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Requests\StoreBeritumRequest;
use App\Http\Requests\UpdateBeritumRequest;
use App\Http\Resources\BeritumResource;

class BeritaApiController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        $beritas = Beritum::all();
        $returnValue = [];

        foreach ($beritas as $berita) {
            $item = [
                'id' => $berita->id,
                'title' => $berita->title,
                'content' => $berita->content,
                'image_url' => $berita->image ? $berita->image->url : '',
                'created_at' => $berita->created_at,
                'updated_at' => $berita->updated_at,
                'deleted_at' => $berita->deleted_at,
            ];

            array_push($returnValue, $item);
        }

        return $this->successResponse("success fetching data", $returnValue);
    }

    public function show($beritaId){

        $berita = Beritum::where('id', $beritaId);

        if (!$berita->exists()) {
            return $this->notFoundFailResponse();
        }

        $berita = $berita->first();

        $returnValue = [
            'id' => $berita->id,
            'title' => $berita->title,
            'content' => $berita->content,
            'image_url' => $berita->image ? $berita->image->url : '',
            'created_at' => $berita->created_at,
            'updated_at' => $berita->updated_at,
            'deleted_at' => $berita->deleted_at,
        ];

        return $this->successResponse("success fetching data", $returnValue);
    }
    
}
