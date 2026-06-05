<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PesanController extends Controller
{
    /**
     * Konversi nilai jenis_kelamin dari Flutter ('Laki-laki'/'Perempuan')
     * ke format enum database ('L'/'P').
     */
    private function normalizeJenisKelamin(?string $value): ?string
    {
        if ($value === null) return null;

        $lower = strtolower(trim($value));

        if (in_array($lower, ['l', 'laki-laki', 'laki', 'male'])) {
            return 'L';
        }
        if (in_array($lower, ['p', 'perempuan', 'wanita', 'female'])) {
            return 'P';
        }

        return $value; // kembalikan aslinya jika tidak dikenali
    }

    public function store(Request $request)
    {
        // Validasi data permintaan
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'trip_id' => 'required|integer|exists:trips,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'from_station' => 'required|string',
            'to_station' => 'required|string',
            'seat_id' => 'required|integer|exists:seats,id',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.nik' => 'required|string|max:20',
            'passengers.*.jenis_kelamin' => 'required|string|max:10',
            'passengers.*.tanggal_lahir' => 'required|date',
            'passengers.*.seat_id' => 'required|integer|exists:seats,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        try {

            // Generate kode PNR unik
            $pnr = strtoupper(Str::random(6));

            // Buat booking baru dengan menyertakan seat_id
            $booking = Booking::create([
                'pnr' => $pnr,
                'user_id' => $request->user_id,
                'trip_id' => $request->trip_id,
                'departure_date' => $request->departure_date,
                'status' => 'PENDING',
                'seat_id' => $request->seat_id,
                'from_station' => $request->from_station ?? null, // ambil dari request
                'to_station' => $request->to_station ?? null,
            ]);

            // Simpan semua penumpang melalui relasi booking
            foreach ($request->passengers as $p) {
                // Konversi jenis_kelamin sebelum insert
                $p['jenis_kelamin'] = $this->normalizeJenisKelamin($p['jenis_kelamin'] ?? null);
                $booking->passengers()->create($p);
            }

            return response()->json([
                'message' => 'Pemesanan berhasil dibuat!',
                'booking' => $booking->load('passengers'), // sertakan data penumpang
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat membuat pemesanan. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function confirm($id)
    {
        // Cari booking berdasarkan ID
        $booking = Booking::findOrFail($id);

        // Ubah status booking
        $booking->status = 'CONFIRMED';
        $booking->save();

        // Update status semua penumpang booking
        $booking->passengers()->update(['status' => 'CONFIRMED']); // pastikan kolom 'status' ada di tabel passengers

        return response()->json([
            'message' => 'Booking dan semua penumpang berhasil dikonfirmasi',
            'booking' => $booking->load('passengers') // sertakan data penumpang
        ]);
    }

    // PesanController.php
    public function addPassenger($bookingId, Request $request)
    {
        $booking = Booking::findOrFail($bookingId);

        $passenger = $booking->passengers()->create([
            'name' => $request->name,
            'nik' => $request->nik,
            'jenis_kelamin' => $this->normalizeJenisKelamin($request->jenis_kelamin),
            'tanggal_lahir' => $request->tanggal_lahir,
            'seat_id' => $request->seat_id,
        ]);

        return response()->json([
            'message' => 'Penumpang berhasil ditambahkan',
            'id' => $passenger->id, // ✅ penting!
            'passenger' => $passenger, // opsional, untuk debugging / info tambahan
        ]);
    }
}

