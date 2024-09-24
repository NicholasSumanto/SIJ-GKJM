<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gereja extends Model
{
    use HasFactory;

    protected $table = 'gereja';

    protected $fillable = [
        'nama_gereja',
    ];
}
