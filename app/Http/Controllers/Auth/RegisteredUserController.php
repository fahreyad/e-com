<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'referrer' => ['required', 'string', 'max:255', 'exists:users,username'],
            'placement' => ['required', 'string', 'max:255', 'exists:users,username'],
            'placement_direction' => ['required', 'boolean'],
            'phone' => ['required', 'string', 'regex:/^01\d{9}$/'],
            'address' => ['required', 'string', 'max:255'],
            'fathers_name' => ['required', 'string', 'max:255'],
            'mothers_name' => ['required', 'string', 'max:255'],
            'nid_number' => ['required', 'string', 'max:255'],
            'nid_front' => ['required', 'file', 'image'],
            'nid_back' => ['required', 'file', 'image'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['referrer_id'] = User::where(['username' => $validated['referrer']])->first()->id;
        unset($validated['referrer']);

        $validated['placement_id'] = User::where(['username' => $validated['placement']])->first()->id;
        unset($validated['placement']);

        if (!$this->checkBloodLine($validated['referrer_id'], $validated['placement_id'])) {
            throw ValidationException::withMessages([
                'placement' => 'Invalid placement.',
            ]);
        }

        $validated['placement_id'] = $this->findFreePlace($validated['placement_id'], $validated['placement_direction']);

        $validated['status'] = UserStatus::Inactive;

        $user = User::create($validated);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    private function findFreePlace($referrerId, $direction)
    {
        $placementId = $referrerId;
        while ($cursor = User::where(['placement_id' => $placementId, 'placement_direction' => $direction])->value('id')) {
            $placementId = $cursor;
        }
        return $placementId;
    }

    private function checkBloodLine($grandParent, $child)
    {
        if ($grandParent == $child) return true;
        $cursor = $child;
        while ($cursor = User::where(['id' => $cursor])->value('placement_id')) {
            if ($cursor == $grandParent) return true;
        }
        return false;
    }
}
