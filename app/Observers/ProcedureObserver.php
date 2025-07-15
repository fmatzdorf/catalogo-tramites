<?php

namespace App\Observers;

use App\Models\Procedure;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ProcedureObserver
{
    /**
     * Handle the Procedure "creating" event.
     */
    public function creating(Procedure $procedure): void
    {
        if (Auth::check()) {
            $procedure->created_by = Auth::id();
            $procedure->updated_by = Auth::id();
        }
    }

    /**
     * Handle the Procedure "created" event.
     */
     public function created(Procedure $procedure): void
     {
         if (Auth::check()) {
             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => Procedure::class,
                 'item_id' => $procedure->id,
                 'action' => 'create',
                 'item_data' => $procedure->toArray(),
             ]);
         }
     }

     /**
      * Handle the Procedure "updating" event.
      */
     public function updating(Procedure $procedure): void
     {
         if (Auth::check()) {
             $procedure->updated_by = Auth::id();
         }
     }

    /**
     * Handle the Procedure "updated" event.
     */
     public function updated(Procedure $procedure): void
     {
         if (Auth::check()) {
             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => Procedure::class,
                 'item_id' => $procedure->id,
                 'action' => 'update',
                 'item_data' => $procedure->toArray(),
             ]);
         }
     }

    /**
     * Handle the Procedure "deleted" event.
     */
     public function deleted(Procedure $procedure): void
     {
         if (Auth::check()) {
             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => Procedure::class,
                 'item_id' => $procedure->id,
                 'action' => 'delete',
                 'item_data' => $procedure->toArray(),
             ]);
         }
     }
     
    /**
     * Handle the Procedure "restored" event.
     */
    public function restored(Procedure $procedure): void
    {
        //
    }

    /**
     * Handle the Procedure "force deleted" event.
     */
    public function forceDeleted(Procedure $procedure): void
    {
        //
    }
}
