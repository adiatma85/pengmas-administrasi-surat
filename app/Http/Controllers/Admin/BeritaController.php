<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBeritumRequest;
use App\Http\Requests\StoreBeritumRequest;
use App\Http\Requests\UpdateBeritumRequest;
use App\Models\Beritum;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BeritaController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('beritum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $berita = Beritum::with(['media'])->get();

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        abort_if(Gate::denies('beritum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.berita.create');
    }

    public function store(StoreBeritumRequest $request)
    {
        $beritum = Beritum::create($request->all());

        if ($request->input('image', false)) {
            $beritum->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $beritum->id]);
        }

        return redirect()->route('admin.berita.index');
    }

    public function edit(Beritum $beritum)
    {
        abort_if(Gate::denies('beritum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.berita.edit', compact('beritum'));
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

        return redirect()->route('admin.berita.index');
    }

    public function show(Beritum $beritum)
    {
        abort_if(Gate::denies('beritum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.berita.show', compact('beritum'));
    }

    public function destroy(Beritum $beritum)
    {
        abort_if(Gate::denies('beritum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $beritum->delete();

        return back();
    }

    public function massDestroy(MassDestroyBeritumRequest $request)
    {
        Beritum::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('beritum_create') && Gate::denies('beritum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Beritum();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}