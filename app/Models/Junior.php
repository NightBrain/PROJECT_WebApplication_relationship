<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Junior extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'photo', 'senior_id', 'is_random'];

    public function senior()
    {
        return $this->belongsTo(Senior::class);
    }
}
