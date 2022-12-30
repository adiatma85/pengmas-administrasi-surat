@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.entryMail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("portal.pengajuan-surat.store") }}" enctype="multipart/form-data">
            @csrf
            @if ($users)    
                <div class="form-group">
                    <label class="required">Pengguna</label>
                    <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="user" id="user_type" required>
                        <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('type', '') === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.entryMail.fields.type_helper') }}</span>
                </div>
            @endif
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
                        htmlId: "keterangan_surat",
                        fieldTyoe: "text",
                    },
                ];

                switch (value) {
                    case 'KETERANGAN_BELUM_MENIKAH':
                        arrayAppendElement = arrayAppendElement.concat(appendForSuratBelumMenikah());
                        break;
                    
                    case 'KETERANGAN_DOMISILI':
                        arrayAppendElement = arrayAppendElement.concat(appendSuratKeteranganDomisili());
                        break;
                    
                    case 'PENGANTAR_SURAT_NIKAH':
                        arrayAppendElement = arrayAppendElement.concat(appendSuratPengantarNikah());
                        break;
                    
                    case `PERSETUJUAN_TETANGGA`:
                        arrayAppendElement = arrayAppendElement.concat(appendSuratPersetujuanWarga());
                        break;

                    default:
                        break;
                }

                $append = "<div id='appendFields'>";
                arrayAppendElement.forEach(element => {

                    switch (element.fieldTyoe) {
                        case "text":
                            $append += appendFieldText(element);
                            break;
                        case "date":
                            $append += appendFieldDate(element);
                            break;
                        case "select":
                            $append += appendFieldOption(element);
                            break;
                        case "file":
                            $append += appendFieldFile(element);
                            break;
                        case "etc_text":
                            $append += appendEtcText(element);
                            break;
                        default:
                            break;
                    }
                });
                $append += "</div>"
                $("#appendDiv").append($append)
            });

            function appendFieldText({label, valueName, htmlId}){
                let returnValue = "<div class='form-group'>" + 
                        `<label class="required" for="field${htmlId}">${label}</label>` +
                        `<input class="form-control" type="text" name="${valueName}" id="field${htmlId}">` +
                        `</div>`
                    ;

                return returnValue;
            }

            function appendFieldDate({label, valueName, htmlId}){
                let returnValue = "<div class='form-group'>" + 
                        `<label class="required" for="field${htmlId}">${label}</label>` +
                        `<input class="form-control" type="date" name="${valueName}" id="field${htmlId}" required>` +
                        `</div>`
                    ;
                return returnValue   
            }

            function  appendFieldOption({label, valueName, htmlId, optionValue, optionLabel}){
                let returnValue = "<div class='form-group'>" + 
                    `<label class="required" for="field${htmlId}">${label}</label>` +
                    `<select class="form-control" name="${valueName}" id="field${htmlId}" required>` +
                    `<option value disabled selected>Please select</option>`
                ;

                for (let index = 0; index < optionValue.length; index++) {
                    returnValue += `<option value="${optionValue[index]}">${optionLabel[index]}</option>`;                    
                }
  
                returnValue += `</select> </div>`;
  
                return returnValue;
            }

            function appendFieldFile({label, valueName, htmlId}){
                let returnValue = "<div class='form-group'>" + 
                        `<label for="field${htmlId}">${label}</label>` +
                        `<input class="form-control" type="file" name="${valueName}" id="field${htmlId}">` +
                        `</div>`
                    ;

                return returnValue;
            }

            function appendEtcText({label, valueName, htmlId, src}){
                let returnValue = "<div class='form-group'>" + 
                    `<label for="field${htmlId}">${label}</label> <br/>` +
                    `<a href="${src}">` +
                        `<button class="btn btn-primary" type="button"> File </button>` +
                    `</a>` + 
                    `</div>`
                return returnValue;
            }

            // Surat Keterangan belum menikah
            function appendForSuratBelumMenikah(){
                let arrayAppendElement = [
                    {
                        label: "Alamat Asal",
                        valueName: "original_address",
                        htmlId: "original_address",
                        fieldTyoe: "text",
                    },
                    {
                        label: "Alamat Domisili",
                        valueName: "domicile_address",
                        htmlId: "domicile_address",
                        fieldTyoe: "text",
                    },
                    {
                        label: "Alamat Orang Tua",
                        valueName: "alamat_orang_tua",
                        htmlId: "alamat_orang_tua",
                        fieldTyoe: "text",
                    }
                ];
                return arrayAppendElement;
            }

            // Surat keterangan domisili
            function appendSuratKeteranganDomisili(){
                let arrayAppendElement = 
                [
                    {
                        label: "Tautan File Surat Keterangan Domisili",
                        valueName: "src_docs",
                        htmlId: "src_docs",
                        fieldTyoe: "etc_text",
                        src: "https://google.com",
                    },
                    {
                        label: "Status Domisili",
                        valueName: "domicile_status",
                        htmlId: "domicile_status",
                        fieldTyoe: "select",
                        optionValue: [
                            'KOST',
                            'KONTRAK',
                            'RUMAH_SAUDARA',
                        ],
                        optionLabel: [
                            "Kost",
                            "Kontrak",
                            'Rumah Saudara',
                        ],
                    },
                    {
                        label: "Alamat Domisili",
                        valueName: "domicile_address",
                        htmlId: "domicile_address",
                        fieldTyoe: "text",
                    },
                    {
                        label: "Nama Pemilik Rumah",
                        valueName: "owner_house_name",
                        htmlId: "owner_house_name",
                        fieldTyoe: "text",
                    },
                    // {
                    //     label: "Scan Surat Keterangan Domisili",
                    //     valueName: "document",
                    //     htmlId: "document",
                    //     fieldTyoe: "file",
                    // },
                ];

                return arrayAppendElement;
            }

            // Surat pengantar nikah
            function appendSuratPengantarNikah() {
                let arrayAppendElement = [
                    // Ayah
                    {
                        label: "Alamat Domisili Ayah",
                        valueName: "father_address",
                        htmlId: "father_address",
                        fieldTyoe: "text",
                    },

                    // Ibu
                    {
                        label: "Alamat Domisili Ibu",
                        valueName: "mother_address",
                        htmlId: "mother_address",
                        fieldTyoe: "text",
                    },
                ];
                return arrayAppendElement;
            }

            // Surat persetujuan warga
            function appendSuratPersetujuanWarga(){
                let arrayAppendElement = 
                [
                    {
                        label: "Tautan File Surat Persetujuan Warga",
                        valueName: "src_docs",
                        htmlId: "src_docs",
                        fieldTyoe: "etc_text",
                        src: "https://google.com",
                    },
                    {
                        label: "Scan Surat Persetujuan Warga",
                        valueName: "document",
                        htmlId: "document",
                        fieldTyoe: "file",
                    },
                ];

                return arrayAppendElement;   
            }
        });
    </script>
@endsection