<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Train;
use App\Models\Carriage;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TrainController extends Controller
{
    public function index()
    {
        // Tampilkan train beserta relasi carriages dan seats
        return Train::with(['carriages.seats'])->get();
    }

    public function show($id)
    {
        return Train::with(['carriages.seats'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:trains,code',
            'name' => 'required|string',
            'service_class' => 'required|string',
            'carriage_count' => 'required|integer|min:1',
            'type' => 'required|in:lokal,AK',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $train = DB::transaction(function () use ($request) {
                // 1. Buat Train
                $train = Train::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'service_class' => $request->service_class,
                    'carriage_count' => $request->carriage_count,
                    'type' => $request->type,
                ]);

                // 2. Tentukan prefix kode gerbong dan jumlah kursi berdasarkan service_class
                $serviceClass = strtolower($request->service_class);
                $prefix = 'E'; // Default Eksekutif
                $seatCount = 50; // Default

                if (str_contains($serviceClass, 'ekonomi')) {
                    $prefix = 'K';
                    $seatCount = 80;
                } elseif (str_contains($serviceClass, 'bisnis')) {
                    $prefix = 'B';
                    $seatCount = 64;
                } elseif (str_contains($serviceClass, 'luxury') || str_contains($serviceClass, 'eksekutif')) {
                    $prefix = 'E';
                    $seatCount = 50;
                }

                // 3. Buat gerbong & kursi otomatis sebanyak carriage_count
                for ($order = 1; $order <= $request->carriage_count; $order++) {
                    $carriageCode = "{$request->code}-{$prefix}{$order}";
                    
                    $carriage = $train->carriages()->create([
                        'code' => $carriageCode,
                        'class' => $request->service_class,
                        'seat_count' => $seatCount,
                        'order' => $order,
                    ]);

                    // Generate seats untuk gerbong ini
                    $seats = [];
                    $rows = range('A', 'Z');
                    for ($i = 0; $i < $seatCount; $i++) {
                        $row = $rows[floor($i / 4)];
                        $col = ($i % 4) + 1;
                        $position = in_array($col, [1, 4]) ? 'window' : 'aisle';
                        
                        $seats[] = [
                            'carriage_id'  => $carriage->id,
                            'seat_number'  => $row . $col,
                            'position'     => $position,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ];
                    }
                    Seat::insert($seats);
                }

                return $train;
            });

            return response()->json([
                'success' => true,
                'message' => 'Train, gerbong, dan kursi berhasil dibuat secara otomatis!',
                'data' => $train->load(['carriages.seats'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat data train otomatis: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $train = Train::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'code' => 'string|unique:trains,code,' . $id,
            'name' => 'string',
            'service_class' => 'string',
            'carriage_count' => 'integer|min:1',
            'type' => 'nullable|in:lokal,AK',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $train->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Train berhasil diperbarui!',
            'data' => $train->load(['carriages.seats'])
        ]);
    }

    public function destroy($id)
    {
        $train = Train::findOrFail($id);
        $train->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Train berhasil dihapus'
        ]);
    }
}

