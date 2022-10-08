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
                <label class="required">Status Kependudukan</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="status_kependudukan" id="status_kependudukan" required>
                    <option value disabled {{ old('status_kependudukan', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Kependudukan::STATUS_KEPENDUDUKAN_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status_kependudukan', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status_kependudukan'))
                    <span class="text-danger">{{ $errors->first('status_kependudukan') }}</span>
                @endif
            </div>

            <div class="accordion" id="accordionExample">
                {{-- Informasi Kartu Keluarga --}}
                <div class="card">
                    <div class="card-header" id="card-heading-1">
                      <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#card-collapse-1" aria-expanded="true" aria-controls="card-collapse-1">
                          Informasi Kartu Keluarga
                        </button>
                      </h5>
                    </div>
                
                    <div id="card-collapse-1" class="collapse show" aria-labelledby="card-heading-1" data-parent="#accordionExample">
                      <div class="card-body">
                        <div class="form-group">
                            <label class="required" for="no_kk">{{ trans('cruds.kependudukan.fields.no_kk') }}</label>
                            <input class="form-control {{ $errors->has('no_kk') ? 'is-invalid' : '' }}" type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', '') }}" required>
                            @if($errors->has('no_kk'))
                                <span class="text-danger">{{ $errors->first('no_kk') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.kependudukan.fields.address') }}</label>
                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}" required>
                            @if($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="rt_rw">{{ trans('cruds.kependudukan.fields.rt_rw') }}</label>
                            <input class="form-control {{ $errors->has('rt_rw') ? 'is-invalid' : '' }}" type="text" name="rt_rw" id="rt_rw" value="{{ old('rt_rw', '') }}" required>
                            @if($errors->has('rt_rw'))
                                <span class="text-danger">{{ $errors->first('rt_rw') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="postal_code">{{ trans('cruds.kependudukan.fields.postal_code') }}</label>
                            <input class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', '') }}" required>
                            @if($errors->has('postal_code'))
                                <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="kelurahan">{{ trans('cruds.kependudukan.fields.kelurahan') }}</label>
                            <input class="form-control {{ $errors->has('kelurahan') ? 'is-invalid' : '' }}" type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', '') }}" required>
                            @if($errors->has('kelurahan'))
                                <span class="text-danger">{{ $errors->first('kelurahan') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="kecamatan">{{ trans('cruds.kependudukan.fields.kecamatan') }}</label>
                            <input class="form-control {{ $errors->has('kecamatan') ? 'is-invalid' : '' }}" type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', '') }}" required>
                            @if($errors->has('kecamatan'))
                                <span class="text-danger">{{ $errors->first('kecamatan') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city">{{ trans('cruds.kependudukan.fields.city') }}</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}" required>
                            @if($errors->has('city'))
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="province">{{ trans('cruds.kependudukan.fields.province') }}</label>
                            <input class="form-control {{ $errors->has('province') ? 'is-invalid' : '' }}" type="text" name="province" id="province" value="{{ old('province', '') }}" required>
                            @if($errors->has('province'))
                                <span class="text-danger">{{ $errors->first('province') }}</span>
                            @endif
                            <span class="help-block"></span>
                        </div>
                      </div>
                    </div>
                </div>

                {{-- Informasi Kepala Keluarga --}}
                <div class="card">
                    <div class="card-header" id="card-heading-2">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#card-collapse-2" aria-expanded="false" aria-controls="card-collapse-2">
                                Informasi Kepala Keluarga
                            </button>
                        </h5>
                    </div>
                    <div id="card-collapse-2" class="collapse" aria-labelledby="card-heading-2" data-parent="#accordionExample">
                        <div class="card-body">
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
                                <input class="form-control {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required>
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
                                <label class="required" for="father_religion">{{ trans('cruds.kependudukan.fields.father_religion') }}</label>
                                <input class="form-control {{ $errors->has('father_religion') ? 'is-invalid' : '' }}" type="text" name="father_religion" id="father_religion" value="{{ old('father_religion', '') }}" required>
                                @if($errors->has('father_religion'))
                                    <span class="text-danger">{{ $errors->first('father_religion') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.kependudukan.fields.father_religion_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="father_occupation">{{ trans('cruds.kependudukan.fields.father_occupation') }}</label>
                                <input class="form-control {{ $errors->has('father_occupation') ? 'is-invalid' : '' }}" type="text" name="father_occupation" id="father_occupation" value="{{ old('father_occupation', '') }}" required>
                                @if($errors->has('father_occupation'))
                                    <span class="text-danger">{{ $errors->first('father_occupation') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.kependudukan.fields.father_occupation_helper') }}</span>
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
                                <label class="required" for="mother_religion">{{ trans('cruds.kependudukan.fields.mother_religion') }}</label>
                                <input class="form-control {{ $errors->has('mother_religion') ? 'is-invalid' : '' }}" type="text" name="mother_religion" id="mother_religion" value="{{ old('mother_religion', '') }}" required>
                                @if($errors->has('mother_religion'))
                                    <span class="text-danger">{{ $errors->first('mother_religion') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.kependudukan.fields.mother_religion_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="mother_occupation">{{ trans('cruds.kependudukan.fields.mother_occupation') }}</label>
                                <input class="form-control {{ $errors->has('mother_occupation') ? 'is-invalid' : '' }}" type="text" name="mother_occupation" id="mother_occupation" value="{{ old('mother_occupation', '') }}" required>
                                @if($errors->has('mother_occupation'))
                                    <span class="text-danger">{{ $errors->first('mother_occupation') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.kependudukan.fields.mother_occupation_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="disease">{{ trans('cruds.kependudukan.fields.disease') }}</label>
                                <input class="form-control {{ $errors->has('disease') ? 'is-invalid' : '' }}" type="text" name="disease" id="disease" value="{{ old('disease', '') }}" required>
                                @if($errors->has('disease'))
                                    <span class="text-danger">{{ $errors->first('disease') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.kependudukan.fields.disease_helper') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Add on and extend in here --}}
                <div id="appendDiv">

                </div>
            </div>


            {{-- Penambahan anggota --}}
            <div class="form-group">
                <button class="btn btn-info" type="button" id="button-add-anggota">
                    Tambah Anggota Keluarga
                </button>
            </div>

            {{-- Save button --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

{{-- Javascript untuk penambahan field --}}
@section('scripts')
<script>
    $(document).ready( function() {
        let anggotaIndex = 2;
  
        let arrayAppendElement = [
            {
                label: "Nama Lengkap",
                valueName: "fullname1[]",
                htmlId: "fullname1",
                fieldTyoe: "text",
            },
            {
                label: "NIK",
                valueName: "nik1[]",
                htmlId: "nik1",
                fieldTyoe: "text",
            },
            {
                label: "Tanggal Lahir",
                valueName: "birthdate1[]",
                htmlId: "birthdate1",
                fieldTyoe: "date",
            },
            {
                label: "Tempat Lahir",
                valueName: "birthplace1[]",
                htmlId: "birthplace1",
                fieldTyoe: "text",
            },
            {
                label: "Jenis Kelamin",
                valueName: "gender1[]",
                htmlId: "gender1",
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
                valueName: "religion1[]",
                htmlId: "religion1",
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
                label: "Status Pernikahan",
                valueName: "marital_status1[]",
                htmlId: "marital_status1",
                fieldTyoe: "select",
                optionValue: [
                    "KAWIN",
                    'BELUM_KAWIN',
                ],
                optionLabel: [
                    "Kawin",
                    "Belum Kawin",
                ],
            },
            {
                label: "Pendidikan Terakhir",
                valueName: "latest_education1[]",
                htmlId: "latest_education1",
                fieldTyoe: "select",
                optionValue: [
                    "SD",
                    'SLTP',
                    'SLTA',
                    'D3',
                    'S1',
                    'S2',
                    'S3',
                    'TIDAK_BERSEKOLAH'
                ],
                optionLabel: [
                    "SD/Sederajat",
                    "SMP/SLTP Sederajat",
                    'SMA/SLTA Sederajat',
                    'Diploma III',
                    'Diploma IV / S1 Sederajat',
                    'S2',
                    'S3',
                    'Tidak Bersekolah',
                ],
            },
            {
                label: "Profesi",
                valueName: "occupation1[]",
                htmlId: "occupation1",
                fieldTyoe: "text",
            },
            {
                label: "Nama Ayah",
                valueName: "father_name1[]",
                htmlId: "father_name1",
                fieldTyoe: "text",
            },
            {
                label: "Agama Ayah",
                valueName: "father_religion1[]",
                htmlId: "father_religion1",
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
                label: "Profesi Ayah",
                valueName: "father_occupation1[]",
                htmlId: "father_occupation1",
                fieldTyoe: "text",
            },
            {
                label: "Nama Ibu",
                valueName: "mother_name1[]",
                htmlId: "mother_name1",
                fieldTyoe: "text",
            },
            {
                label: "Agama Ibu",
                valueName: "mother_religion1[]",
                htmlId: "mother_religion1",
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
                label: "Profesi Ibu",
                valueName: "mother_occupation1[]",
                htmlId: "mother_occupation1",
                fieldTyoe: "text",
            },
            {
                label: "Riwayat Penyakit",
                valueName: "disease1[]",
                htmlId: "disease1",
                fieldTyoe: "text",
            },
        ];
  
        $("#button-add-anggota").click( function(event) {
            $append = `<div class="card">`;
            
            $append += `<div class="card-header" id="card-heading-${anggotaIndex}">`;
            $append += `<h5 class="mb-0">`;
            $append += `<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#card-collapse-${anggotaIndex}" aria-expanded="true" aria-controls="card-collapse-${anggotaIndex}">`;
            $append += `Anggota Keluarga ke-${anggotaIndex}`
            $append += `</button>`;
            $append += `</h5>`;
            $append += `</div>`;
            
  
            $append += `<div id="card-collapse-${anggotaIndex}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">`;
            $append += `<div class="card-body">`
                // Di isi dengan field
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
                });
            $append += `</div>`;
            $append += `</div>`;
  
            $append += `</div>`;
            anggotaIndex++;
            $("#appendDiv").append($append) 
        });
  
        function appendFieldText({label, valueName, htmlId}){
            let returnValue = "<div class='form-group'>" + 
                    `<label class="required" for="field${htmlId}">${label}</label>` +
                    `<input class="form-control" type="text" name="${valueName}" id="field${htmlId}" required>` +
                    `</div>`
                ;
            return returnValue   
        }
  
        function appendFieldDate({label, valueName, htmlId}){
            let returnValue = "<div class='form-group'>" + 
                    `<label class="required" for="field${htmlId}">${label}</label>` +
                    `<input class="form-control" type="date" name="${valueName}" id="field${htmlId}" required>` +
                    `</div>`
                ;
            return returnValue   
        }
  
        function appendFieldOption({label, valueName, htmlId, optionValue, optionLabel}){
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

        // Change field to disabled and or value
        // At home, karena di sini gk fokus
        // Reference --> https://learn.jquery.com/using-jquery-core/faq/how-do-i-disable-enable-a-form-element/
        $("#status_kependudukan").change( function (event) {

            let asliArray = [

            ];

            let pendatangArray = [];

            let value = this.value

            
            
            switch (value) {
                case 'ASLI':
                    
                    break;

                case 'PENDATANG':
                    
                    break;
            
                default:
                    break;
            }
        });
    });
  </script>
@endsection