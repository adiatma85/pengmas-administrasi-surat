<?php

namespace App\Http\Requests;

use App\Models\Rule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRuleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rule_create');
    }

    public function rules()
    {
        return [
            'content' => [
                'string',
                'required',
            ],
        ];
    }
}
