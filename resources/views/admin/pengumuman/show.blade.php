@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pengumuman.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pengumuman.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pengumuman.fields.id') }}
                        </th>
                        <td>
                            {{ $pengumuman->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pengumuman.fields.title') }}
                        </th>
                        <td>
                            {{ $pengumuman->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pengumuman.fields.content') }}
                        </th>
                        <td>
                            {!! $pengumuman->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pengumuman.fields.image') }}
                        </th>
                        <td>
                            @if($pengumuman->image)
                                <a href="{{ $pengumuman->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $pengumuman->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pengumuman.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection