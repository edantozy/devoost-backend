<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken($request->device_name, [])->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $token = $user->createToken($request->device_name, [])->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // $token = Str::random(64);

        // DB::table('password_resets')->where('email', $request->email)->delete();

        // DB::table('password_resets')->insert([
        //     'email' => $request->email,
        //     'token' => hash('sha256', $token),
        //     'created_at' => Carbon::now()
        // ]);

        // Mail::to($user->email)->send(new PasswordRecoveryMail($token, $user->email));

        return response()->json(['message' => 'Password recovery email sent'], 200);
    }
}
