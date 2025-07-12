<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsrIndicator extends Model
{
    use HasFactory;

    protected $fillable = ['csr_category_id', 'name', 'description'];

    public function category()
    {
        return $this->belongsTo(CsrCategory::class, 'csr_category_id');
    }

    public function assessments()
    {
        return $this->hasMany(CsrAssessment::class);
    }
}
