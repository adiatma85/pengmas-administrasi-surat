<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPengumumanRequest;
use App\Http\Requests\StorePengumumanRequest;
use App\Http\Requests\UpdatePengumumanRequest;
use App\Models\Pengumuman;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PengumumanController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('pengumuman_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengumumans = Pengumuman::with(['media'])->get();

        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        abort_if(Gate::denies('pengumuman_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pengumuman.create');
    }

    public function store(StorePengumumanRequest $request)
    {
        $pengumuman = Pengumuman::create($request->all());

        if ($request->input('image', false)) {
            $pengumuman->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $pengumuman->id]);
        }

        return redirect()->route('admin.pengumuman.index');
    }

    public function edit(Pengumuman $pengumuman)
    {
        abort_if(Gate::denies('pengumuman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pengumuman.edit', compact('pengumuman'));
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

        return redirect()->route('admin.pengumuman.index');
    }

    public function show(Pengumuman $pengumuman)
    {
        abort_if(Gate::denies('pengumuman_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    public function destroy(Pengumuman $pengumuman)
    {
        abort_if(Gate::denies('pengumuman_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pengumuman->delete();

        return back();
    }

    public function massDestroy(MassDestroyPengumumanRequest $request)
    {
        Pengumuman::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('pengumuman_create') && Gate::denies('pengumuman_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Pengumuman();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
