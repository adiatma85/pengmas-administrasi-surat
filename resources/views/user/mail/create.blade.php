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

            {{-- Fokus pada surat keterangan belum menikah --}}
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

                        break;
                    
                    case `PERSETUJUAN_TETANGGA`:
                        break;

                    default:
                        break;
                }

                $append = "<div id='appendFields'>";
                arrayAppendElement.forEach(element => {

                    if (element.fieldTyoe == "text") {
                        $append += appendFieldText(element);
                    }

                    if (element.fieldTyoe == "date") {
                        $append += appendFieldDate(element);
                    }

                    if (element.fieldTyoe == "select") {
                        $append += appendFieldOption(element);
                    }

                    if (element.fieldTyoe == "file") {
                        $append += appendFieldFile(element);
                    }
                });
                $append += "</div>"
                $("#appendDiv").append($append)
            });

            function appendFieldText({label, valueName, htmlId}){
                let returnValue = "<div class='form-group'>" + 
                        `<label for="field${htmlId}">${label}</label>` +
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

            // Surat Keterangan belum menikah
            function appendForSuratBelumMenikah(){
                let arrayAppendElement = [
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
                        label: "Nama Lengkap",
                        valueName: "fullname",
                        htmlId: "fullname",
                        fieldTyoe: "text",
                    },
                    {
                        label: "NIK",
                        valueName: "nik",
                        htmlId: "nik",
                        fieldTyoe: "text",
                    },
                    {
                        label: "Tempat Lahir",
                        valueName: "birthplace",
                        htmlId: "birthplace",
                        fieldTyoe: "text",
                    },
                    {
                        label: "Tanggal Lahir",
                        valueName: "birthdate",
                        htmlId: "birthdate",
                        fieldTyoe: "date",
                    },
                    {
                        label: "Jenis Kelamin",
                        valueName: "gender",
                        htmlId: "gender",
                        fieldTyoe: "select",
                        optionValue: [
                            "LAKI_LAKI",
                            'PEREMPUAN',
                        ],
                        optionLabel: [
                            "Laki Laki",
                            "Perempuan",
                        ],
                    },
                    {
                        label: "Agama",
                        valueName: "religion",
                        htmlId: "religion",
                        fieldTyoe: "select",
                        optionValue: [
                            "ISLAM",
                            'KRISTEN_PROTESTAN',
                            'KRISTEN_KATHOLIK',
                            'HINDHU',
                            'BUDHA',
                            'KONGHUCU',
                            'KEPERCAYAAN_LAIN',
                        ],
                        optionLabel: [
                            "Islam",
                            "Kristen Protestan",
                            'Kristen Katholik',
                            'Hindhu',
                            'Budha',
                            'Konghucu',
                            'Kepercayaan Lain',
                        ],
                    },
                    {
                        label: "Profesi",
                        valueName: "occupation",
                        htmlId: "occupation",
                        fieldTyoe: "text",
                    },
                    {
                        label: "Status Domisili",
                        valueName: "status_domisili",
                        htmlId: "status_domisili",
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
                        label: "Nama Pemilik Rumah",
                        valueName: "owner_house_name",
                        htmlId: "owner_house_name",
                        fieldTyoe: "text",
                    },
                    {
                        label: "Foto/Scan Tanda Tangan Pemilik Rumah",
                        valueName: "signature",
                        htmlId: "signature",
                        fieldTyoe: "file",
                    },
                ];

                return arrayAppendElement;
            }
        });
    </script>
@endsection