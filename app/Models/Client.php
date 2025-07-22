<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'vendor_id',
        'media_id',
        'last_mile_vendor_id',
        'square_end_ip',
        'client_end_ip',
        'connt_router',
        'router_type',
        'pop_location',
        'installation_date',
        'remarks',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function lastMileVendor()
    {
          return $this->belongsTo(LastMileVendor::class, 'last_mile_vendor_id');
    }
}
