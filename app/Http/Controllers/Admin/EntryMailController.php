<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEntryMailRequest;
use App\Http\Requests\StoreEntryMailRequest;
use App\Http\Requests\UpdateEntryMailRequest;
use App\Models\EntryMail;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EntryMailController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('entry_mail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entryMails = EntryMail::with(['media'])->get();

        return view('admin.entryMails.index', compact('entryMails'));
    }

    public function create()
    {
        abort_if(Gate::denies('entry_mail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.entryMails.create');
    }

    public function store(StoreEntryMailRequest $request)
    {
        $entryMail = EntryMail::create($request->all());

        if ($request->input('mail', false)) {
            $entryMail->addMedia(storage_path('tmp/uploads/' . basename($request->input('mail'))))->toMediaCollection('mail');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $entryMail->id]);
        }

        return redirect()->route('admin.entry-mails.index');
    }

    public function edit(EntryMail $entryMail)
    {
        abort_if(Gate::denies('entry_mail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.entryMails.edit', compact('entryMail'));
    }

    public function update(UpdateEntryMailRequest $request, EntryMail $entryMail)
    {
        $entryMail->update($request->all());

        if ($request->input('mail', false)) {
            if (!$entryMail->mail || $request->input('mail') !== $entryMail->mail->file_name) {
                if ($entryMail->mail) {
                    $entryMail->mail->delete();
                }
                $entryMail->addMedia(storage_path('tmp/uploads/' . basename($request->input('mail'))))->toMediaCollection('mail');
            }
        } elseif ($entryMail->mail) {
            $entryMail->mail->delete();
        }

        return redirect()->route('admin.entry-mails.index');
    }

    public function show(EntryMail $entryMail)
    {
        abort_if(Gate::denies('entry_mail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.entryMails.show', compact('entryMail'));
    }

    public function destroy(EntryMail $entryMail)
    {
        abort_if(Gate::denies('entry_mail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entryMail->delete();

        return back();
    }

    public function massDestroy(MassDestroyEntryMailRequest $request)
    {
        EntryMail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('entry_mail_create') && Gate::denies('entry_mail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EntryMail();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
