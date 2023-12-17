<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{

    public function admin_register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'sim_number' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'sim_number' => $request->sim_number,
                'password' => Hash::make($request->password),
                'role_id' => Role::ROLE_ADMINISTRATOR,
            ]);

            return response()->json(
                ['message' => 'Registration successful', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Registration failed. Please try again.'],
                500
            );
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'sim_number' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required'],
            'role_id' => ['required', Rule::in([Role::ROLE_OWNER, Role::ROLE_USER])],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'sim_number' => $request->sim_number,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);

            return response()->json(['message' => 'Registration successful', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed. Please try again.'], 500);
        }
    }
}
