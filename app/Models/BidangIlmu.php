<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangIlmu extends Model
{
    use HasFactory;

    protected $table = 'bidangilmu';

    protected $fillable = [
        'bidangilmu',
    ];
}
