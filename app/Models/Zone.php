<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'zones';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'color',
        'boundary',
        'status',
        'x_min',
        'x_max',
        'y_min',
        'y_max',
        'corporation_id',
    ];


    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    // Each zone  many constituencies
    public function constituencies()
    {
        return $this->hasMany(Constituency::class);
    }
}
