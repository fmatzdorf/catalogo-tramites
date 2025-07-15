<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
         'name',
         'email',
         'password',
         'role',
         'institution_id',
         'created_by',
         'updated_by',
     ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this user.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this user.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the institution that this user belongs to.
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get all institutions created by this user.
     */
    public function createdInstitutions(): HasMany
    {
        return $this->hasMany(Institution::class, 'created_by');
    }

    /**
     * Get all institutions updated by this user.
     */
    public function updatedInstitutions(): HasMany
    {
        return $this->hasMany(Institution::class, 'updated_by');
    }

    /**
     * Get all categories created by this user.
     */
    public function createdCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'created_by');
    }

    /**
     * Get all categories updated by this user.
     */
    public function updatedCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'updated_by');
    }

    /**
     * Get all procedures created by this user.
     */
    public function createdProcedures(): HasMany
    {
        return $this->hasMany(Procedure::class, 'created_by');
    }

    /**
     * Get all procedures updated by this user.
     */
    public function updatedProcedures(): HasMany
    {
        return $this->hasMany(Procedure::class, 'updated_by');
    }

    /**
     * Get all users created by this user.
     */
    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * Get all users updated by this user.
     */
    public function updatedUsers(): HasMany
    {
        return $this->hasMany(User::class, 'updated_by');
    }

    /**
     * Get all activity logs for this user.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check if the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is an institutional user.
     */
    public function isInstitutional(): bool
    {
        return $this->role === 'institutional';
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope a query to only include institutional users.
     */
    public function scopeInstitutional($query)
    {
        return $query->where('role', 'institutional');
    }

    /**
     * Scope a query to only include users from a specific institution.
     */
    public function scopeForInstitution($query, $institutionId)
    {
        return $query->where('institution_id', $institutionId);
    }

    /**
     * Scope a query to search users by name or email.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%');
    }

    /**
     * Get the user's role in a human-readable format.
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrador',
            'institutional' => 'Institucional',
            default => 'Desconocido',
        };
    }
}
