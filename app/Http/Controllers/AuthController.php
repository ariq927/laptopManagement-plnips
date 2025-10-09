<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('content.authentications.auth-login-basic');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $ldapApiUrl = env('LDAP_API_URL');

        try {
            $response = Http::asForm()->withoutVerifying()->post($ldapApiUrl, [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            \Log::info('LDAP Response:', [
                'status_code' => $response->status(),
                'body' => $response->body(),
            ]);

            $data = json_decode($response->body(), true);

            if ($response->successful() && isset($data['message']) && strtolower($data['message']) === 'success') {
                $ldapUser = $data['datas'] ?? null;

                $user = User::firstOrCreate(
                    ['username' => $request->username],
                    [
                        'name' => $ldapUser['displayName'] ?? $request->username,
                        'email' => $ldapUser['mail'] ?? $request->username.'@example.com',
                        'password' => Hash::make($request->password) 
                    ]
                );

                Auth::login($user); 
                session(['ldap_user' => $ldapUser]);

                return redirect()->route('dashboard');
            }

            $errorMessage = $data['message'] ?? 'Username atau password salah.';
            return back()->withErrors(['username' => 'Login gagal: ' . $errorMessage])->withInput();

        } catch (\Exception $e) {
            return back()->withErrors([
                'username' => 'Terjadi kesalahan koneksi ke server LDAP: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/login');
    }
}
