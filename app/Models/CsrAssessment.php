<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsrAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'indicator_id',
        'score',
        'notes',
        'uploaded_documents',
        'status',
        'reviewed_by',
        'reviewed_at'
    ];

    protected $casts = [
        'uploaded_documents' => 'array',
        'reviewed_at' => 'datetime'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function indicator()
    {
        return $this->belongsTo(CsrIndicator::class, 'indicator_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
