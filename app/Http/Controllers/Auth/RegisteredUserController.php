<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Laravolt\Avatar\Facade as Avatar;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'organization_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $avatar = "avatar_".strtotime('now').".png";

        Avatar::create($request->get('name'))->save(Storage::disk('public')->path(User::AVATAR_STORAGE_PATH.'/'.$avatar));

        $user = User::create([
            'tenant_id' => 1,
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'avatar' => $avatar,
            'active' => User::USER_ACTIVE,
            'is_owner' => User::ORGANISATION_OWNER_YES,
            'type' => User::TYPE_SYSTEM_USER,
            'password' => Hash::make($request->get('password')),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
