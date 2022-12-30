<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\ResponseTrait;

class PermissionsApiController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        // abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new PermissionResource(Permission::all());
        return $this->successResponse("success fetching data", $resource);
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());

        $resource = new PermissionResource($permission);
        return $this->successResponse("success fetching data", $resource);
    }

    public function show(Permission $permission)
    {
        // abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new PermissionResource($permission);
        return $this->successResponse("success fetching data", $resource);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());

        $resource = new PermissionResource($permission);
        return $this->successResponse("success updating data", $resource);
    }

    public function destroy($permissionId)
    {
        // abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $permission->delete();
        // Random delete
        Permission::inRandomOrder()->limit(1)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
