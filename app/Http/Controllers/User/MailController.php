<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EntryMail;
use App\Models\MailData;
use App\Models\Kependudukan;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{

    // Di sini akan menampilkan dia sudah mengirim surat apa saja selama ini
    public function index(Request $request){

        $user = Auth::user();

        if ($this->isBapakRT($user->roles[0]->id)) {
            $entryMails = EntryMail::with(['media'])->get();
        } else {
            $entryMails = EntryMail::where('user_id', '=', $user->id)
                ->with(['media'])->get();
        }

        foreach ($entryMails as $entryMail) {
            // Prefix
            if ($entryMail->mail) {
                $entryMail['file_link'] = $entryMail->mail->original_url;
            } elseif($entryMail->detail){
                $prefixPath = 'storage/pdf/';
                $entryMail['file_link'] = asset($prefixPath . $entryMail->title . '-' . $entryMail->id . '.pdf');
            } elseif($entryMail->file_path) {
                $prefixPath = 'storage/pdf/';
                $entryMail['file_link'] = asset($prefixPath . $entryMail->title . '-' . $entryMail->id . '.pdf');
            } else {
                $entryMail = '#';
            }
        }

        return view('user.mail.index', compact('entryMails'));
    }

    // Di sini dia akan mengembalikan view ketika dia ingin membuat surat
    public function create(Request $request){

        // Jika pengguna aplikasi yang masuk ke sini adalah bapak rt, maka bisa dipake buat listing data orang-orang
        if ($this->isBapakRT(Auth::user()->roles[0]->id)) {
            $users = User::all();
        } else {
            $users = null;
        }

        return view('user.mail.create', compact('users'));
    }

    // Di sini dia akan melakukan storing
    public function store(Request $request){
        // Jika pengguna yang masuk ke sini adalah RT
        $user = Auth::user();
        if ($this->isBapakRT($user->roles[0]->id)) {
            $reqUser = $request->post('user');
            $user = User::find($reqUser);
        } 
        
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
            // Special Attribute
            'keterangan_surat' => $request->post('keterangan_surat'),
            'domicile_status' => $request->post('domicile_status'),
            'owner_house_name' => $request->post('owner_house_name'),
            'domicile_address' => $request->post('domicile_address'),

            // Add on
            'entry_mail_id' => $insertedEntryMail->id,
        ];
        $insertedMailData = MailData::create($mailDataInsert);

        // $base64Signature = $this->toBase64($request->file('signature'));

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
            // 'signature' => $base64Signature,
            'owner_house_name' => $request->post('owner_house_name'),
            'domicile_status' => $request->post('domicile_status'),
            'domicile_address' => $request->post('domicile_address'),
        ];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-keterangan-domisili', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedEntryMail->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());
        $insertedEntryMail->file_path = asset('storage/pdf/' . $fileName);
        $insertedEntryMail->save();

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
            'file_path' => $this->generateTitle($request, $dataKependudukan->fullname),
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
            'father_religion' => $dataKependudukan->father_religion,
            'father_occupation' => $dataKependudukan->father_occupation,
            'father_marital_status' => 'KAWIN',
            'father_address' => $request->post('father_address'),
            // Ibu
            'mother_name' => $dataKependudukan->mother_name,
            'mother_religion' => $dataKependudukan->mother_religion,
            'mother_occupation' => $dataKependudukan->mother_occupation,
            'mother_marital_status' => 'KAWIN',
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
            'father_religion' => Kependudukan::RELIGION_SELECT[$dataKependudukan->father_religion],
            'father_occupation' => $dataKependudukan->father_occupation,
            'father_marital_status' => Kependudukan::MARITAL_STATUS_SELECT['KAWIN'],
            'father_address' => $request->post('father_address'),
            // Ibu
            'mother_name' => $dataKependudukan->mother_name,
            'mother_religion' => Kependudukan::RELIGION_SELECT[$dataKependudukan->mother_religion],
            'mother_occupation' => $dataKependudukan->mother_occupation,
            'mother_marital_status' => Kependudukan::MARITAL_STATUS_SELECT['KAWIN'],
            'mother_address' => $request->post('mother_address'),
        ];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-pengantar-nikah', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedEntryMail->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());
        $insertedEntryMail->file_path = asset('storage/pdf/' . $fileName);
        $insertedEntryMail->save();

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
            'file_path' => $this->generateTitle($request, $dataKependudukan->fullname),
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
            'original_address' => $request->post('original_address'),
            'domicile_address' => $request->post('domicile_address'),

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
            'original_address' => $request->post('original_address'),
            'domicile_address' => $request->post('domicile_address'),
        ];

        // Generate PDf here
        $pdf = Pdf::loadView('pdf/surat-keterangan-belum-menikah', $pdfData);

        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedEntryMail->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());
        $insertedEntryMail->file_path = asset('storage/pdf/' . $fileName);
        $insertedEntryMail->save();

        return redirect()->route('portal.pengajuan-surat.index');
    }

    // Handle surat keterangan persetujuan tetangga
    private function storePersetujuanTetangga(Request $request, $user, $dataKependudukan){
        // Dicek ada file atau tidak
        
        // Dimasukan dulu ke entry_mail terlebih dahulu
        $entryMailInsert = [
            'title' => $this->generateTitle($request, $dataKependudukan->fullname),
            'type' => $request->post('mail_type'),
            'user_id' => $user->id,
        ];
        $insertedEntryMail = EntryMail::create($entryMailInsert);

        if(!$request->file('document')){
            return redirect()->route('portal.pengajuan-surat.index');    
        }
        // Storing the data
        $fileName = $entryMailInsert['title'] . '-' . $insertedEntryMail->id . '.pdf';
        $request->file('document')->storeAs('public/pdf', $fileName);
        $insertedEntryMail->file_path = asset('storage/pdf/' . $fileName);
        $insertedEntryMail->save();

        return redirect()->route('portal.pengajuan-surat.index');
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

    private function toBase64($image){
            $imageContents = file_get_contents($image);
            $base64ImgString = "data:image/jpeg;base64," . base64_encode($imageContents);
            return $base64ImgString;
            
    }
}
