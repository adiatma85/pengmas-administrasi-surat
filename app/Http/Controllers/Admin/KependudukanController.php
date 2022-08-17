<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyKependudukanRequest;
use App\Http\Requests\StoreKependudukanRequest;
use App\Http\Requests\UpdateKependudukanRequest;
use App\Models\Kependudukan;
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
        $kependudukan = Kependudukan::create($request->all());

        return redirect()->route('admin.kependudukans.index');
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