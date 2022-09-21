<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EntryMail;
use App\Models\MailData;
use App\Models\Kependudukan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{

    // Di sini akan menampilkan dia sudah mengirim surat apa saja selama ini
    public function index(Request $request){

        $user = Auth::user();

        $entryMails = EntryMail::where('user_id', '=', $user->id)
            ->with(['media'])->get();
        
        foreach ($entryMails as $entryMail) {
            // Prefix
            $prefixPath = 'storage/pdf/';
            $entryMail['file_link'] = asset($prefixPath . $entryMail->title . '-' . $entryMail->id . '.pdf');
        }

        return view('user.mail.index', compact('entryMails'));
    }

    // Di sini dia akan mengembalikan view ketika dia ingin membuat surat
    public function create(Request $request){
        return view('user.mail.create');
    }

    // Di sini dia akan melakukan storing
    public function store(Request $request){
        $user = Auth::user();
        $dataKependudukan = $user->kependudukan;
        
        if(!$dataKependudukan){
            // Change this to return route or return view instead
            return response()->json("data kependudukan tidak ditemukan");
        }

        // SWITCH CASE melakukan pengecekan tipe surat yang akan di store
        $mailType = $request->post('mail_type');
        if(!$mailType){
            // Change this to return route or return view instead
            return response()->json("masukan tidak valid (mail_type)");
        }

        switch ($mailType){
            case "KETERANGAN_DOMISILI":
                return $this->storeSuratDomisili($request, $user, $dataKependudukan);
                break;
            case 'PENGANTAR_SURAT_NIKAH':
                return $this->storeSuratPengantarNikah($request, $user, $dataKependudukan);
                break;
            case 'KETERANGAN_BELUM_MENIKAH':
                return $this->storeKeteranganBelumMenikah($request, $user, $dataKependudukan);
                break;
            case 'PERSETUJUAN_TETANGGA':
                return $this->storePersetujuanTetangga($request, $user, $dataKependudukan);
                break;
        }
    }

    // Handle surat keterangan domisili
    private function storeSuratDomisili(Request $request, $user, $dataKependudukan){

        // Change validation logic in here

        if(!$request->post('keterangan_surat')){
            // Change this to return route or return view instead
            return response()->json("masukan tidak valid (keterangan_surat)");
        }

        // Dimasukan dulu ke entry_mail terlebih dahulu
        $entryMailInsert = [
            'title' => $this->generateTitle($request, $dataKependudukan->fullname),
            'type' => $request->post('mail_type'),
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
            'disease' => $dataKependudukan->disease,'father_religion' => $request->post('father_religion'),
            // MUST ADD NEW FIELD IN HERE
            // 'father_occupation' => $request->post('father_occupation'),
            // 'father_marital_status' => $request->post('marital_status'),
            // 'father_address' => $request->post('father_address'),
            // 'mother_religion' => $request->post('mother_religion'),
            // 'mother_occupation' => $request->post('mother_occupation'),
            // 'mother_marital_status' => $request->post('mother_marital_status'),
            // 'mother_address' => $request->post('mother_address'),

            // Keterangan surat
            'keterangan_surat' => $request->post('keterangan_surat'),

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];
        $insertedMailData = MailData::create($mailDataInsert);

        // Generate data for pdf here
        $pdfData = [];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-keterangan-domisili', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedMailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());

        return redirect()->route('portal.pengajuan-surat.index');
    }

    // Handle surat pengantar menikah
    private function storeSuratPengantarNikah(Request $request, $user, $dataKependudukan){

        // Change validation logic in here

        // Dimasukan dulu ke entry_mail terlebih dahulu
        $entryMailInsert = [
            'title' => $this->generateTitle($request, $dataKependudukan->fullname),
            'type' => $request->post('mail_type'),
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
            // MUST ADD FIELD IN HERE
            // 'father_religion' => $request->post('father_religion'),
            // 'father_occupation' => $request->post('father_occupation'),
            // 'father_marital_status' => $request->post('marital_status'),
            // 'father_address' => $request->post('father_address'),
            // 'mother_religion' => $request->post('mother_religion'),
            // 'mother_occupation' => $request->post('mother_occupation'),
            // 'mother_marital_status' => $request->post('mother_marital_status'),
            // 'mother_address' => $request->post('mother_address'),
            // MUST ADD FIELD IN HERE
            'mother_name' => $dataKependudukan->mother_name,
            'disease' => $dataKependudukan->disease,

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];
        $insertedMailData = MailData::create($mailDataInsert);

        // Generate data for pdf here
        $pdfData = [];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-pengantar-nikah', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedMailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());

        return redirect()->route('portal.pengajuan-surat.index');
    }

    // Handle surat keterangan belum menikah
    private function storeKeteranganBelumMenikah(Request $request, $user, $dataKependudukan){
        // Change validation logic in here

        if(!$request->post('keterangan_surat')){
            // Change this to return route or return view instead
            return response()->json("masukan tidak valid");
        }

        // Dimasukan dulu ke entry_mail terlebih dahulu
        $entryMailInsert = [
            'title' => $this->generateTitle($request, $dataKependudukan->fullname),
            'type' => $request->post('mail_type'),
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

        return redirect()->route('portal.pengajuan-surat.index');
    }

    // Handle surat keterangan persetujuan tetangga
    private function storePersetujuanTetangga(Request $request, $user, $dataKependudukan){
        // Ini kayaknya upload saja deh....
    }

    // Handle generated name for storeSuratHandler
    // Return a generatedTitleString
    private function generateTitle(Request $request, $userFullName){
        $mailType = $request->post('mail_type');
        $now = Carbon::now()->format('d-m-Y');

        // Format: TIPE_SURAT - TANGGAL_PENGAJUAN_SURAT - PENGAJU
        $generatedString = $mailType . " - " . $now . " - " . $userFullName;
        
        return $generatedString;
    }
}
