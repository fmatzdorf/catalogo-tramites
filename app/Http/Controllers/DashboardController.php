<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Category;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
     public function index()
     {
         $user = Auth::user();
         $isAdmin = $user->role === 'admin';
         $isInstitutional = $user->role === 'institutional';

         $stats = [];

         if ($isAdmin) {
             // Admin can see all statistics
             $stats = [
                 'institutions' => Institution::count(),
                 'categories' => Category::count(),
                 'procedures' => Procedure::count(),
                 'users' => User::count(),
                 'recent_procedures' => Procedure::with(['institution', 'category', 'createdBy'])
                     ->orderBy('created_at', 'desc')
                     ->take(5)
                     ->get(),
             ];
         } elseif ($isInstitutional && $user->institution_id) {
             // Institutional user can see only their institution's statistics
             $stats = [
                 'institution' => Institution::find($user->institution_id),
                 'procedures' => Procedure::where('institution_id', $user->institution_id)->count(),
                 'users' => User::where('institution_id', $user->institution_id)->count(),
                 'recent_procedures' => Procedure::where('institution_id', $user->institution_id)
                     ->with(['institution', 'category', 'createdBy'])
                     ->orderBy('created_at', 'desc')
                     ->take(5)
                     ->get(),
             ];
         }

         return view('dashboard', compact('stats', 'isAdmin', 'isInstitutional'));
     }
     /*
     public function index()
     {
         $user = auth()->user();

         $stats = [];

         if ($user->role === 'admin') {
             $stats = [
                 'institutions' => Institution::count(),
                 'categories' => Category::count(),
                 'procedures' => Procedure::count(),
                 'users' => User::count(),
             ];
         } else {
             $stats = [
                 'procedures' => Procedure::where('institution_id', $user->institution_id)->count(),
                 'users' => User::where('institution_id', $user->institution_id)->count(),
             ];
         }

         return view('dashboard', compact('stats'));
     }*/

/*
    public function index(): View
    {
        $user = auth()->user();

        // Calculate statistics based on user role
        if ($user->role === 'admin') {
            $stats = [
                'institutions' => Institution::count(),
                'categories' => Category::count(),
                'procedures' => Procedure::count(),
                'users' => User::count(),
            ];

            $recentProcedures = Procedure::with(['category', 'institution'])
                ->latest()
                ->take(5)
                ->get();

            $recentUsers = User::with('institution')
                ->latest()
                ->take(5)
                ->get();
        } else {
            $stats = [
                'institution' => $user->institution ? $user->institution->name : 'N/A',
                'procedures' => Procedure::where('institution_id', $user->institution_id)->count(),
                'users' => User::where('institution_id', $user->institution_id)->count(),
                'categories' => Category::count(), // All categories available
            ];

            $recentProcedures = Procedure::with(['category', 'institution'])
                ->where('institution_id', $user->institution_id)
                ->latest()
                ->take(5)
                ->get();

            $recentUsers = User::with('institution')
                ->where('institution_id', $user->institution_id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('stats', 'recentProcedures', 'recentUsers'));
    }*/
}
