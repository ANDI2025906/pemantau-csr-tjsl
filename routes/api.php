// routes/api.php
<?php
use App\Models\City;

Route::get('/cities/{province}', function ($province) {
    return City::where('province_id', $province)
        ->orderBy('type')
        ->orderBy('name')
        ->get();
});
