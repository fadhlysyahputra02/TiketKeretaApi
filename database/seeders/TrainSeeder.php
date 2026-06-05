<?php

namespace Database\Seeders;

use App\Models\Train;
use App\Models\Carriage;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    public function run(): void
    {
        $trains = [
            [
                'code' => 'ABA',
                'name' => 'Argo Bromo Anggrek',
                'service_class' => 'Eksekutif',
                'carriage_count' => 8,
                'type' => 'Jarak Jauh',
                'carriages' => [
                    ['code' => 'ABA-E1', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 1],
                    ['code' => 'ABA-E2', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 2],
                    ['code' => 'ABA-E3', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 3],
                ]
            ],
            [
                'code' => 'AGS',
                'name' => 'Argo Semeru',
                'service_class' => 'Eksekutif',
                'carriage_count' => 8,
                'type' => 'Jarak Jauh',
                'carriages' => [
                    ['code' => 'AGS-E1', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 1],
                    ['code' => 'AGS-E2', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 2],
                ]
            ],
            [
                'code' => 'AGW',
                'name' => 'Argo Wilis',
                'service_class' => 'Eksekutif',
                'carriage_count' => 6,
                'type' => 'Jarak Jauh',
                'carriages' => [
                    ['code' => 'AGW-E1', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 1],
                    ['code' => 'AGW-E2', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 2],
                ]
            ],
            [
                'code' => 'GBM',
                'name' => 'Gajayana',
                'service_class' => 'Eksekutif',
                'carriage_count' => 8,
                'type' => 'Jarak Jauh',
                'carriages' => [
                    ['code' => 'GBM-E1', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 1],
                    ['code' => 'GBM-E2', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 2],
                ]
            ],
            [
                'code' => 'TXB',
                'name' => 'Taksaka',
                'service_class' => 'Eksekutif',
                'carriage_count' => 8,
                'type' => 'Jarak Jauh',
                'carriages' => [
                    ['code' => 'TXB-E1', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 1],
                    ['code' => 'TXB-B1', 'class' => 'Bisnis', 'seat_count' => 64, 'order' => 2],
                ]
            ],
            [
                'code' => 'BRM',
                'name' => 'Bima',
                'service_class' => 'Eksekutif',
                'carriage_count' => 10,
                'type' => 'Jarak Jauh',
                'carriages' => [
                    ['code' => 'BRM-E1', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 1],
                    ['code' => 'BRM-E2', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 2],
                    ['code' => 'BRM-B1', 'class' => 'Bisnis', 'seat_count' => 64, 'order' => 3],
                ]
            ],
            [
                'code' => 'MUT',
                'name' => 'Mutiara Selatan',
                'service_class' => 'Bisnis',
                'carriage_count' => 8,
                'type' => 'Jarak Jauh',
                'carriages' => [
                    ['code' => 'MUT-B1', 'class' => 'Bisnis', 'seat_count' => 64, 'order' => 1],
                    ['code' => 'MUT-B2', 'class' => 'Bisnis', 'seat_count' => 64, 'order' => 2],
                ]
            ],
            [
                'code' => 'KMT',
                'name' => 'Kamandaka',
                'service_class' => 'Bisnis',
                'carriage_count' => 6,
                'type' => 'Jarak Menengah',
                'carriages' => [
                    ['code' => 'KMT-B1', 'class' => 'Bisnis', 'seat_count' => 64, 'order' => 1],
                    ['code' => 'KMT-E1', 'class' => 'Eksekutif', 'seat_count' => 50, 'order' => 2],
                ]
            ],
            [
                'code' => 'PRM',
                'name' => 'Prambanan Ekspres',
                'service_class' => 'Ekonomi',
                'carriage_count' => 6,
                'type' => 'Lokal',
                'carriages' => [
                    ['code' => 'PRM-K1', 'class' => 'Ekonomi', 'seat_count' => 80, 'order' => 1],
                    ['code' => 'PRM-K2', 'class' => 'Ekonomi', 'seat_count' => 80, 'order' => 2],
                ]
            ],
            [
                'code' => 'KLJ',
                'name' => 'Kali Jaga',
                'service_class' => 'Ekonomi',
                'carriage_count' => 5,
                'type' => 'Lokal',
                'carriages' => [
                    ['code' => 'KLJ-K1', 'class' => 'Ekonomi', 'seat_count' => 80, 'order' => 1],
                    ['code' => 'KLJ-K2', 'class' => 'Ekonomi', 'seat_count' => 80, 'order' => 2],
                ]
            ],
        ];

        foreach ($trains as $trainData) {
            $carriagesData = $trainData['carriages'];
            unset($trainData['carriages']);

            $train = Train::updateOrCreate(['code' => $trainData['code']], $trainData);

            // Hapus carriage lama biar tidak duplikat
            $train->carriages()->delete();

            foreach ($carriagesData as $carriageData) {
                $seatCount = $carriageData['seat_count'];
                $carriage = $train->carriages()->create($carriageData);

                // Generate kursi otomatis
                $seats = [];
                $rows = range('A', 'Z');
                $seatNum = 1;
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
        }
    }
}