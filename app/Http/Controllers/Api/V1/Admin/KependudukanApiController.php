<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKependudukanRequest;
use App\Http\Requests\UpdateKependudukanRequest;
use App\Http\Resources\KependudukanResource;
use App\Models\Kependudukan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KependudukanApiController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('kependudukan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KependudukanResource(Kependudukan::all());
    }

    public function store(StoreKependudukanRequest $request)
    {
        $kependudukan = Kependudukan::create($request->all());

        return (new KependudukanResource($kependudukan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Kependudukan $kependudukan)
    {
        // abort_if(Gate::denies('kependudukan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KependudukanResource($kependudukan);
    }

    public function update(UpdateKependudukanRequest $request, Kependudukan $kependudukan)
    {
        $kependudukan->update($request->all());

        return (new KependudukanResource($kependudukan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Kependudukan $kependudukan)
    {
        // abort_if(Gate::denies('kependudukan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kependudukan->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}