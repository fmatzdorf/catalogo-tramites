<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
     {
         Gate::authorize('viewAny', Category::class);

         $query = Category::query();

         // Apply search filter
         if (request('search')) {
             $query->where('name', 'like', '%' . request('search') . '%')
                   ->orWhere('description', 'like', '%' . request('search') . '%');
         }

         // Apply parent category filter
         if (request('parent_category_id') !== null) {
             if (request('parent_category_id') === '') {
                 // Filter for root categories (no parent)
                 $query->whereNull('parent_category_id');
             } else {
                 // Filter for specific parent category
                 $query->where('parent_category_id', request('parent_category_id'));
             }
         }

         // Get categories with procedure counts
         $categories = $query->withCount('procedures')
                            ->with(['parent', 'createdBy'])
                            ->orderBy('parent_category_id')
                            ->paginate(15)
                           ->appends(request()->query());

         // Get hierarchical tree for display
         $categoriesTree = Category::with(['children.children.children', 'children.children', 'children'])
                                  ->withCount('procedures')
                                  ->whereNull('parent_category_id')
                                  ->orderBy('name')
                                  ->get();

         // Get parent categories for filter dropdown
        $parentCategories = Category::whereNull('parent_category_id')
                                   ->orderBy('name')
                                   ->get();

        return view('categories.index', compact('categories', 'categoriesTree', 'parentCategories'));
     }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
     {
         Gate::authorize('create', Category::class);

         $parentCategories = Category::whereNull('parent_category_id')
             ->orWhere('parent_category_id', '!=', null)
             ->orderBy('name')
             ->get();

         return view('categories.create', compact('parentCategories'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Category::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_category_id' => 'nullable|exists:categories,id',
        ]);

        // Prevent circular reference
        if ($validated['parent_category_id']) {
            $this->validateNonCircularReference(null, $validated['parent_category_id']);
        }

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $category = Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        Gate::authorize('view', $category);

        // Load related data
        $category->load(['parent', 'children', 'procedures']);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Category $category)
     {
         Gate::authorize('update', $category);

         $parentCategories = Category::where('id', '!=', $category->id)
             ->whereNull('parent_category_id')
             ->orWhere('parent_category_id', '!=', $category->id)
             ->orderBy('name')
             ->get();

         return view('categories.edit', compact('category', 'parentCategories'));
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_category_id' => 'nullable|exists:categories,id',
        ]);

        // Prevent circular reference
        if ($validated['parent_category_id']) {
            $this->validateNonCircularReference($category->id, $validated['parent_category_id']);
        }

        $validated['updated_by'] = auth()->id();

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        Gate::authorize('delete', $category);

        // Check if category has associated procedures
        // if ($category->procedures()->exists()) {
        if ($category->procedures()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with associated procedures.');
        }

        // Check if category has child categories
        // if ($category->children()->exists()) {
        if ($category->children()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with child categories.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Build category tree for display
     */
    private function buildCategoryTree($categories, $parentId = null): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_category_id === $parentId) {
                $children = $this->buildCategoryTree($categories, $category->id);
                $category->children_tree = $children;
                $tree[] = $category;
            }
        }

        return $tree;
    }

    /**
     * Get all descendant IDs of a category
     */
    private function getDescendantIds(Category $category): array
    {
        $descendants = [];
        $children = $category->children;

        foreach ($children as $child) {
            $descendants[] = $child->id;
            $descendants = array_merge($descendants, $this->getDescendantIds($child));
        }

        return $descendants;
    }

    /**
     * Validate that setting a parent doesn't create circular reference
     */
    private function validateNonCircularReference($categoryId, $parentId): void
    {
        if ($categoryId === $parentId) {
            abort(422, 'A category cannot be its own parent.');
        }

        if ($categoryId) {
            $category = Category::find($categoryId);
            $descendantIds = $this->getDescendantIds($category);

            if (in_array($parentId, $descendantIds)) {
                abort(422, 'Cannot set parent category as it would create a circular reference.');
            }
        }
    }
}
