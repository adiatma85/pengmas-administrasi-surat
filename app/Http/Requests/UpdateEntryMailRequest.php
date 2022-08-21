<?php

namespace App\Http\Requests;

use App\Models\EntryMail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEntryMailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('entry_mail_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}