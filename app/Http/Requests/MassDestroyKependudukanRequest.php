<?php

namespace App\Http\Requests;

use App\Models\Kependudukan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyKependudukanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('kependudukan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:kependudukans,id',
        ];
    }
}
