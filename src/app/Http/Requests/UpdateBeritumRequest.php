<?php

namespace App\Http\Requests;

use App\Models\Beritum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBeritumRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return Gate::allows('beritum_edit');
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