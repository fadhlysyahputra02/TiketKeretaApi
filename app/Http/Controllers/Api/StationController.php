<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|string|unique:stations,code|max:10',
        'name' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'lat'  => 'nullable|numeric',
        'lng'  => 'nullable|numeric',
    ]);

    $station = Station::create($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Stasiun berhasil ditambahkan',
        'data'    => $station
    ], 201);
}
    // ambil semua stasiun
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Station::all()
        ]);
    }

    // ambil stasiun berdasarkan id
    public function show($id)
    {
        $station = Station::find($id);

        if (!$station) {
            return response()->json([
                'success' => false,
                'message' => 'Station not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $station
        ]);
    }
}
