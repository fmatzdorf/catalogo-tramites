<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('admin-only')) {
                abort(403, 'Access denied. Administrative privileges required.');
            }
            return $next($request);
        });
    }
    */

    public function index(Request $request)
    {
        Gate::authorize('viewAny', ActivityLog::class);

        $query = ActivityLog::with(['user'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('item_type')) {
            $query->where('item_type', $request->item_type);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(25)->appends($request->query());

        // Get filter options
        $users = User::orderBy('name')->get();
        $itemTypes = ActivityLog::distinct()->pluck('item_type')->sort();
        $actions = ActivityLog::distinct()->pluck('action')->sort();

        return view('activity-logs.index', compact('logs', 'users', 'itemTypes', 'actions'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity-logs.show', compact('activityLog'));
    }
}
