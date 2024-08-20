<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('Personal_Access_Token')->plainTextToken;
            Log::info($token);

            return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['registration' => 'An error occurred while registering. Please try again.'])->withInput();
        }
    }


    public function login(Request $request)
    {
        Log::info($request);
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('Personal_Access_Token')->plainTextToken;
            Log::info('User token:', ['token' => $token]);
            return redirect()->intended('/')->with('success', 'Login successful!');
        }
        return back()->withErrors([
            'login' => 'Invalid credentials. Please check your email and password.',
        ])->withInput();
    }

    public function logout(Request $request)
{
    $user = Auth::user();
    if ($user) {
        $user->tokens()->delete();
        Auth::logout();
    }
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    $request->session()->flash('success', 'You have been logged out successfully.');
    return redirect()->route('login');
}

}
