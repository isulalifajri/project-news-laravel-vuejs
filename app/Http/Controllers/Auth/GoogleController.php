<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cek apakah user sudah ada
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Kalau belum ada, buat user baru (first login)
            $user = User::create([
                'name'       => $googleUser->getName(),
                'email'      => $googleUser->getEmail(),
                'google_id'  => $googleUser->getId(),
                'avatar'     => $googleUser->getAvatar(),
                'password'   => bcrypt(str()->random(16)), 
                'first_login_at' => now(),
                'last_login_at'  => now(),
            ]);
        } else {
            // Kalau sudah ada, update last login aja
            $user->update([
                'last_login_at' => now(),
            ]);
        }


        // Login user
        Auth::login($user);

        return redirect('/'); // arahkan ke home atau dashboard
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
