<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Dashboard\User\CreateUserRequest;
use App\Http\Requests\Dashboard\User\DestroyUserRequest;
use App\Http\Requests\Dashboard\User\EditUserRequest;
use App\Http\Requests\Dashboard\User\IndexUserRequest;
use App\Http\Requests\Dashboard\User\ShowUserRequest;
use App\Http\Requests\Dashboard\User\StoreUserRequest;
use App\Http\Requests\Dashboard\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexUserRequest $request): Response
    {
        return Inertia::render('User/List', [
            'users' => $this->userRepository->list()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateUserRequest $request): Response
    {
        return Inertia::render('User/Create',[
            'roles' => Role::all()->pluck('name')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userRepository->store($request->validated());

        return redirect()->route('users.index')->with(['message' => 'Operation successful']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowUserRequest $request, User $user): Response
    {
        return Inertia::render('User/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditUserRequest $request, User $user): Response
    {
        return Inertia::render('User/Edit', [
            'user' => $user,
            'roles' => Role::all()->pluck('name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->userRepository->update($user, $request->validated());

        return redirect()->route('users.index')->with(['message' => 'Operation successful']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyUserRequest $request, User $user): RedirectResponse
    {
        $this->userRepository->destroy($user);

        return redirect()->route('users.index')->with(['message' => 'Operation successful']);
    }
}
