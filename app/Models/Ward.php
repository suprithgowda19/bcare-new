<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'wards';
    public $timestamps = false;


    protected $fillable = [
        'constituency_id',
        'name',
        'number',
        'status',
        'type',
        'boundry',
        'x_min',
        'x_max',
        'y_min',
        'y_max',
    ];


    public function constituency()
    {
        return $this->belongsTo(Constituency::class);
    }
}
