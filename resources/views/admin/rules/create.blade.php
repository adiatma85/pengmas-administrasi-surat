@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.rules.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="content">{{ trans('cruds.rule.fields.content') }}</label>
                <input class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" type="text" name="content" id="content" value="{{ old('content', '') }}" required>
                @if($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rule.fields.content_helper') }}</span>
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