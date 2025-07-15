<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        if (Auth::check()) {
            $user->created_by = Auth::id();
            $user->updated_by = Auth::id();
        }
    }

    /**
     * Handle the User "created" event.
     */
     public function created(User $user): void
     {
         if (Auth::check()) {
             $userData = $user->toArray();
             // Remove sensitive data from log
             unset($userData['password']);

             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => User::class,
                 'item_id' => $user->id,
                 'action' => 'create',
                 'item_data' => $userData,
             ]);
         }
     }

     /**
      * Handle the User "updating" event.
      */
     public function updating(User $user): void
     {
         if (Auth::check()) {
             $user->updated_by = Auth::id();
         }
     }

    /**
     * Handle the User "updated" event.
     */
     public function updated(User $user): void
     {
         if (Auth::check()) {
             $userData = $user->toArray();
             // Remove sensitive data from log
             unset($userData['password']);

             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => User::class,
                 'item_id' => $user->id,
                 'action' => 'update',
                 'item_data' => $userData,
             ]);
         }
     }

    /**
     * Handle the User "deleted" event.
     */
     public function deleted(User $user): void
     {
         if (Auth::check()) {
             $userData = $user->toArray();
             // Remove sensitive data from log
             unset($userData['password']);

             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => User::class,
                 'item_id' => $user->id,
                 'action' => 'delete',
                 'item_data' => $userData,
             ]);
         }
     }
     
    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
