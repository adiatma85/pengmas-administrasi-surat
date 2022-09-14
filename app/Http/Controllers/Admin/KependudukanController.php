<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyKependudukanRequest;
use App\Http\Requests\StoreKependudukanRequest;
use App\Http\Requests\UpdateKependudukanRequest;
use App\Models\Kependudukan;
use App\Models\Family;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KependudukanController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('kependudukan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kependudukans = Kependudukan::all();

        return view('admin.kependudukans.index', compact('kependudukans'));
    }

    public function create()
    {
        abort_if(Gate::denies('kependudukan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.kependudukans.create');
    }

    public function store(StoreKependudukanRequest $request)
    {
        // Insert data kk kepada family terlebih dahulu
        $family = [
            'no_kk' => $request->no_kk,
            'status_kependudukan' => $request->status_kependudukan,
            'address' => $request->address,
            'rt_rw' => $request->rt_rw,
            'postal_code' => $request->postal_code,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'city' => $request->city,
            'province' => $request->province,
            'status_kependudukan' => $request->status_kependudukan,
        ];

        $insertedFamily = Family::create($family);

        $headFamUser = [
            'name' => $request->fullname,
            'email' => $request->fullname . '@admin.com', // will refix this
            'password' => $request->nik . '-' . $request->birthplace, // kombinasi dari NIK dan tanggal lahir di bcrypt
        ];

        $registeredUser = User::create($headFamUser);
        $registeredUser->roles()->sync([User::MASAYARAKAT_ROLE_ID]);

        $headFam = [
            'fullname' => $request->fullname,
            'nik' => $request->nik,
            'birthdate' => $request->birthdate,
            'birthplace' => $request->birthplace,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'marital_status' => $request->marital_status,
            'latest_education' => $request->latest_education,
            'occupation' => $request->occupation,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'disease' => $request->disease,

            // Foreign keys
            'family_id' => $insertedFamily->id,
            'user_id' => $registeredUser->id,
        ];

        $insertedHeadFam = Kependudukan::create($headFam);

        if ($request->fullname1) {
            $this->assignAnotherFamilies($request, $insertedFamily->id);
        }

        return redirect()->route('admin.kependudukans.index');
    }

    private function assignAnotherFamilies(Request $request, $familyId){
        for ($i=0; $i < count($request->fullname1) ; $i++) { 
            $userData = [
                'name' => $request->fullname1[$i],
                'email' => $request->fullname1[$i] . '@admin.com',
                'password' => $request->nik1[$i] . '-' . $request->birthplace1[$i], // kombinasi dari NIK dan tanggal lahir di bcrypt
            ];

            $registeredUser = User::create($userData);
            $registeredUser->roles()->sync([User::MASAYARAKAT_ROLE_ID]);

            $anggotaFam = [
                'fullname' => $request->fullname1[$i],
                'nik' => $request->nik1[$i],
                'birthdate' => $request->birthdate1[$i],
                'birthplace' => $request->birthplace1[$i],
                'gender' => $request->gender1[$i],
                'religion' => $request->religion1[$i],
                'marital_status' => $request->marital_status1[$i],
                'latest_education' => $request->latest_education1[$i],
                'occupation' => $request->occupation1[$i],
                'father_name' => $request->father_name1[$i],
                'mother_name' => $request->mother_name1[$i],
                'disease' => $request->disease1[$i],

                // Foreign keys
                'family_id' => $familyId,
                'user_id' => $registeredUser->id,
            ];

            $insertedHeadFam = Kependudukan::create($anggotaFam);
        }
    }

    public function edit(Kependudukan $kependudukan)
    {
        abort_if(Gate::denies('kependudukan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.kependudukans.edit', compact('kependudukan'));
    }

    public function update(UpdateKependudukanRequest $request, Kependudukan $kependudukan)
    {
        $kependudukan->update($request->all());

        return redirect()->route('admin.kependudukans.index');
    }

    public function show(Kependudukan $kependudukan)
    {
        abort_if(Gate::denies('kependudukan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.kependudukans.show', compact('kependudukan'));
    }

    public function destroy(Kependudukan $kependudukan)
    {
        abort_if(Gate::denies('kependudukan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kependudukan->delete();

        return back();
    }

    public function massDestroy(MassDestroyKependudukanRequest $request)
    {
        Kependudukan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}