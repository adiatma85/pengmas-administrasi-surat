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

        foreach ($pengumuans as $pengumuman) {
            $item = [
                'id' => $pengumuman->id,
                'title' => $pengumuman->title,
                'content' => $pengumuman->content,
                'image_url' => $pengumuman->image ? $pengumuman->image->url : '',
                'created_at' => $pengumuman->created_at,
                'updated_at' => $pengumuman->updated_at,
                'deleted_at' => $pengumuman->deleted_at,
            ];

            array_push($returnValue, $item);
        }

        return $this->successResponse("success fetching data", $returnValue);
    }

    public function show(Pengumuman $pengumuman){
        $returnValue = [
            'id' => $pengumuman->id,
            'title' => $pengumuman->title,
            'content' => $pengumuman->content,
            'image_url' => $pengumuman->image ? $pengumuman->image->url : '',
            'created_at' => $pengumuman->created_at,
            'updated_at' => $pengumuman->updated_at,
            'deleted_at' => $pengumuman->deleted_at,
        ];

        return $this->successResponse("success fetching data", $returnValue);
    }
}
