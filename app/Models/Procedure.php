<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procedure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'category_id',
        'institution_id',
        'description',
        'normative',
        'instructions',
        'requirements',
        'cost',
        'currency',
        'response_time',
        'result_type',
        'url',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created this procedure.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this procedure.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the category that this procedure belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the institution that this procedure belongs to.
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Scope a query to only include procedures from a specific institution.
     */
    public function scopeForInstitution($query, $institutionId)
    {
        return $query->where('institution_id', $institutionId);
    }

    /**
     * Scope a query to only include procedures from a specific category.
     */
    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to search procedures by title.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%');
    }

    /**
     * Scope a query to only include procedures created by a specific user.
     */
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Get the formatted cost with currency.
     */
    public function getFormattedCostAttribute(): string
    {
        if (!$this->cost) {
            return 'Free';
        }

        $currency = $this->currency ?? 'GTQ';
        return $currency . ' ' . $this->cost;
    }
}
