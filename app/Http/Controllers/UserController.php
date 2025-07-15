<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
     {
         Gate::authorize('viewAny', User::class);

         $query = User::query();

         // Apply search filter
         if (request('search')) {
             $query->where('name', 'like', '%' . request('search') . '%')
                   ->orWhere('email', 'like', '%' . request('search') . '%');
         }

         // Apply role filter
         if (request('role')) {
             $query->where('role', request('role'));
         }

         // Apply institution filter (admin only)
         if (request('institution_id') && auth()->user()->role === 'admin') {
             $query->where('institution_id', request('institution_id'));
         }

         // Role-based filtering
         if (auth()->user()->role === 'institutional') {
             $query->where('institution_id', auth()->user()->institution_id);
         }

         $users = $query->with(['institution', 'createdBy'])
                       ->orderBy('name')
                       ->paginate(15)
                      ->appends(request()->query());

         // Get filter options
         $institutions = auth()->user()->role === 'admin'
                        ? Institution::orderBy('name')->get()
                        : collect();

         return view('users.index', compact('users', 'institutions'));
     }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
     {
         Gate::authorize('create', User::class);

         if (auth()->user()->role === 'admin') {
             $institutions = Institution::orderBy('name')->get();
         } else {
             $institutions = Institution::where('id', auth()->user()->institution_id)->get();
         }

         return view('users.create', compact('institutions'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', User::class);

        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,institutional',
            'institution_id' => 'nullable|exists:institutions,id',
        ];

        // Institutional users can only create institutional users for their institution
        if ($user->role === 'institutional') {
            $rules['role'] = 'required|in:institutional';
            $rules['institution_id'] = 'required|exists:institutions,id';
        }

        $validated = $request->validate($rules);

        // Set institution based on user role
        if ($user->role === 'institutional') {
            $validated['institution_id'] = $user->institution_id;
        }

        // Admin role cannot have institution_id
        if ($validated['role'] === 'admin') {
            $validated['institution_id'] = null;
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $newUser = User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(User $user)
     {
         Gate::authorize('update', $user);

         if (auth()->user()->role === 'admin') {
             $institutions = Institution::orderBy('name')->get();
         } else {
             $institutions = Institution::where('id', auth()->user()->institution_id)->get();
         }

         return view('users.edit', compact('user', 'institutions'));
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);

        $currentUser = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,institutional',
            'institution_id' => 'nullable|exists:institutions,id',
        ];

        // Institutional users have restrictions
        if ($currentUser->role === 'institutional') {
            $rules['role'] = 'required|in:institutional';
            $rules['institution_id'] = 'required|exists:institutions,id';
        }

        $validated = $request->validate($rules);

        // Set institution based on current user role
        if ($currentUser->role === 'institutional') {
            $validated['institution_id'] = $currentUser->institution_id;
        }

        // Admin role cannot have institution_id
        if ($validated['role'] === 'admin') {
            $validated['institution_id'] = null;
        }

        // Update password only if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['updated_by'] = auth()->id();

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
