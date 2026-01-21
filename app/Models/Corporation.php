<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corporation extends Model
{
    use HasFactory;

   
    protected $table = 'corporations';

   
    protected $fillable = [
        'name',
        'boundary',
        'x_min',
        'x_max',
        'y_min',
        'y_max',
    ];

   
    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
