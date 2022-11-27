<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\ResponseTrait;

class UsersApiController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        // abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new UserResource(User::with(['roles'])->get());
        return $this->successResponse("success fetching data", $resource);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        $resource = new UserResource($user);
        return $this->successResponse("success fetching data", $resource);
    }

    public function show(User $user)
    {
        // abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new UserResource($user->load(['roles']));
        return $this->successResponse("success fetching data", $resource);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        $resource = new UserResource($user);
        return $this->successResponse("success updating data", $resource);
    }

    public function destroy(User $user)
    {
        // abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
