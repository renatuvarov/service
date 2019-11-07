<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminUsersSearchRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\DeleteProfileService;
use App\Http\Services\Elasticsearch\UsersService;
use App\Http\Services\RegisterService;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * @var RegisterService
     */
    private $service;
    /**
     * @var UsersService
     */
    private $usersService;
    /**
     * @var DeleteProfileService
     */
    private $deleteService;

    public function __construct(
        RegisterService $service,
        UsersService $usersService,
        DeleteProfileService $deleteService
    ) {
        $this->service = $service;
        $this->usersService = $usersService;
        $this->deleteService = $deleteService;
    }

    public function index(AdminUsersSearchRequest $request)
    {
        $users = User::orderBy('created_at', 'desc')->paginate(2);
        $id = Auth::user()->id;
        $roles = User::roles();
        return view('admin.users.index', compact('users', 'id', 'roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(RegisterRequest $request)
    {
        $this->service->createUser($request->all());
        return redirect()->route('admin.users.index');
    }

    public function destroy($user)
    {
        $user = User::findOrFail($user);
        $this->deleteService->delete($user);
        return redirect()->route('admin.users.index');
    }
}
