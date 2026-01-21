<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'category_id',
        'sub_category_id',
        'zone',
        'constituency',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Mandatory category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Optional sub-category
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Staff ↔ Wards (PIVOT TABLE)
     */
    public function wards()
    {
        return $this->belongsToMany(
            Ward::class,
            'staff_ward_assignments',
            'staff_id',
            'ward_id'
        );
    }
}
