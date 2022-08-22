<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EntryMail;
use App\Models\MailData;
use Carbon\Carbon;

class MailController extends Controller
{

    // Di sini akan menampilkan dia sudah mengirim surat apa saja selama ini
    public function index(Request $request){

        $user = Auth::user();

        $entryMails = EntryMail::where('user_id', '=', $user->id)
            ->with(['media'])->get();

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
            'disease' => $dataKependudukan->disease,

            // Keterangan surat
            'keterangan_surat' => $request->post('keterangan_surat'),

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];
        $insertedMailData = MailData::create($mailDataInsert);

        // Generate PDF here
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
            'father_religion' => $request->post('father_religion'),
            'father_occupation' => $request->post('father_occupation'),
            'father_marital_status' => $request->post('father_marital_status'),
            'father_address' => $request->post('father_address'),
            'mother_religion' => $request->post('mother_religion'),
            'mother_occupation' => $request->post('mother_occupation'),
            'mother_marital_status' => $request->post('mother_marital_status'),
            'mother_address' => $request->post('mother_address'),
            'mother_name' => $dataKependudukan->mother_name,
            'disease' => $dataKependudukan->disease,

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];
        $insertedMailData = MailData::create($mailDataInsert);

        // Generate PDF here
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

        // Generate PDf here
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
