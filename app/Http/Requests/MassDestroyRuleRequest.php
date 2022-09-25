<?php

namespace App\Http\Requests;

use App\Models\Rule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRuleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('rule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:rules,id',
        ];
    }
}