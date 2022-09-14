<?php

namespace App\Http\Requests;

use App\Models\Kependudukan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreKependudukanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kependudukan_create');
    }

    public function rules()
    {
        return [
            'fullname' => [
                'string',
                'required',
            ],
            'nik' => [
                'string',
                'required',
            ],
            'birthdate' => [
                'required',
                // 'date_format:' . config('panel.input_date_format'),
            ],
            'birthplace' => [
                'string',
                'required',
            ],
            'gender' => [
                'required',
            ],
            'religion' => [
                'required',
            ],
            'marital_status' => [
                'required',
            ],
            'latest_education' => [
                'required',
            ],
            'occupation' => [
                'string',
                'required',
            ],
            'father_name' => [
                'string',
                'required',
            ],
            'mother_name' => [
                'string',
                'required',
            ],
            'disease' => [
                'string',
                'required',
            ],
        ];
    }
}
