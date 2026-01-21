<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintUpdate extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'complaint_id',
        'staff_id',
        'status',
        'remarks',
        'images',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'images' => 'array', // JSON → PHP array
    ];

    /**
     * Relationship: This update belongs to a complaint
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * Relationship: This update was made by a staff user
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
