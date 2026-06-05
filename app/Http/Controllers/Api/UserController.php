<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    // Semua user
    public function index()
    {
        return response()->json(User::all());
    }

    // Detail user by ID
    public function show($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        return response()->json($user);
    }

    // Register user baru
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|string|email|unique:users,email',
            'password'      => 'required|string|min:6',
            'no_telp'       => 'nullable|string|max:20',
            'nik'           => 'nullable|string|max:20|unique:users,nik',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'role'          => 'user', // default otomatis
            'no_telp'       => $validated['no_telp'] ?? null,
            'nik'           => $validated['nik'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
        ]);

        return response()->json([
            'message' => 'User berhasil dibuat',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Hapus semua token lama biar single login
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('flutter-login')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }

    /**
     * STEP A — Ganti password (user sedang login, dari menu Setting)
     */
    public function requestPasswordChange(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah'], 400);
        }

        // buat token unik
        $token = Str::random(64);
        $user->reset_token = $token;
        $user->save();

        // kirim email ke user
        $resetUrl = url("/reset-password/$token");
        Mail::send('emails.change_password', [
            'url' => $resetUrl,
            'user' => $user
        ], function ($m) use ($user) {
            $m->to($user->email)->subject('Ubah Password Akun Anda');
        });

        return response()->json([
            'success' => true,
            'message' => 'Link ganti password telah dikirim ke email Anda'
        ]);
    }

    /**
     * STEP B — Lupa password (tidak login)
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Email tidak ditemukan'], 404);
        }

        // buat token
        $token = Str::random(64);
        $user->reset_token = $token;
        $user->save();

        // kirim email
        $resetUrl = url("/reset-password/$token");
        Mail::send('emails.forgot_password', [
            'url' => $resetUrl,
            'user' => $user
        ], function ($m) use ($user) {
            $m->to($user->email)->subject('Atur Ulang Password Anda');
        });

        return response()->json(['success' => true, 'message' => 'Link reset password telah dikirim ke email Anda.']);
    }

    /**
     * STEP C — Form ganti/reset password (akses dari email)
     */
    public function showResetPasswordForm($token)
    {
        $user = User::where('reset_token', $token)->first();

        if (! $user) {
            return response()->view('auth.token-invalid');
        }

        return response()->view('auth.reset_password', ['token' => $token]);
    }

    /**
     * STEP D — Simpan password baru (semua alur pakai ini)
     */
    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('reset_token', $token)->first();

        if (! $user) {
            return view('auth.token_invalid');
        }

        $user->password = Hash::make($request->new_password);
        $user->reset_token = null;
        $user->save();

        // Langsung tampilkan halaman sukses
        return view('auth.password-sukses', [
            'status' => 'Password berhasil diubah! Silakan login dengan password baru.'
        ]);
    }
}
