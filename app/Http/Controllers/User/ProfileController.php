<?php

namespace App\Http\Controllers\User;


use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\DeleteProfileService;
use App\Http\Services\Elasticsearch\UsersService;
use App\Http\Services\UpdateProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController
{
    /**
     * @var DeleteProfileService
     */
    private $deleteService;
    /**
     * @var UpdateProfileService
     */
    private $updateService;

    public function __construct(DeleteProfileService $deleteService, UpdateProfileService $updateService)
    {
        $this->deleteService = $deleteService;
        $this->updateService = $updateService;
    }

    public function index()
    {
        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $this->updateService->update($user, $request);
        return redirect()->route('user.profile.index');
    }

    public function destroy()
    {
        $user = Auth::user();
        $this->deleteService->delete($user);
        return redirect()->route('main');
    }
}