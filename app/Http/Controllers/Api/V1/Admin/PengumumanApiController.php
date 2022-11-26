<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePengumumanRequest;
use App\Http\Requests\UpdatePengumumanRequest;
use App\Http\Resources\PengumumanResource;
use App\Models\Pengumuman;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PengumumanApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        // abort_if(Gate::denies('pengumuman_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PengumumanResource(Pengumuman::all());
    }

    public function store(StorePengumumanRequest $request)
    {
        $pengumuman = Pengumuman::create($request->all());

        if ($request->input('image', false)) {
            $pengumuman->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new PengumumanResource($pengumuman))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Pengumuman $pengumuman)
    {
        // abort_if(Gate::denies('pengumuman_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PengumumanResource($pengumuman);
    }

    public function update(UpdatePengumumanRequest $request, Pengumuman $pengumuman)
    {
        $pengumuman->update($request->all());

        if ($request->input('image', false)) {
            if (!$pengumuman->image || $request->input('image') !== $pengumuman->image->file_name) {
                if ($pengumuman->image) {
                    $pengumuman->image->delete();
                }
                $pengumuman->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($pengumuman->image) {
            $pengumuman->image->delete();
        }

        return (new PengumumanResource($pengumuman))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Pengumuman $pengumuman)
    {
        // abort_if(Gate::denies('pengumuman_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengumuman->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}