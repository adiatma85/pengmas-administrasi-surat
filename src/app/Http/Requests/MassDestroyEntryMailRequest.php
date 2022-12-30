<?php

namespace App\Http\Requests;

use App\Models\EntryMail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEntryMailRequest extends FormRequest
{
    public function authorize()
    {
        // abort_if(Gate::denies('entry_mail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:entry_mails,id',
        ];
    }
}