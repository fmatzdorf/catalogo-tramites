<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'item_type',
        'item_id',
        'action',
        'item_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'item_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed this action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model instance.
     */
    public function item()
    {
        return $this->morphTo('item', 'item_type', 'item_id');
    }

    /**
     * Scope a query to only include logs for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include logs for a specific item type.
     */
    public function scopeForItemType($query, $itemType)
    {
        return $query->where('item_type', $itemType);
    }

    /**
     * Scope a query to only include logs for a specific action.
     */
    public function scopeForAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to order by most recent first.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get a human-readable description of the action.
     */
    public function getDescriptionAttribute(): string
    {
        $itemType = strtolower(class_basename($this->item_type));
        $action = strtolower($this->action);

        return "{$this->user->name} {$action}d {$itemType}";
    }
}
