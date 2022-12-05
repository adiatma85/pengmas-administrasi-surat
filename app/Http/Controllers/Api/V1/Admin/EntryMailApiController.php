<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEntryMailRequest;
use App\Http\Requests\UpdateEntryMailRequest;
use App\Http\Resources\EntryMailResource;
use App\Models\EntryMail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\ResponseTrait;

class EntryMailApiController extends Controller
{
    use MediaUploadingTrait;
    use ResponseTrait;

    public function index()
    {
        // abort_if(Gate::denies('entry_mail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new EntryMailResource(EntryMail::all());
        return $this->successResponse("success fetching data", $resource);
    }

    public function store(StoreEntryMailRequest $request)
    {
        $entryMail = EntryMail::create($request->all());

        if ($request->input('mail', false)) {
            $entryMail->addMedia(storage_path('tmp/uploads/' . basename($request->input('mail'))))->toMediaCollection('mail');
        }

        $resource = new EntryMailResource($entryMail);
        return $this->successResponse("success fetching data", $resource);
    }

    public function show(EntryMail $entryMail)
    {
        // abort_if(Gate::denies('entry_mail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new EntryMailResource($entryMail);
        return $this->successResponse("success fetching data", $resource);
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

        $resource = new EntryMailResource($entryMail);
        return $this->successResponse("success updating data", $resource);
    }

    public function destroy($entryMailIdl)
    {
        // abort_if(Gate::denies('entry_mail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $entryMail->delete();
        // Random delete
        EntryMail::inRandomOrder()->limit(1)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    // Add the rest of the function in here
}