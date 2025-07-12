<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $provinces = [
            ['name' => 'Aceh'],
            ['name' => 'Sumatera Utara'],
            ['name' => 'Sumatera Barat'],
            ['name' => 'Riau'],
            ['name' => 'Kepulauan Riau'],
            ['name' => 'Jambi'],
            ['name' => 'Bengkulu'],
            ['name' => 'Sumatera Selatan'],
            ['name' => 'Kepulauan Bangka Belitung'],
            ['name' => 'Lampung'],
            ['name' => 'Banten'],
            ['name' => 'DKI Jakarta'],
            ['name' => 'Jawa Barat'],
            ['name' => 'Jawa Tengah'],
            ['name' => 'DI Yogyakarta'],
            ['name' => 'Jawa Timur'],
            ['name' => 'Bali'],
            ['name' => 'Nusa Tenggara Barat'],
            ['name' => 'Nusa Tenggara Timur'],
            ['name' => 'Kalimantan Barat'],
            ['name' => 'Kalimantan Tengah'],
            ['name' => 'Kalimantan Selatan'],
            ['name' => 'Kalimantan Timur'],
            ['name' => 'Kalimantan Utara'],
            ['name' => 'Sulawesi Utara'],
            ['name' => 'Gorontalo'],
            ['name' => 'Sulawesi Tengah'],
            ['name' => 'Sulawesi Barat'],
            ['name' => 'Sulawesi Selatan'],
            ['name' => 'Sulawesi Tenggara'],
            ['name' => 'Maluku'],
            ['name' => 'Maluku Utara'],
            ['name' => 'Papua Barat'],
            ['name' => 'Papua'],
            ['name' => 'Papua Selatan'],
			['name' => 'Papua Tengah'],
			['name' => 'Papua Pegunungan'],
			['name' => 'Papua Barat Daya'],
        ];

        DB::table('provinces')->insert($provinces);
    }
}
