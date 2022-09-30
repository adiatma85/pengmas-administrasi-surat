@extends('layouts.admin')
@section('content')
@can('kependudukan_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.kependudukans.create') }}">
                {{-- {{ trans('global.add') }} {{ trans('cruds.kependudukan.title_singular') }} --}}
                Tambah Data Kependudukan
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{-- {{ trans('cruds.kependudukan.title_singular') }} {{ trans('global.list') }} --}}
        Daftar Data Kependudukan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Kependudukan">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.fullname') }}
                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.nik') }}
                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.religion') }}
                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.marital_status') }}
                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.occupation') }}
                        </th>
                        <th>
                            {{ trans('cruds.kependudukan.fields.disease') }}
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
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Kependudukan::GENDER_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Kependudukan::RELIGION_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Kependudukan::MARITAL_STATUS_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kependudukans as $key => $kependudukan)
                        <tr data-entry-id="{{ $kependudukan->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $kependudukan->id ?? '' }}
                            </td>
                            <td>
                                {{ $kependudukan->fullname ?? '' }}
                            </td>
                            <td>
                                {{ $kependudukan->nik ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Kependudukan::GENDER_SELECT[$kependudukan->gender] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Kependudukan::RELIGION_SELECT[$kependudukan->religion] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Kependudukan::MARITAL_STATUS_SELECT[$kependudukan->marital_status] ?? '' }}
                            </td>
                            <td>
                                {{ $kependudukan->occupation ?? '' }}
                            </td>
                            <td>
                                {{ $kependudukan->disease ?? '' }}
                            </td>
                            <td>
                                @can('kependudukan_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.kependudukans.show', $kependudukan->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('kependudukan_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.kependudukans.edit', $kependudukan->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('kependudukan_delete')
                                    <form action="{{ route('admin.kependudukans.destroy', $kependudukan->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

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
@can('kependudukan_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.kependudukans.massDestroy') }}",
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
    order: [[ 2, 'asc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-Kependudukan:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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