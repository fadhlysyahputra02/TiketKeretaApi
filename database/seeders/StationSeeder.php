<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            ['code'=>'GMR','name'=>'Gambir','city'=>'Jakarta','lat'=>-6.1763,'lng'=>106.8306],
            ['code'=>'PSE','name'=>'Pasar Senen','city'=>'Jakarta','lat'=>-6.1714,'lng'=>106.8451],
            ['code'=>'JNG','name'=>'Jatinegara','city'=>'Jakarta','lat'=>-6.2153,'lng'=>106.8720],
            ['code'=>'MRI','name'=>'Manggarai','city'=>'Jakarta','lat'=>-6.2097,'lng'=>106.8502],
            ['code'=>'THB','name'=>'Tanah Abang','city'=>'Jakarta','lat'=>-6.1868,'lng'=>106.8198],
            ['code'=>'BKS','name'=>'Bekasi','city'=>'Bekasi','lat'=>-6.2416,'lng'=>106.9924],
            ['code'=>'BOO','name'=>'Bogor','city'=>'Bogor','lat'=>-6.5950,'lng'=>106.7950],
            ['code'=>'BD','name'=>'Bandung','city'=>'Bandung','lat'=>-6.9147,'lng'=>107.6098],
            ['code'=>'KAC','name'=>'Kiaracondong','city'=>'Bandung','lat'=>-6.9275,'lng'=>107.6431],
            ['code'=>'CB','name'=>'Cirebon','city'=>'Cirebon','lat'=>-6.7320,'lng'=>108.5523],
            ['code'=>'CNB','name'=>'Cirebon Prujakan','city'=>'Cirebon','lat'=>-6.7406,'lng'=>108.5508],
            ['code'=>'PWT','name'=>'Purwokerto','city'=>'Purwokerto','lat'=>-7.4240,'lng'=>109.2396],
            ['code'=>'KTE','name'=>'Kroya','city'=>'Cilacap','lat'=>-7.6333,'lng'=>109.2500],
            ['code'=>'KTA','name'=>'Kutoarjo','city'=>'Purworejo','lat'=>-7.7167,'lng'=>109.9167],
            ['code'=>'YK','name'=>'Yogyakarta','city'=>'Yogyakarta','lat'=>-7.7897,'lng'=>110.3647],
            ['code'=>'LPN','name'=>'Lempuyangan','city'=>'Yogyakarta','lat'=>-7.7853,'lng'=>110.3756],
            ['code'=>'SLO','name'=>'Solo Balapan','city'=>'Surakarta','lat'=>-7.5583,'lng'=>110.8278],
            ['code'=>'PWS','name'=>'Purwosari','city'=>'Surakarta','lat'=>-7.5667,'lng'=>110.8000],
            ['code'=>'SMT','name'=>'Semarang Tawang','city'=>'Semarang','lat'=>-6.9667,'lng'=>110.4167],
            ['code'=>'SMC','name'=>'Semarang Poncol','city'=>'Semarang','lat'=>-6.9750,'lng'=>110.4083],
            ['code'=>'KD','name'=>'Kediri','city'=>'Kediri','lat'=>-7.8167,'lng'=>112.0167],
            ['code'=>'MLO','name'=>'Malang','city'=>'Malang','lat'=>-7.9839,'lng'=>112.6214],
            ['code'=>'ML','name'=>'Malang Kotalama','city'=>'Malang','lat'=>-8.0000,'lng'=>112.6333],
            ['code'=>'SGU','name'=>'Surabaya Gubeng','city'=>'Surabaya','lat'=>-7.2653,'lng'=>112.7522],
            ['code'=>'SBI','name'=>'Surabaya Pasar Turi','city'=>'Surabaya','lat'=>-7.2456,'lng'=>112.7317],
            ['code'=>'SBK','name'=>'Surabaya Kota','city'=>'Surabaya','lat'=>-7.2575,'lng'=>112.7378],
            ['code'=>'WR','name'=>'Wonokromo','city'=>'Surabaya','lat'=>-7.2983,'lng'=>112.7317],
            ['code'=>'SDR','name'=>'Sidoarjo','city'=>'Sidoarjo','lat'=>-7.4467,'lng'=>112.7183],
            ['code'=>'JR','name'=>'Jember','city'=>'Jember','lat'=>-8.1724,'lng'=>113.7003],
            ['code'=>'BW','name'=>'Banyuwangi Baru','city'=>'Banyuwangi','lat'=>-8.2192,'lng'=>114.3691],
            ['code'=>'KTS','name'=>'Ketapang','city'=>'Banyuwangi','lat'=>-8.1667,'lng'=>114.3833],
            ['code'=>'PB','name'=>'Probolinggo','city'=>'Probolinggo','lat'=>-7.7569,'lng'=>113.2115],
            ['code'=>'PS','name'=>'Pasuruan','city'=>'Pasuruan','lat'=>-7.6333,'lng'=>112.9000],
            ['code'=>'MN','name'=>'Mojokerto','city'=>'Mojokerto','lat'=>-7.4667,'lng'=>112.4333],
            ['code'=>'BJN','name'=>'Bojonegoro','city'=>'Bojonegoro','lat'=>-7.1500,'lng'=>111.8833],
            ['code'=>'KNG','name'=>'Kertosono','city'=>'Nganjuk','lat'=>-7.6000,'lng'=>112.1000],
            ['code'=>'MR','name'=>'Madiun','city'=>'Madiun','lat'=>-7.6297,'lng'=>111.5239],
            ['code'=>'NGW','name'=>'Ngawi','city'=>'Ngawi','lat'=>-7.4000,'lng'=>111.4500],
            ['code'=>'SRO','name'=>'Sragen','city'=>'Sragen','lat'=>-7.4333,'lng'=>111.0167],
            ['code'=>'KLT','name'=>'Klaten','city'=>'Klaten','lat'=>-7.7000,'lng'=>110.6000],
            ['code'=>'WJ','name'=>'Wojo','city'=>'Purworejo','lat'=>-7.7500,'lng'=>110.0333],
            ['code'=>'TG','name'=>'Tegal','city'=>'Tegal','lat'=>-6.8686,'lng'=>109.1400],
            ['code'=>'PK','name'=>'Pekalongan','city'=>'Pekalongan','lat'=>-6.8833,'lng'=>109.6667],
            ['code'=>'WL','name'=>'Weleri','city'=>'Kendal','lat'=>-6.9667,'lng'=>110.1000],
            ['code'=>'BJR','name'=>'Banjar','city'=>'Banjar','lat'=>-7.3667,'lng'=>108.5333],
            ['code'=>'TSM','name'=>'Tasikmalaya','city'=>'Tasikmalaya','lat'=>-7.3500,'lng'=>108.2167],
            ['code'=>'GC','name'=>'Garut','city'=>'Garut','lat'=>-7.2167,'lng'=>107.9000],
            ['code'=>'CWL','name'=>'Ciamis','city'=>'Ciamis','lat'=>-7.3333,'lng'=>108.3500],
            ['code'=>'SKB','name'=>'Sukabumi','city'=>'Sukabumi','lat'=>-6.9271,'lng'=>106.9299],
            ['code'=>'CJR','name'=>'Cianjur','city'=>'Cianjur','lat'=>-6.8167,'lng'=>107.1333],
        ];

        foreach ($stations as $data) {
            Station::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}