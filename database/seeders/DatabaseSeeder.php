namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProvinceSeeder::class,    // Provinces harus pertama
            CitySeeder::class,        // Cities kedua (karena bergantung pada provinces)
            CsrCategorySeeder::class, // CSR Categories ketiga
            CsrIndicatorSeeder::class, // CSR Indicators terakhir (karena bergantung pada categories)
            MockDataSeeder::class,  // Sudah diaktifkan untuk menjalankan mock data seeder
        ]);

        App\Models\User::where('email', 'pemantau@example.com')->first();
    }
}