<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBeritumRequest;
use App\Http\Requests\UpdateBeritumRequest;
use App\Http\Resources\BeritumResource;
use App\Models\Beritum;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\ResponseTrait;

class BeritaApiController extends Controller
{
    use MediaUploadingTrait;
    use ResponseTrait;

    public function index()
    {
        // abort_if(Gate::denies('beritum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new BeritumResource(Beritum::all());
        return $this->successResponse("success fetching data", $resource);
    }

    public function store(StoreBeritumRequest $request)
    {
        $beritum = Beritum::create($request->all());

        if ($request->input('image', false)) {
            $beritum->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        $resource = new BeritumResource($beritum);
        return $this->successResponse("success fetching data", $resource);
    }

    public function show(Beritum $beritum)
    {
        // abort_if(Gate::denies('beritum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new BeritumResource($beritum);
        return $this->successResponse("success fetching data", $resource);
    }

    public function update(UpdateBeritumRequest $request, Beritum $beritum)
    {
        $beritum->update($request->all());

        if ($request->input('image', false)) {
            if (!$beritum->image || $request->input('image') !== $beritum->image->file_name) {
                if ($beritum->image) {
                    $beritum->image->delete();
                }
                $beritum->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($beritum->image) {
            $beritum->image->delete();
        }

        $resource = new BeritumResource($beritum);
        return $this->successResponse("success updating data", $resource);
    }

    public function destroy($beritaId)
    {
        // abort_if(Gate::denies('beritum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $beritum->delete();

        // Random delete
        Beritum::inRandomOrder()->limit(1)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
