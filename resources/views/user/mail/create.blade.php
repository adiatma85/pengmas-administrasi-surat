@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.entryMail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("portal.pengajuan-surat.store") }}" enctype="multipart/form-data">
            @csrf
            {{-- Di sini kita masukin beberapa field yang memang dibutuhkan --}}
            {{-- Tipe surat itu sudah pasti dibutuhkan --> 'mail_type'  --}}
            {{-- Keterangan Surat juga Aku rasa dibutuhkan --> 'keterangan_surat' --}}
            <div class="form-group">
                <label class="required">{{ trans('cruds.entryMail.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="mail_type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\EntryMail::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.entryMail.fields.type_helper') }}</span>
            </div>

            {{-- Append Div --}}
            <div id="appendDiv">

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

@section('scripts')
    {{-- Script for JS goes here --}}
    <script>
        $(document).ready(function() {
            // Listener for id 'type'
            $("#type").change(function(event) {
                let value = this.value
                let element = document.getElementById(`appendFields`);
                // PENGANTAR_SURAT_NIKAH
                // KETERANGAN_DOMISILI
                // KETERANGAN_BELUM_MENIKAH
                // PERSETUJUAN_TETANGGA

                // Refresh
                if (element) {
                    element.remove();
                }

                let arrayAppendElement = [
                    {
                        label: "Keterangan Surat",
                        valueName: "keterangan_surat",
                        htmlId: "keterangan_surat"
                    },
                ];

                $append = "<div id='appendFields'>";
                arrayAppendElement.forEach(element => {
                    $append += appendOptionEvent(element);
                });
                $append += "</div>"
                $("#appendDiv").append($append)
            });

            function appendOptionEvent({label, valueName, htmlId}){
                let returnValue = "<div class='form-group'>" + 
                        `<label for="field${htmlId}">${label}</label>` +
                        `<input class="form-control" type="text" name="${valueName}" id="field${htmlId}">` +
                        `</div>`
                    ;

                return returnValue;
            }
        });
    </script>
@endsection