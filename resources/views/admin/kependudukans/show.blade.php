@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.kependudukan.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kependudukans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.id') }}
                        </th>
                        <td>
                            {{ $kependudukan->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.fullname') }}
                        </th>
                        <td>
                            {{ $kependudukan->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.nik') }}
                        </th>
                        <td>
                            {{ $kependudukan->nik }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.birthdate') }}
                        </th>
                        <td>
                            {{ $kependudukan->birthdate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.birthplace') }}
                        </th>
                        <td>
                            {{ $kependudukan->birthplace }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\Kependudukan::GENDER_SELECT[$kependudukan->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.religion') }}
                        </th>
                        <td>
                            {{ App\Models\Kependudukan::RELIGION_SELECT[$kependudukan->religion] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.marital_status') }}
                        </th>
                        <td>
                            {{ App\Models\Kependudukan::MARITAL_STATUS_SELECT[$kependudukan->marital_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.latest_education') }}
                        </th>
                        <td>
                            {{ App\Models\Kependudukan::LATEST_EDUCATION_SELECT[$kependudukan->latest_education] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.occupation') }}
                        </th>
                        <td>
                            {{ $kependudukan->occupation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.father_name') }}
                        </th>
                        <td>
                            {{ $kependudukan->father_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.mother_name') }}
                        </th>
                        <td>
                            {{ $kependudukan->mother_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kependudukan.fields.disease') }}
                        </th>
                        <td>
                            {{ $kependudukan->disease }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kependudukans.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection