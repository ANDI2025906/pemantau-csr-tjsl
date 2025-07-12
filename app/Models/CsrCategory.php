<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsrCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function indicators()
    {
        return $this->hasMany(CsrIndicator::class);
    }
}
