<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'business_type',
        'head_office_province',
        'head_office_city',
        'operational_province',
        'operational_city',
        'employee_count',
        'established_year',
        'contact_name',
        'contact_position',
        'contact_phone',
        'contact_email',
    ];

    /**
     * Get the user that owns the company details.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the province of the head office.
     */
    public function headOfficeProvince()
    {
        return $this->belongsTo(Province::class, 'head_office_province');
    }

    /**
     * Get the city of the head office.
     */
    public function headOfficeCity()
    {
        return $this->belongsTo(City::class, 'head_office_city');
    }

    /**
     * Get the province of the operational location.
     */
    public function operationalProvince()
    {
        return $this->belongsTo(Province::class, 'operational_province');
    }

    /**
     * Get the city of the operational location.
     */
    public function operationalCity()
    {
        return $this->belongsTo(City::class, 'operational_city');
    }
}