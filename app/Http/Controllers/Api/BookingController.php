<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Passenger;
use Illuminate\Support\Facades\Validator;
use App\Models\Seat;
use App\Models\Trip;

class BookingController extends Controller
{
    /**
     * Buat pesanan tiket
     */

    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil semua booking milik user tersebut
        $bookings = Booking::with([
            'trip.train',
            'seat.carriage',
        ])
            ->where('user_id', $user->id) // filter berdasarkan user_id
            ->get();

        return response()->json($bookings);
    }

    public function passengers($id)
    {
        $booking = Booking::with('passengers.seat.carriage')->findOrFail($id);

        return response()->json($booking->passengers);
    }

    public function store(Request $request)
    {
        // Validasi input data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'trip_id' => 'required|integer|exists:trips,id',
            'departure_date' => 'required|date',
            'seat_id' => 'required|integer|exists:seats,id',
            'from_station' => 'required|string',
            'to_station' => 'required|string',
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

        // Menyimpan booking
        try {
            $trip = Trip::find($request->trip_id); // ambil trip dulu

            $booking = Booking::create([
                'user_id' => $request->user_id,
                'trip_id' => $request->trip_id,
                'departure_date' => $request->departure_date,
                'status' => 'pending',
                'seat_id' => $request->seat_id,
                'from_station' => $request->from_station, // ✅ dari Flutter
                'to_station' => $request->to_station,     // ✅ dari Flutter
            ]);

            // Menyimpan data penumpang
            foreach ($request->passengers as $passengerData) {
                Passenger::create([
                    'name' => $passengerData['name'],
                    'nik' => $passengerData['nik'],
                    'jenis_kelamin' => $passengerData['jenis_kelamin'],
                    'tanggal_lahir' => $passengerData['tanggal_lahir'],
                    'booking_id' => $booking->id,
                    'seat_id' => $passengerData['seat_id'],  // Menyimpan seat_id untuk setiap penumpang
                ]);
            }

            return response()->json([
                'message' => 'Booking berhasil dibuat!',
                'booking' => $booking,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat membuat booking. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'origin_id' => 'required|exists:stations,id',
            'destination_id' => 'required|exists:stations,id|different:origin_id',
            'departure_date' => 'required|date',
        ]);

        $originId = $request->origin_id;
        $destinationId = $request->destination_id;
        $date = $request->departure_date;

        $trips = Trip::with(['train', 'tripStations.station'])
            ->whereHas('tripStations', fn($q) => $q->where('station_id', $originId))
            ->whereHas('tripStations', fn($q) => $q->where('station_id', $destinationId))
            ->get()
            ->filter(function ($trip) use ($originId, $destinationId) {
                $originOrder = $trip->tripStations->firstWhere('station_id', $originId)?->station_order;
                $destOrder   = $trip->tripStations->firstWhere('station_id', $destinationId)?->station_order;
                return $originOrder !== null && $destOrder !== null && $originOrder < $destOrder;
            })
            ->values();


        return response()->json([
            'success' => true,
            'message' => 'Hasil pencarian trip',
            'data' => $trips,
        ]);
    }


    /**
     * Lihat detail booking
     */
    public function show($id)
    {
        $booking = Booking::with([
            'trip.train',
            'tickets.passenger',
            'tickets.seat.carriage'
        ])->findOrFail($id);

        // hanya pemilik booking yang bisa lihat
        if ($booking->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($booking);
    }

    /**
     * Daftar booking user login
     */
    public function myBookings()
    {
        // Ambil user yang login
        $userId = Auth::id();

        // Ambil semua booking user beserta relasi trip, seat, passenger
        $bookings = Booking::with([
            'trip.train',
            'passengers',       // relasi passengers
            'seat.carriage'     // relasi seat dan carriage
        ])->where('user_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings,
        ]);
    }

    public function checkBookedSeats(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|integer',
            'departure_date' => 'required|date',
        ]);

        $bookedSeats = \App\Models\Booking::where('trip_id', $request->trip_id)
            ->where('departure_date', $request->departure_date)
            ->pluck('seat_id');

        return response()->json([
            'success' => true,
            'booked_seats' => $bookedSeats,
        ]);
    }
}
