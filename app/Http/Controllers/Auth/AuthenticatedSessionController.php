<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login (pakai kolom 'name')
     */
    public function store(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'name' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->role) {
            Auth::logout();
            return back()->withErrors([
                'name' => 'Akun ini tidak memiliki role. Hubungi Super Admin.',
            ]);
        }

        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        Auth::logout();
        abort(403);
    }

    return back()->withErrors([
        'name' => 'Username atau password salah.',
    ])->onlyInput('name');
}


    /**
     * Logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
