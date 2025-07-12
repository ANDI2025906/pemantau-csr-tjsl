<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['province_id', 'name', 'type'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
