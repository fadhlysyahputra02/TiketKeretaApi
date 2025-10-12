<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    // === 1. Kirim email reset password ===
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }

        // buat token unik dan simpan di tabel password_resets
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // URL reset password
        $url = url("/reset-password?token={$token}&email={$user->email}");

        // kirim email
        Mail::send('emails.reset_password', ['user' => $user, 'url' => $url], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Password Anda - Kereta Access');
        });

        return response()->json(['message' => 'Tautan reset password telah dikirim ke email Anda.']);
    }

    // === 2. Tampilkan form reset password ===
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return view('auth.reset_password', compact('token', 'email'));
    }

    // === 3. Proses reset password ===
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (! $reset) {
            return response()->json(['message' => 'Token tidak valid atau sudah kedaluwarsa.'], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan.'], 404);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('password.success');
    }
}
