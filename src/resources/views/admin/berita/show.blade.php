@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{-- {{ trans('global.show') }} {{ trans('cruds.beritum.title') }} --}}
        Detail Berita
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.berita.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.beritum.fields.id') }}
                        </th>
                        <td>
                            {{ $beritum->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.beritum.fields.title') }}
                        </th>
                        <td>
                            {{ $beritum->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.beritum.fields.image') }}
                        </th>
                        <td>
                            @if($beritum->image)
                                <a href="{{ $beritum->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $beritum->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.beritum.fields.content') }}
                        </th>
                        <td>
                            {!! $beritum->content !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.berita.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection