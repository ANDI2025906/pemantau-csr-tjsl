<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Tambahkan user_id ke fillable
        'name',
        'category',
        'business_type',
        'province_id',
        'city_id',
        'operational_province_id',
        'operational_city_id',
        'employee_count',
        'established_year',
        'contact_name',
        'contact_position',
        'contact_phone',
        'contact_email'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Province untuk alamat utama
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    // Relasi dengan City untuk alamat utama
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Relasi dengan Province untuk alamat operasional
    public function operationalProvince()
    {
        return $this->belongsTo(Province::class, 'operational_province_id');
    }

    // Relasi dengan City untuk alamat operasional
    public function operationalCity()
    {
        return $this->belongsTo(City::class, 'operational_city_id');
    }
}