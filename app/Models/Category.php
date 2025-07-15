<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'parent_category_id',
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
     * Get the user who created this category.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this category.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    /**
     * Get all child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    /**
     * Get all child categories recursively.
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Get all procedures that belong to this category.
     */
    public function procedures(): HasMany
    {
        return $this->hasMany(Procedure::class);
    }

    /**
     * Scope a query to only include root categories (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_category_id');
    }

    /**
     * Scope a query to only include child categories (has parent).
     */
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_category_id');
    }

    /**
     * Scope a query to search categories by name.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', '%' . $term . '%');
    }

    // Scope to get root categories (no parent)
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_category_id');
    }

    // Scope to get categories with their full hierarchy
    public function scopeWithHierarchy($query)
    {
        return $query->with(['parent', 'children']);
    }


    /**
     * Get the full path of the category (including parent names).
     */
    public function getFullPathAttribute(): string
    {
        $path = $this->name;
        $parent = $this->parent;

        while ($parent) {
            $path = $parent->name . ' > ' . $path;
            $parent = $parent->parent;
        }

        return $path;
    }

    // Helper method to get the full path of the category
    public function getFullPath()
    {
        $path = collect([$this->name]);
        $parent = $this->parent;

        while ($parent) {
            $path->prepend($parent->name);
            $parent = $parent->parent;
        }

        return $path->implode(' > ');
    }

    /**
     * Get all ancestors of this category.
     */
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Get the depth level of this category (0 for root categories).
     */
    public function getDepthAttribute(): int
    {
        return $this->ancestors()->count();
    }
    // Helper method to get indentation level for display
    public function getIndentLevel()
    {
        return $this->ancestors()->count();
    }


    public function descendants()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }


    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

}
