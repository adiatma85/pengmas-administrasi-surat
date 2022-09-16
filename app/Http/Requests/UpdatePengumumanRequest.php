<?php

namespace App\Http\Requests;

use App\Models\Pengumuman;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePengumumanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pengumuman_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
        ];
    }
}