@extends('layouts.admin')
@section('content')
@can('pengajuan_surat_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('portal.pengajuan-surat.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.entryMail.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.entryMail.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EntryMail">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.entryMail.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.entryMail.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.entryMail.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.entryMail.fields.status') }}
                        </th>
                        <th>
                            Tautan File
                        </th>
                        <th>
                            Alasan Penolakan
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\EntryMail::TYPE_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\EntryMail::STATUS_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            {{-- <input class="search" type="text" placeholder="{{ trans('global.search') }}"> --}}
                        </td>
                        <td>
                            {{-- <input class="search" type="text" placeholder="{{ trans('global.search') }}"> --}}
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entryMails as $key => $entryMail)
                        <tr data-entry-id="{{ $entryMail->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $entryMail->id ?? '' }}
                            </td>
                            <td>
                                {{ $entryMail->title ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\EntryMail::TYPE_SELECT[$entryMail->type] ?? '' }}
                            </td>
                            <td>
                                <span class="badge {{ $entryMail->status == "PROSES" ? "badge-warning" : ""}} {{ $entryMail->status == "DISETUJUI" ? "badge-success" : ""}} {{ $entryMail->status == "DITOLAK" ? "badge-danger" : ""}}">
                                    {{ App\Models\EntryMail::STATUS_SELECT[$entryMail->status] ?? '' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{$entryMail->file_link ?? "#"}}">
                                    <span class="badge badge-info">
                                        File
                                    </span>
                                </a>
                            </td>
                            <td>
                                {{ $entryMail->reject_reason ?? '-'}}    
                            </td>
                            <td>
                                {{-- @can('entry_mail_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.entry-mails.show', $entryMail->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan --}}

                                @can('entry_mail_edit')
                                    @if ($entryMail->status == "PROSES")
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.entry-mails.edit', $entryMail->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endif
                                @endcan

                                @can('accept_mail_entry')
                                    @if ($entryMail->status == "PROSES")
                                        <form action="{{ route('admin.entry-mails.mailAccept', $entryMail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-success" value="Setuju">
                                        </form>
                                    @endif
                                @endcan

                                @can('reject_mail_entry')
                                    @if ($entryMail->status == "PROSES")
                                        {{-- <form action="{{ route('admin.entry-mails.mailReject', $entryMail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="Tolak">
                                        </form> --}}
                                        <div type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#exampleModal-{{$entryMail->id}}">Tolak</div>
                                        {{-- Modal --}}
                                        <div class="modal fade" id="exampleModal-{{$entryMail->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Penolakan Surat</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <form action="{{ route('admin.entry-mails.mailReject', $entryMail->id) }}" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Alasan Penolakan Surat:</label>
                                                        <textarea class="form-control" id="message-text" name="reject_reason"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                      <button type="submit" class="btn btn-primary">Kirim</button>
                                                    </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                    @endif
                                @endcan

                                {{-- @can('entry_mail_delete')
                                    <form action="{{ route('admin.entry-mails.destroy', $entryMail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('entry_mail_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.entry-mails.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-EntryMail:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection