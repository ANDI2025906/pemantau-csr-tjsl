<?php
namespace Database\Seeders;

use App\Models\CompanyProfile;
use App\Models\CsrAssessment;
use App\Models\CsrCategory;
use App\Models\CsrIndicator;
use App\Models\User;
use App\Models\Province;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MockDataSeeder extends Seeder
{
    public function run(): void
    {
        // Debug: Tampilkan beberapa data province dan city yang tersedia
        $availableProvince = Province::first();
        $availableCity = City::where('province_id', $availableProvince->id)->first();

        $this->command->info('Available Province: ' . $availableProvince->name . ' (ID: ' . $availableProvince->id . ')');
        $this->command->info('Available City: ' . $availableCity->name . ' (ID: ' . $availableCity->id . ')');

        // Pastikan kategori dan indikator CSR sudah ada
        if (CsrCategory::count() == 0) {
            $this->call(CsrCategorySeeder::class);
        }
        
        if (CsrIndicator::count() == 0) {
            $this->call(CsrIndicatorSeeder::class);
        }

        // Membuat user admin jika belum ada
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Membuat user perusahaan jika belum ada
        $perusahaan = User::firstOrCreate(
            ['email' => 'company@example.com'],
            [
                'name' => 'PT Example Company',
                'password' => Hash::make('password'),
                'role' => 'perusahaan',
                'email_verified_at' => now(),
            ]
        );

        // Membuat profil perusahaan jika belum ada
        $companyProfile = CompanyProfile::firstOrCreate(
            ['user_id' => $perusahaan->id],
            [
                'name' => 'PT Example Company',
                'business_type' => 'Teknologi',
                'category' => 'Teknologi Informasi',
                'province_id' => $availableProvince->id,
                'city_id' => $availableCity->id,
                'contact_name' => 'John Doe',
                'contact_position' => 'Direktur',
                'contact_email' => 'john.doe@example.com',
                'contact_phone' => '021-1234567',
                'established_year' => 2010,
                'employee_count' => 250,
                'operational_province_id' => $availableProvince->id,
                'operational_city_id' => $availableCity->id,
            ]
        );

        // Membuat user pemantau jika belum ada
        $pemantau = User::firstOrCreate(
            ['email' => 'pemantau@example.com'],
            [
                'name' => 'Pemantau CSR',
                'password' => Hash::make('password'),
                'role' => 'pemantau',
                'email_verified_at' => now(),
            ]
        );

        // Membuat user reviewer jika belum ada
        $reviewer = User::firstOrCreate(
            ['email' => 'reviewer@example.com'],
            [
                'name' => 'Reviewer CSR',
                'password' => Hash::make('password'),
                'role' => 'reviewer',
                'email_verified_at' => now(),
            ]
        );

        // Cek apakah sudah ada assessment
        if (CsrAssessment::count() == 0) {
            $this->command->info('Membuat data assessment CSR...');
            
            // Membuat assessment CSR untuk perusahaan
            $indicators = CsrIndicator::all();
            $statuses = ['draft', 'submitted', 'reviewed', 'approved', 'rejected'];
            $years = [2023, 2024, 2025];
            
            foreach ($indicators as $indicator) {
                foreach ($years as $year) {
                    $status = $statuses[array_rand($statuses)];
                    
                    $assessment = CsrAssessment::create([
                        'company_id' => $perusahaan->id,
                        'indicator_id' => $indicator->id,
                        'year' => $year,
                        'quarter' => rand(1, 4),
                        'value' => rand(1, 5),
                        'evidence' => 'Bukti pelaksanaan CSR untuk ' . $indicator->name,
                        'notes' => 'Catatan untuk ' . $indicator->name,
                        'status' => $status,
                        'submission_date' => now()->subDays(rand(1, 30)),
                    ]);
                    
                    if (in_array($status, ['reviewed', 'approved', 'rejected'])) {
                        $assessment->update([
                            'reviewer_id' => $reviewer->id,
                            'review_date' => now()->subDays(rand(1, 10)),
                            'review_notes' => 'Review untuk ' . $indicator->name,
                        ]);
                    }
                }
            }
        } else {
            $this->command->info('Data assessment CSR sudah ada, melewati pembuatan data assessment.');
        }

        $this->command->info('Mock data berhasil dibuat:');
        $this->command->info('- Admin: admin@example.com / password');
        $this->command->info('- Perusahaan: company@example.com / password');
        $this->command->info('- Pemantau: pemantau@example.com / password');
        $this->command->info('- Reviewer: reviewer@example.com / password');
    }
}
