@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.kependudukan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.kependudukans.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="fullname">{{ trans('cruds.kependudukan.fields.fullname') }}</label>
                <input class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" type="text" name="fullname" id="fullname" value="{{ old('fullname', '') }}" required>
                @if($errors->has('fullname'))
                    <span class="text-danger">{{ $errors->first('fullname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.fullname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="nik">{{ trans('cruds.kependudukan.fields.nik') }}</label>
                <input class="form-control {{ $errors->has('nik') ? 'is-invalid' : '' }}" type="text" name="nik" id="nik" value="{{ old('nik', '') }}" required>
                @if($errors->has('nik'))
                    <span class="text-danger">{{ $errors->first('nik') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.nik_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="birthdate">{{ trans('cruds.kependudukan.fields.birthdate') }}</label>
                <input class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="text" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required>
                @if($errors->has('birthdate'))
                    <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.birthdate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="birthplace">{{ trans('cruds.kependudukan.fields.birthplace') }}</label>
                <input class="form-control {{ $errors->has('birthplace') ? 'is-invalid' : '' }}" type="text" name="birthplace" id="birthplace" value="{{ old('birthplace', '') }}" required>
                @if($errors->has('birthplace'))
                    <span class="text-danger">{{ $errors->first('birthplace') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.birthplace_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.kependudukan.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender" required>
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Kependudukan::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.kependudukan.fields.religion') }}</label>
                <select class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}" name="religion" id="religion" required>
                    <option value disabled {{ old('religion', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Kependudukan::RELIGION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('religion', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('religion'))
                    <span class="text-danger">{{ $errors->first('religion') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.religion_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.kependudukan.fields.marital_status') }}</label>
                <select class="form-control {{ $errors->has('marital_status') ? 'is-invalid' : '' }}" name="marital_status" id="marital_status" required>
                    <option value disabled {{ old('marital_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Kependudukan::MARITAL_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('marital_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('marital_status'))
                    <span class="text-danger">{{ $errors->first('marital_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.marital_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.kependudukan.fields.latest_education') }}</label>
                <select class="form-control {{ $errors->has('latest_education') ? 'is-invalid' : '' }}" name="latest_education" id="latest_education" required>
                    <option value disabled {{ old('latest_education', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Kependudukan::LATEST_EDUCATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('latest_education', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('latest_education'))
                    <span class="text-danger">{{ $errors->first('latest_education') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.latest_education_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="occupation">{{ trans('cruds.kependudukan.fields.occupation') }}</label>
                <input class="form-control {{ $errors->has('occupation') ? 'is-invalid' : '' }}" type="text" name="occupation" id="occupation" value="{{ old('occupation', '') }}" required>
                @if($errors->has('occupation'))
                    <span class="text-danger">{{ $errors->first('occupation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.occupation_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="father_name">{{ trans('cruds.kependudukan.fields.father_name') }}</label>
                <input class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" type="text" name="father_name" id="father_name" value="{{ old('father_name', '') }}" required>
                @if($errors->has('father_name'))
                    <span class="text-danger">{{ $errors->first('father_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.father_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mother_name">{{ trans('cruds.kependudukan.fields.mother_name') }}</label>
                <input class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', '') }}" required>
                @if($errors->has('mother_name'))
                    <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.mother_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="disease">{{ trans('cruds.kependudukan.fields.disease') }}</label>
                <input class="form-control {{ $errors->has('disease') ? 'is-invalid' : '' }}" type="text" name="disease" id="disease" value="{{ old('disease', '') }}" required>
                @if($errors->has('disease'))
                    <span class="text-danger">{{ $errors->first('disease') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kependudukan.fields.disease_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection