<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constituency extends Model
{
    use HasFactory;

    protected $table = 'constituencies';

    protected $fillable = [
        'zone_id',
        'name',
        'latitude',
        'longitude',
        'status',
    ];

  
    // A constituency belongs to a zone
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    // A constituency has many wards
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
