<?php

namespace App\Http\Controllers\User;


use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\DeleteProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController
{
    /**
     * @var DeleteProfileService
     */
    private $service;

    public function __construct(DeleteProfileService $service)
    {
        $this->service = $service;
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

        $user->update([
            'name' => is_null($request->input('name')) ? null : Str::ucfirst(Str::lower($request->input('name'))),
            'surname' => is_null($request->input('surname')) ? null : Str::ucfirst(Str::lower($request->input('surname'))),
            'patronymic' => is_null($request->input('patronymic')) ? null : Str::ucfirst(Str::lower($request->input('patronymic'))),
            'phone' => is_null($request->input('phone')) ? null : '+7' . $request->input('phone'),
        ]);

        return redirect()->route('user.profile.index');
    }

    public function destroy()
    {
        $user = Auth::user();

        $this->service->delete($user);

        Auth::logout();

        $user->delete();

        return redirect()->route('main');
    }
}