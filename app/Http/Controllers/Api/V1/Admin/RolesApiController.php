<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\ResponseTrait;

class RolesApiController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        // abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new RoleResource(Role::with(['permissions'])->get());
        return $this->successResponse("success fetching data", $resource);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        $resource = new RoleResource($role);
        return $this->successResponse("success fetching data", $resource);
    }

    public function show(Role $role)
    {
        // abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new RoleResource($role->load(['permissions']));
        return $this->successResponse("success fetching data", $resource);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        $resource = new RoleResource($role);
        return $this->successResponse("success updating data", $resource);
    }

    public function destroy(Role $role)
    {
        // abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}