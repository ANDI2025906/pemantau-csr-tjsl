<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CsrCategory;

class CsrCategorySeeder extends Seeder  // Bukan extends Model
{
    public function run()
    {
        $categories = [
            [
                'code' => 'A',
                'name' => 'Lingkungan Hidup',
                'description' => 'Program CSR terkait pelestarian lingkungan dan pengelolaan dampak lingkungan'
            ],
            [
                'code' => 'B',
                'name' => 'Pengembangan Sosial dan Kemasyarakatan',
                'description' => 'Program pemberdayaan masyarakat dan pengembangan sosial'
            ],
            [
                'code' => 'C',
                'name' => 'Ketenagakerjaan dan K3',
                'description' => 'Program terkait kesejahteraan karyawan dan Keselamatan dan Kesehatan Kerja'
            ],
            [
                'code' => 'D',
                'name' => 'Tanggung Jawab Produk',
                'description' => 'Program terkait kualitas dan keamanan produk/jasa'
            ],
        ];

        foreach ($categories as $category) {
            CsrCategory::create($category);
        }
    }
}
