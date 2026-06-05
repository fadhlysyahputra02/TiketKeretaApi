<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\Train;
use App\Models\Station;
use App\Models\TripStation;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $s = fn($code) => Station::where('code', $code)->first()?->id;
        $t = fn($code) => Train::where('code', $code)->first()?->id;

        $trips = [
            [
                'train_code'     => 'ABA',
                'departure_time' => '2026-01-01 09:00:00',
                'arrival_time'   => '2026-01-01 16:30:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'GMR', 'arrival'=>null,                  'departure'=>'09:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'CB',  'arrival'=>'10:30:00',            'departure'=>'10:35:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'SMT', 'arrival'=>'12:45:00',            'departure'=>'12:55:00', 'order'=>3, 'day_offset'=>0],
                    ['code'=>'SBI', 'arrival'=>'16:30:00',            'departure'=>null,       'order'=>4, 'day_offset'=>0],
                ]
            ],
            [
                'train_code'     => 'AGS',
                'departure_time' => '2026-01-01 15:00:00',
                'arrival_time'   => '2026-01-01 23:30:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'GMR', 'arrival'=>null,        'departure'=>'15:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'CB',  'arrival'=>'16:30:00',  'departure'=>'16:35:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'SMT', 'arrival'=>'18:45:00',  'departure'=>'18:55:00', 'order'=>3, 'day_offset'=>0],
                    ['code'=>'SGU', 'arrival'=>'23:30:00',  'departure'=>null,       'order'=>4, 'day_offset'=>0],
                ]
            ],
            [
                'train_code'     => 'AGW',
                'departure_time' => '2026-01-01 07:00:00',
                'arrival_time'   => '2026-01-01 17:30:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'BD',  'arrival'=>null,        'departure'=>'07:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'YK',  'arrival'=>'11:00:00',  'departure'=>'11:10:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'MR',  'arrival'=>'13:00:00',  'departure'=>'13:10:00', 'order'=>3, 'day_offset'=>0],
                    ['code'=>'KD',  'arrival'=>'14:30:00',  'departure'=>'14:40:00', 'order'=>4, 'day_offset'=>0],
                    ['code'=>'SGU', 'arrival'=>'17:30:00',  'departure'=>null,       'order'=>5, 'day_offset'=>0],
                ]
            ],
            [
                'train_code'     => 'GBM',
                'departure_time' => '2026-01-01 17:00:00',
                'arrival_time'   => '2026-01-02 05:30:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'GMR', 'arrival'=>null,        'departure'=>'17:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'PSE', 'arrival'=>'17:15:00',  'departure'=>'17:20:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'SMT', 'arrival'=>'21:00:00',  'departure'=>'21:10:00', 'order'=>3, 'day_offset'=>0],
                    ['code'=>'SGU', 'arrival'=>'00:30:00',  'departure'=>'00:40:00', 'order'=>4, 'day_offset'=>1],
                    ['code'=>'MLO', 'arrival'=>'05:30:00',  'departure'=>null,       'order'=>5, 'day_offset'=>1],
                ]
            ],
            [
                'train_code'     => 'TXB',
                'departure_time' => '2026-01-01 08:00:00',
                'arrival_time'   => '2026-01-01 13:30:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'GMR', 'arrival'=>null,        'departure'=>'08:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'CB',  'arrival'=>'09:30:00',  'departure'=>'09:35:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'PWT', 'arrival'=>'11:15:00',  'departure'=>'11:20:00', 'order'=>3, 'day_offset'=>0],
                    ['code'=>'YK',  'arrival'=>'13:30:00',  'departure'=>null,       'order'=>4, 'day_offset'=>0],
                ]
            ],
            [
                'train_code'     => 'BRM',
                'departure_time' => '2026-01-01 17:00:00',
                'arrival_time'   => '2026-01-02 05:00:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'GMR', 'arrival'=>null,        'departure'=>'17:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'PSE', 'arrival'=>'17:15:00',  'departure'=>'17:20:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'YK',  'arrival'=>'21:30:00',  'departure'=>'21:40:00', 'order'=>3, 'day_offset'=>0],
                    ['code'=>'SLO', 'arrival'=>'22:15:00',  'departure'=>'22:25:00', 'order'=>4, 'day_offset'=>0],
                    ['code'=>'SGU', 'arrival'=>'05:00:00',  'departure'=>null,       'order'=>5, 'day_offset'=>1],
                ]
            ],
            [
                'train_code'     => 'MUT',
                'departure_time' => '2026-01-01 16:00:00',
                'arrival_time'   => '2026-01-02 04:30:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'BD',  'arrival'=>null,        'departure'=>'16:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'TSM', 'arrival'=>'17:30:00',  'departure'=>'17:35:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'YK',  'arrival'=>'20:00:00',  'departure'=>'20:10:00', 'order'=>3, 'day_offset'=>0],
                    ['code'=>'MR',  'arrival'=>'22:00:00',  'departure'=>'22:10:00', 'order'=>4, 'day_offset'=>0],
                    ['code'=>'SGU', 'arrival'=>'04:30:00',  'departure'=>null,       'order'=>5, 'day_offset'=>1],
                ]
            ],
            [
                'train_code'     => 'KMT',
                'departure_time' => '2026-01-01 06:00:00',
                'arrival_time'   => '2026-01-01 09:30:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'PWT', 'arrival'=>null,        'departure'=>'06:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'TG',  'arrival'=>'07:30:00',  'departure'=>'07:35:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'SMT', 'arrival'=>'09:30:00',  'departure'=>null,       'order'=>3, 'day_offset'=>0],
                ]
            ],
            [
                'train_code'     => 'PRM',
                'departure_time' => '2026-01-01 06:30:00',
                'arrival_time'   => '2026-01-01 07:45:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'YK',  'arrival'=>null,        'departure'=>'06:30:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'KLT', 'arrival'=>'07:10:00',  'departure'=>'07:12:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'SLO', 'arrival'=>'07:45:00',  'departure'=>null,       'order'=>3, 'day_offset'=>0],
                ]
            ],
            [
                'train_code'     => 'KLJ',
                'departure_time' => '2026-01-01 07:00:00',
                'arrival_time'   => '2026-01-01 10:00:00',
                'status'         => 'active',
                'stations' => [
                    ['code'=>'SMT', 'arrival'=>null,        'departure'=>'07:00:00', 'order'=>1, 'day_offset'=>0],
                    ['code'=>'SRO', 'arrival'=>'08:30:00',  'departure'=>'08:35:00', 'order'=>2, 'day_offset'=>0],
                    ['code'=>'SLO', 'arrival'=>'10:00:00',  'departure'=>null,       'order'=>3, 'day_offset'=>0],
                ]
            ],
        ];

        foreach ($trips as $tripData) {
            $trainId = $t($tripData['train_code']);
            if (!$trainId) {
                $this->command->warn("Train {$tripData['train_code']} tidak ditemukan, skip.");
                continue;
            }

            $stationsData = $tripData['stations'];
            $originId     = $s($stationsData[0]['code']);
            $destId       = $s($stationsData[count($stationsData) - 1]['code']);
            $trainName    = Train::find($trainId)?->name;

            if (!$originId || !$destId) {
                $this->command->warn("Stasiun tidak ditemukan untuk trip {$tripData['train_code']}, skip.");
                continue;
            }

            $trip = Trip::updateOrCreate(
                [
                    'train_id'               => $trainId,
                    'origin_station_id'      => $originId,
                    'destination_station_id' => $destId,
                ],
                [
                    'train_name'     => $trainName,
                    'departure_time' => $tripData['departure_time'],
                    'arrival_time'   => $tripData['arrival_time'],
                    'status'         => $tripData['status'],
                    'day_offset'     => 0,
                ]
            );

            $trip->tripStations()->delete();

            foreach ($stationsData as $st) {
                $stationId = $s($st['code']);
                if (!$stationId) {
                    $this->command->warn("Stasiun {$st['code']} tidak ditemukan, skip.");
                    continue;
                }

                TripStation::create([
                    'trip_id'        => $trip->id,
                    'station_id'     => $stationId,
                    'station_name'   => Station::find($stationId)?->name,
                    'train_name'     => $trainName,
                    'arrival_time'   => $st['arrival'],
                    'departure_time' => $st['departure'],
                    'station_order'  => $st['order'],
                    'day_offset'     => $st['day_offset'],
                ]);
            }

            $this->command->info("Trip {$trainName} berhasil dibuat.");
        }
    }
}