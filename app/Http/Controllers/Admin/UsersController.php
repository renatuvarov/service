<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RegisterRequest;
use App\Http\Services\RegisterService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UsersController extends Controller
{
    /**
     * @var RegisterService
     */
    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(2);
        $id = Auth::user()->id;
        return view('admin.users.index', compact('users', 'id'));
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

        if (Redis::exists('order.' . $user->id)) {
            Redis::del('order.' . $user->id);
        }

        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
