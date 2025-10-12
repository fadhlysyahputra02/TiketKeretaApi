<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Train;
use App\Models\Booking; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class SeatController extends Controller
{
    public function getSeatsByTrain($trainId, Request $request)
    {
        $departureDate = $request->query('departure_date');
        $tripId = $request->query('trip_id');

        $train = Train::with(['carriages.seats'])->find($trainId);

        if (!$train) {
            return response()->json([
                'success' => false,
                'message' => 'Train not found'
            ], 404);
        }

        // Ambil seat_id yang sudah dibooking pada trip dan tanggal ini
        $bookedSeatIds = DB::table('bookings')
            ->where('trip_id', $tripId)
            ->where('departure_date', $departureDate)
            ->pluck('seat_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'message' => 'Daftar seats berhasil diambil',
            'data' => $train->carriages->map(function ($carriage) use ($bookedSeatIds) {
                return [
                    'carriage_id' => $carriage->id,
                    'carriage_code' => $carriage->code,
                    'class' => $carriage->class,
                    'order' => $carriage->order,
                    'seats' => $carriage->seats->map(function ($seat) use ($bookedSeatIds) {
                        return [
                            'seat_id' => $seat->id,
                            'seat_number' => $seat->seat_number,
                            'position' => $seat->position,
                            'is_booked' => in_array($seat->id, $bookedSeatIds), // ✅ tambahkan flag ini
                        ];
                    })
                ];
            })
        ]);
    }
}
