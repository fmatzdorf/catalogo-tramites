<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
     {
         Gate::authorize('viewAny', Institution::class);

         $query = Institution::query();

         // Apply search filter
         if (request('search')) {
             $query->where('name', 'like', '%' . request('search') . '%')
                   ->orWhere('type', 'like', '%' . request('search') . '%')
                   ->orWhere('email', 'like', '%' . request('search') . '%');
         }

         // Role-based filtering
         if (auth()->user()->role === 'institutional') {
             $query->where('id', auth()->user()->institution_id);
         }

         $institutions = $query->with(['createdBy'])
                              ->orderBy('name')
                              ->paginate(15)
                             ->appends(request()->query());

         return view('institutions.index', compact('institutions'));
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Institution::class);

        return view('institutions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Institution::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'schedule' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $institution = Institution::create($validated);

        return redirect()->route('institutions.index')
            ->with('success', 'Institution created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution): View
    {
        Gate::authorize('view', $institution);

        return view('institutions.show', compact('institution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution): View
    {
        Gate::authorize('update', $institution);

        return view('institutions.edit', compact('institution'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution): RedirectResponse
    {
        Gate::authorize('update', $institution);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'schedule' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
        ]);

        $validated['updated_by'] = auth()->id();

        $institution->update($validated);

        return redirect()->route('institutions.index')
            ->with('success', 'Institution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution): RedirectResponse
    {
        Gate::authorize('delete', $institution);

        // Check if institution has associated procedures or users
        // if ($institution->procedures()->exists()) {
        if ($institution->procedures()->count() > 0) {
            return redirect()->route('institutions.index')
                ->with('error', 'Cannot delete institution with associated procedures.');
        }

        // if ($institution->users()->exists()) {
        if ($institution->users()->count() > 0) {
            return redirect()->route('institutions.index')
                ->with('error', 'Cannot delete institution with associated users.');
        }

        $institution->delete();

        return redirect()->route('institutions.index')
            ->with('success', 'Institution deleted successfully.');
    }
}
