<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'media_name',
        'media_convertor',
        'cabol_type',
    ];
}
