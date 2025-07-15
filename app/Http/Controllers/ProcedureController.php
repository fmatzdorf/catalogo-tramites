<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\Category;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
     {
         Gate::authorize('viewAny', Procedure::class);

         $query = Procedure::query();

         // Apply search filter
         if (request('search')) {
             $query->where('title', 'like', '%' . request('search') . '%')
                   ->orWhere('description', 'like', '%' . request('search') . '%');
         }

         // Apply category filter
         if (request('category_id')) {
             $query->where('category_id', request('category_id'));
         }

         // Apply institution filter (admin only)
         if (request('institution_id') && auth()->user()->role === 'admin') {
             $query->where('institution_id', request('institution_id'));
         }

         // Role-based filtering
         if (auth()->user()->role === 'institutional') {
             $query->where('institution_id', auth()->user()->institution_id);
         }

         $procedures = $query->with(['category', 'institution', 'createdBy'])
                            ->orderBy('title')
                            ->paginate(15)
                           ->appends(request()->query());

         // Get filter options
         $categories = Category::orderBy('name')->get();
         $institutions = auth()->user()->role === 'admin'
                        ? Institution::orderBy('name')->get()
                        : collect();

         return view('procedures.index', compact('procedures', 'categories', 'institutions'));
     }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
     {
         Gate::authorize('create', Procedure::class);

         $categories = Category::orderBy('parent_category_id')->get();

         if (auth()->user()->role === 'admin') {
             $institutions = Institution::orderBy('name')->get();
         } else {
             $institutions = Institution::where('id', auth()->user()->institution_id)->get();
         }

         return view('procedures.create', compact('categories', 'institutions'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Procedure::class);

        $user = auth()->user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'institution_id' => 'required|exists:institutions,id',
            'description' => 'nullable|string',
            'normative' => 'nullable|string',
            'instructions' => 'nullable|string',
            'requirements' => 'nullable|string',
            'cost' => 'nullable|string',
            'currency' => 'nullable|string|max:10',
            'response_time' => 'nullable|string',
            'result_type' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
        ]);

        // Institutional users can only create procedures for their institution
        if ($user->role === 'institutional') {
            $validated['institution_id'] = $user->institution_id;
        }

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $procedure = Procedure::create($validated);

        return redirect()->route('procedures.index')
            ->with('success', 'Procedure created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Procedure $procedure): View
    {
        Gate::authorize('view', $procedure);

        $procedure->load(['category', 'institution', 'createdBy', 'updatedBy']);

        return view('procedures.show', compact('procedure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Procedure $procedure)
     {
         Gate::authorize('update', $procedure);

         $categories = Category::orderBy('name')->get();

         if (auth()->user()->role === 'admin') {
             $institutions = Institution::orderBy('name')->get();
         } else {
             $institutions = Institution::where('id', auth()->user()->institution_id)->get();
         }

         return view('procedures.edit', compact('procedure', 'categories', 'institutions'));
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procedure $procedure): RedirectResponse
    {
        Gate::authorize('update', $procedure);

        $user = auth()->user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'institution_id' => 'required|exists:institutions,id',
            'description' => 'nullable|string',
            'normative' => 'nullable|string',
            'instructions' => 'nullable|string',
            'requirements' => 'nullable|string',
            'cost' => 'nullable|string',
            'currency' => 'nullable|string|max:10',
            'response_time' => 'nullable|string',
            'result_type' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
        ]);

        // Institutional users cannot change the institution
        if ($user->role === 'institutional') {
            $validated['institution_id'] = $user->institution_id;
        }

        $validated['updated_by'] = auth()->id();

        $procedure->update($validated);

        return redirect()->route('procedures.index')
            ->with('success', 'Procedure updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procedure $procedure): RedirectResponse
    {
        Gate::authorize('delete', $procedure);

        $procedure->delete();

        return redirect()->route('procedures.index')
            ->with('success', 'Procedure deleted successfully.');
    }
}
