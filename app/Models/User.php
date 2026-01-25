<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'designation_id',
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

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Staff specialization
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    // Jurisdiction (ward-based access control)
    public function wards(): BelongsToMany
    {
        return $this->belongsToMany(
            Ward::class,
            'user_wards',   // MUST match pivot table name
            'user_id',
            'ward_id'
        );
    }

    // Complaints raised by citizen
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    // Complaint updates performed by this user
    public function complaintUpdates(): HasMany
    {
        return $this->hasMany(ComplaintUpdate::class, 'acted_by_user_id');
    }
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isStaff(): bool
    {
        return $this->hasRole('staff');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
