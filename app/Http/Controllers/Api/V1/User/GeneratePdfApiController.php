<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Traits\ResponseTrait;
use Carbon\Carbon;
use App\Models\EntryMail;
use App\Models\MailData;
use App\Models\Kependudukan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GeneratePdfApiController extends Controller
{

    use ResponseTrait;

    public function generateSuratDomisili(Request $request){
        $user = User::find($this->extractUserIdFromToken());
        $dataKependudukan = $user->kependudukan;
        
        if(!$dataKependudukan){
            // Change this to return route or return view instead
            return $this->notFoundFailResponse();
        }

        // Dimasukan dulu ke entry_mail terlebih dahulu
        $entryMailInsert = [
            'title' => $this->generateTitle('KETERANGAN_DOMISILI', $dataKependudukan->fullname),
            'type' => 'KETERANGAN_DOMISILI',
            'user_id' => $user->id,
        ];
        $insertedEntryMail = EntryMail::create($entryMailInsert);
     
        // Memasukkan data detail mail
        $mailDataInsert = [
            'fullname' => $dataKependudukan->fullname,
            'nik' => $dataKependudukan->nik,
            'birthdate' => $dataKependudukan->birthdate,
            'birthplace' => $dataKependudukan->birthplace,
            'gender' => $dataKependudukan->gender,
            'religion' => $dataKependudukan->religion,
            'marital_status' => $dataKependudukan->marital_status,
            'latest_education' => $dataKependudukan->latest_education,
            'occupation' => $dataKependudukan->occupation,
            'father_name' => $dataKependudukan->father_name,
            'mother_name' => $dataKependudukan->mother_name,
            'disease' => $dataKependudukan->disease,
            // Special Attribute
            'keterangan_surat' => $request->post('keterangan_surat'),
            'domicile_status' => $request->post('domicile_status'),
            'owner_house_name' => $request->post('owner_house_name'),

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];

        $insertedMailData = MailData::create($mailDataInsert);

        $base64Signature = $this->toBase64($request->file('signature'));

        // Generate data for pdf here
        $pdfData = [
            'fullname' => $dataKependudukan->fullname,
            'nik' => $dataKependudukan->nik,
            'birthdate' => $dataKependudukan->birthdate,
            'birthplace' => $dataKependudukan->birthplace,
            'gender' => Kependudukan::GENDER_SELECT[$dataKependudukan->gender],
            'religion' => Kependudukan::RELIGION_SELECT[$dataKependudukan->religion],
            'marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$dataKependudukan->marital_status],
            'occupation' => $dataKependudukan->occupation,
            'keterangan_surat' => $request->post('keterangan_surat'),
            'signature' => $base64Signature,
            'owner_house_name' => $request->post('owner_house_name'),
        ];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-keterangan-domisili', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedMailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());

        $data = [
            'url_link' => asset('storage/pdf/' . $insertedEntryMail->title . '-' . $insertedEntryMail->id . '.pdf'),
        ];

        return $this->successResponse('success generate pdf', $data);
    }

    public function generateSuratKeteranganBelumMenikah(Request $request){
        $user = User::find($this->extractUserIdFromToken());
        $dataKependudukan = $user->kependudukan;
        
        if(!$dataKependudukan){
            // Change this to return route or return view instead
            return $this->notFoundFailResponse();
        }

        // Dimasukan dulu ke entry_mail terlebih dahulu
        $entryMailInsert = [
            'title' => $this->generateTitle('KETERANGAN_BELUM_MENIKAH', $dataKependudukan->fullname),
            'type' => 'KETERANGAN_BELUM_MENIKAH',
            'user_id' => $user->id,
        ];
        $insertedEntryMail = EntryMail::create($entryMailInsert);

        // Memasukkan data detail mail
        $mailDataInsert = [
            'fullname' => $dataKependudukan->fullname,
            'nik' => $dataKependudukan->nik,
            'birthdate' => $dataKependudukan->birthdate,
            'birthplace' => $dataKependudukan->birthplace,
            'gender' => $dataKependudukan->gender,
            'religion' => $dataKependudukan->religion,
            'marital_status' => $dataKependudukan->marital_status,
            'latest_education' => $dataKependudukan->latest_education,
            'occupation' => $dataKependudukan->occupation,
            'father_name' => $dataKependudukan->father_name,
            'mother_name' => $dataKependudukan->mother_name,
            'disease' => $dataKependudukan->disease,

            // Keterangan surat
            'keterangan_surat' => $request->post('keterangan_surat'),
            'alamat_orang_tua' => $request->post('alamat_orang_tua'),

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];
        $insertedMailData = MailData::create($mailDataInsert);

        // Generate data for pdf here
        $pdfData = [
            'fullname' => $dataKependudukan->fullname,
            'nik' => $dataKependudukan->nik,
            'birthdate' => $dataKependudukan->birthdate,
            'birthplace' => $dataKependudukan->birthplace,
            'gender' => Kependudukan::GENDER_SELECT[$dataKependudukan->gender],
            'religion' => Kependudukan::RELIGION_SELECT[$dataKependudukan->religion],
            'marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$dataKependudukan->marital_status],
            'latest_education' => Kependudukan::LATEST_EDUCATION_SELECT[$dataKependudukan->latest_education],
            'occupation' => $dataKependudukan->occupation,
            'father_name' => $dataKependudukan->father_name,
            'mother_name' => $dataKependudukan->mother_name,

            // Keterangan surat
            'keterangan_surat' => $request->post('keterangan_surat'),

            // Alamat Orang Tua
            'alamat_orang_tua' => $request->post('alamat_orang_tua'),
        ];

        // Generate PDf here
        $pdf = Pdf::loadView('pdf/surat-keterangan-belum-menikah', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedMailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());

        $data = [
            'url_link' => asset('storage/pdf/' . $insertedEntryMail->title . '-' . $insertedEntryMail->id . '.pdf'),
        ];

        return $this->successResponse('success generate pdf', $data);
    }

    public function generateSuratPengantarNikah(Request $request){
        $user = User::find($this->extractUserIdFromToken());
        $dataKependudukan = $user->kependudukan;
        
        if(!$dataKependudukan){
            // Change this to return route or return view instead
            return $this->notFoundFailResponse();
        }

        // Dimasukan dulu ke entry_mail terlebih dahulu
        $entryMailInsert = [
            'title' => $this->generateTitle('PENGANTAR_SURAT_NIKAH', $dataKependudukan->fullname),
            'type' => 'PENGANTAR_SURAT_NIKAH',
            'user_id' => $user->id,
        ];
        $insertedEntryMail = EntryMail::create($entryMailInsert);

        // Memasukkan data detail mail
        $mailDataInsert = [
            'fullname' => $dataKependudukan->fullname,
            'nik' => $dataKependudukan->nik,
            'birthdate' => $dataKependudukan->birthdate,
            'birthplace' => $dataKependudukan->birthplace,
            'gender' => $dataKependudukan->gender,
            'religion' => $dataKependudukan->religion,
            'marital_status' => $dataKependudukan->marital_status,
            'latest_education' => $dataKependudukan->latest_education,
            'occupation' => $dataKependudukan->occupation,
            // Ayah
            'father_name' => $dataKependudukan->father_name,
            'father_religion' => $request->post('father_religion'),
            'father_occupation' => $request->post('father_occupation'),
            'mother_marital_status' => $request->post('mother_marital_status'),
            'father_address' => $request->post('father_address'),
            // Ibu
            'mother_name' => $dataKependudukan->mother_name,
            'mother_religion' => $request->post('mother_religion'),
            'mother_occupation' => $request->post('mother_occupation'),
            'mother_marital_status' => $request->post('mother_marital_status'),
            'mother_address' => $request->post('mother_address'),
            
            'disease' => $dataKependudukan->disease,

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];
        $insertedMailData = MailData::create($mailDataInsert);

        // Generate data for pdf here
        $pdfData = [
            'fullname' => $dataKependudukan->fullname,
            'gender' => Kependudukan::GENDER_SELECT[$dataKependudukan->gender],
            'birthdate' => $dataKependudukan->birthdate,
            'birthplace' => $dataKependudukan->birthplace,
            'religion' => Kependudukan::RELIGION_SELECT[$dataKependudukan->religion],
            'occupation' => $dataKependudukan->occupation,
            'marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$dataKependudukan->marital_status],
            // Ayah
            'father_name' => $dataKependudukan->father_name,
            'father_religion' => Kependudukan::RELIGION_SELECT[$request->post('father_religion')],
            'father_occupation' => $request->post('father_occupation'),
            'father_marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$request->post('father_marital_status')],
            'father_address' => $request->post('father_address'),
            // Ibu
            'mother_name' => $dataKependudukan->mother_name,
            'mother_religion' => Kependudukan::RELIGION_SELECT[$request->post('mother_religion')],
            'mother_occupation' => $request->post('mother_occupation'),
            'mother_marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$request->post('mother_marital_status')],
            'mother_address' => $request->post('mother_address'),
        ];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-pengantar-nikah', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedMailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());

        $data = [
            'url_link' => asset('storage/pdf/' . $insertedEntryMail->title . '-' . $insertedEntryMail->id . '.pdf'),
        ];

        return $this->successResponse('success generate pdf', $data);
    }

    private function extractUserIdFromToken(){
        return auth('sanctum')->user()->id;
    }

    private function generateTitle($mailType, $userFullName){
        $mailType = $mailType;
        $now = Carbon::now()->format('d-m-Y');

        // Format: TIPE_SURAT - TANGGAL_PENGAJUAN_SURAT - PENGAJU
        $generatedString = $mailType . " - " . $now . " - " . $userFullName;
        
        return $generatedString;
    }

    private function toBase64($image){
        $imageContents = file_get_contents($image);
        $base64ImgString = "data:image/jpeg;base64," . base64_encode($imageContents);
        return $base64ImgString;
        
}
}
