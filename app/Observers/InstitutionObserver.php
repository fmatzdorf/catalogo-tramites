<?php

namespace App\Observers;

use App\Models\Institution;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class InstitutionObserver
{
    /**
     * Handle the Institution "creating" event.
     */
    public function creating(Institution $institution): void
    {
        if (Auth::check()) {
            $institution->created_by = Auth::id();
            $institution->updated_by = Auth::id();
        }
    }

    /**
     * Handle the Institution "created" event.
     */
    public function created(Institution $institution): void
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'item_type' => Institution::class,
                'item_id' => $institution->id,
                'action' => 'create',
                'item_data' => $institution->toArray(),
            ]);
        }
    }

    /**
     * Handle the Institution "updating" event.
     */
    public function updating(Institution $institution): void
    {
        if (Auth::check()) {
            $institution->updated_by = Auth::id();
        }
    }

    /**
     * Handle the Institution "updated" event.
     */
    public function updated(Institution $institution): void
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'item_type' => Institution::class,
                'item_id' => $institution->id,
                'action' => 'update',
                'item_data' => $institution->toArray(),
            ]);
        }
    }

    /**
     * Handle the Institution "deleted" event.
     */
    public function deleted(Institution $institution): void
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'item_type' => Institution::class,
                'item_id' => $institution->id,
                'action' => 'delete',
                'item_data' => $institution->toArray(),
            ]);
        }
    }

    /**
     * Handle the Institution "restored" event.
     */
    public function restored(Institution $institution): void
    {
        //
    }

    /**
     * Handle the Institution "force deleted" event.
     */
    public function forceDeleted(Institution $institution): void
    {
        //
    }
}
