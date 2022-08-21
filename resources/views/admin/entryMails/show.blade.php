@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.entryMail.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.entry-mails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.entryMail.fields.id') }}
                        </th>
                        <td>
                            {{ $entryMail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.entryMail.fields.title') }}
                        </th>
                        <td>
                            {{ $entryMail->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.entryMail.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\EntryMail::TYPE_SELECT[$entryMail->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.entryMail.fields.mail') }}
                        </th>
                        <td>
                            @if($entryMail->mail)
                                <a href="{{ $entryMail->mail->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.entryMail.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\EntryMail::STATUS_SELECT[$entryMail->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.entry-mails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection