<?php

namespace App\Http\Requests;

use App\Models\Beritum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBeritumRequest extends FormRequest
{
    // public function authorize()
    // {
    //     // return Gate::allows('beritum_create');
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