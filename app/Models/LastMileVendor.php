<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastMileVendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_mile_name',
    ];

    // Optional: if your table name is different from 'last_mile_vendors'
    // protected $table = 'last_mile_vendors';
}
