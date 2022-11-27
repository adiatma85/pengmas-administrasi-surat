<?php

namespace App\Http\Requests;

use App\Models\Pengumuman;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePengumumanRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return Gate::allows('pengumuman_create');
    // }

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
