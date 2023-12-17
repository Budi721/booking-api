<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{

    public function index(Request $request) {
        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'phone' => ['required', 'numeric'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('phone', 'password');

        $user = User::where('phone', $request->phone)
            ->first();

        if (Auth::attempt($credentials)) {
            return response()->json([
                'access_token' => $user->createToken('client')->plainTextToken,
            ]);
        }

        return response()->json([
            'access_token' => null
        ], 401);
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['string', 'max:255'],
            'sim_number' => ['string', 'max:255'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['required', Rule::in(Role::ROLE_OWNER, Role::ROLE_USER)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'sim_number' => $request->sim_number,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'access_token' => $user->createToken('client')->plainTextToken,
        ]);
    }
}
