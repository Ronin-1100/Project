<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SearchRequest;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource\ShortUserResource;
use App\Http\Resources\UserResource\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        return ShortUserResource::collection(
            $this->userService->paginate($request->validated())
        );
    }

    public function show(User $user): UserResource
    {
        $user->load(['trades']);

        return new UserResource($user);
    }

    public function store(CreateRequest $request): UserResource
    {
        return new UserResource(
            $this->userService->create($request->validated())
        );
    }

    public function update(User $user, UpdateRequest $request): UserResource
    {
        $user->update($request->validated());

        return new UserResource($user->refresh());
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }
}
