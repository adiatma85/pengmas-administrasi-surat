<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEntryMailRequest;
use App\Http\Requests\StoreEntryMailRequest;
use App\Http\Requests\UpdateEntryMailRequest;
use App\Models\EntryMail;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Kependudukan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntryMailController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('entry_mail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entryMails = EntryMail::with(['media'])->get();

        foreach ($entryMails as $entryMail) {
            // Prefix
            $prefixPath = 'storage/pdf/';
            $entryMail['file_link'] = asset($prefixPath . $entryMail->title . '-' . $entryMail->id . '.pdf');
        }

        return view('admin.entryMails.index', compact('entryMails'));
    }

    public function create()
    {
        abort_if(Gate::denies('entry_mail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.entryMails.create');
    }

    public function store(StoreEntryMailRequest $request)
    {
        $entryMail = EntryMail::create($request->all());

        if ($request->input('mail', false)) {
            $entryMail->addMedia(storage_path('tmp/uploads/' . basename($request->input('mail'))))->toMediaCollection('mail');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $entryMail->id]);
        }

        return redirect()->route('admin.entry-mails.index');
    }

    public function edit(EntryMail $entryMail)
    {
        abort_if(Gate::denies('entry_mail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.entryMails.edit', compact('entryMail'));
    }

    public function update(UpdateEntryMailRequest $request, EntryMail $entryMail)
    {
        $entryMail->update($request->all());

        if ($request->input('mail', false)) {
            if (!$entryMail->mail || $request->input('mail') !== $entryMail->mail->file_name) {
                if ($entryMail->mail) {
                    $entryMail->mail->delete();
                }
                $entryMail->addMedia(storage_path('tmp/uploads/' . basename($request->input('mail'))))->toMediaCollection('mail');
            }
        } elseif ($entryMail->mail) {
            $entryMail->mail->delete();
        }

        // return redirect()->route('admin.entry-mails.index');
        return redirect()->route('portal.pengajuan-surat.index');
    }

    public function show(EntryMail $entryMail)
    {
        abort_if(Gate::denies('entry_mail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.entryMails.show', compact('entryMail'));
    }

    public function destroy(EntryMail $entryMail)
    {
        abort_if(Gate::denies('entry_mail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entryMail->delete();

        return back();
    }

    public function massDestroy(MassDestroyEntryMailRequest $request)
    {
        EntryMail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('entry_mail_create') && Gate::denies('entry_mail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EntryMail();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function mailAccept(Request $request, $entryMailId){
        $entryMail = EntryMail::where('id', $entryMailId);
        $entryMail->update(['status' => 'DISETUJUI',]);

        $entryMail = $entryMail->first();

        // Get the type

        switch ($entryMail->type) {
            case "KETERANGAN_DOMISILI":
                $this->generateSuratDomisili($entryMail);
                break;
            case 'PENGANTAR_SURAT_NIKAH':
                $this->generateSuratPengantarNikah($entryMail);
                break;
            case 'KETERANGAN_BELUM_MENIKAH':
                $this->generateSuratBelumMenikah($entryMail);
                break;
            case 'PERSETUJUAN_TETANGGA':
                // Kalau ini cukup ganti file nya saja terus ganti statusnya saja
                break;
        }
        
        return back();
    }

    private function generateSuratBelumMenikah($entryMail){

        $mailData = $entryMail->detail;

        // Generate data for pdf here
        $pdfData = [
            'fullname' => $mailData->fullname,
            'nik' => $mailData->nik,
            'birthdate' => $mailData->birthdate,
            'birthplace' => $mailData->birthplace,
            'gender' => Kependudukan::GENDER_SELECT[$mailData->gender],
            'religion' => Kependudukan::RELIGION_SELECT[$mailData->religion],
            'marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$mailData->marital_status],
            'latest_education' => Kependudukan::LATEST_EDUCATION_SELECT[$mailData->latest_education],
            'occupation' => $mailData->occupation,
            'father_name' => $mailData->father_name,
            'mother_name' => $mailData->mother_name,

            // Keterangan surat
            'keterangan_surat' => $mailData->keterangan_surat,

            // Alamat Orang Tua
            'alamat_orang_tua' => $mailData->alamat_orang_tua,

            // Trigger for penandatanganan
            'ketua_rt_signature' => Auth::user()->img_signature,
        ];

        // Generate PDf here
        $pdf = Pdf::loadView('pdf/surat-keterangan-belum-menikah', $pdfData);

        // Storing the data
        $fileName = $entryMail->title . '-' . $mailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());
    }

    private function generateSuratDomisili($entryMail){
        $mailData = $entryMail->detail;

        $base64Signature = "data:image/jpeg;base64," . $mailData->base_64_owner_house_signature;

        // Generate data for pdf here
        $pdfData = [
            'fullname' => $mailData->fullname,
            'nik' => $mailData->nik,
            'birthdate' => $mailData->birthdate,
            'birthplace' => $mailData->birthplace,
            'gender' => Kependudukan::GENDER_SELECT[$mailData->gender],
            'religion' => Kependudukan::RELIGION_SELECT[$mailData->religion],
            'marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$mailData->marital_status],
            'occupation' => $mailData->occupation,
            'keterangan_surat' => $mailData->keterangan_surat,
            'signature' => $base64Signature,
            'owner_house_name' => $mailData->owner_house_name,

            // Trigger for penandatanganan
            'ketua_rt_signature' => Auth::user()->img_signature,
        ];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-keterangan-domisili', $pdfData);

        // Storing the data
        $fileName = $entryMail->title . '-' . $mailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());
    }

    private function generateSuratPengantarNikah($entryMail){
        $mailData = $entryMail->detail;

        // Generate data for pdf here
        $pdfData = [
            'fullname' => $mailData->fullname,
            'gender' => Kependudukan::GENDER_SELECT[$mailData->gender],
            'birthdate' => $mailData->birthdate,
            'birthplace' => $mailData->birthplace,
            'religion' => Kependudukan::RELIGION_SELECT[$mailData->religion],
            'occupation' => $mailData->occupation,
            'marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$mailData->marital_status],
            // Ayah
            'father_name' => $mailData->father_name,
            'father_religion' => Kependudukan::RELIGION_SELECT[$mailData->father_religion],
            'father_occupation' => $mailData->father_occupation,
            'father_marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$mailData->father_marital_status],
            'father_address' => $mailData->father_address,
            // Ibu
            'mother_name' => $mailData->mother_name,
            'mother_religion' => Kependudukan::RELIGION_SELECT[$mailData->mother_religion],
            'mother_occupation' => $mailData->mother_occupation,
            'mother_marital_status' => Kependudukan::MARITAL_STATUS_SELECT[$mailData->mother_marital_status],
            'mother_address' => $mailData->mother_address,

            // Trigger for penandatanganan
            'ketua_rt_signature' => Auth::user()->img_signature,
        ];

        // Generate PDF here
        $pdf = Pdf::loadView('pdf/surat-pengantar-nikah', $pdfData);

        // Storing the data
        $fileName = $entryMail->title . '-' . $mailData->id . '.pdf';
        Storage::put('public/pdf/' . $fileName, $pdf->output());
    }

    public function mailReject(Request $request, $entryMailId){
        $entryMail = EntryMail::where('id', $entryMailId)
            ->update([
                'status' => 'DITOLAK',
            ]);
        
        return back();
    }
}
