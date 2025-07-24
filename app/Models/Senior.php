<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Senior extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name', 'photo', 'status', 'max_juniors', 'current_juniors'];

    public function juniors()
    {
        return $this->hasMany(Junior::class);
    }
}

