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
