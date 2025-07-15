<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    /**
     * Handle the Category "creating" event.
     */
    public function creating(Category $category): void
    {
        if (Auth::check()) {
            $category->created_by = Auth::id();
            $category->updated_by = Auth::id();
        }
    }

    /**
     * Handle the Category "created" event.
     */
     public function created(Category $category): void
     {
         if (Auth::check()) {
             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => Category::class,
                 'item_id' => $category->id,
                 'action' => 'create',
                 'item_data' => $category->toArray(),
             ]);
         }
     }

     /**
      * Handle the Category "updating" event.
      */
     public function updating(Category $category): void
     {
         if (Auth::check()) {
             $category->updated_by = Auth::id();
         }
     }

    /**
     * Handle the Category "updated" event.
     */
     public function updated(Category $category): void
     {
         if (Auth::check()) {
             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => Category::class,
                 'item_id' => $category->id,
                 'action' => 'update',
                 'item_data' => $category->toArray(),
             ]);
         }
     }

    /**
     * Handle the Category "deleted" event.
     */
     public function deleted(Category $category): void
     {
         if (Auth::check()) {
             ActivityLog::create([
                 'user_id' => Auth::id(),
                 'item_type' => Category::class,
                 'item_id' => $category->id,
                 'action' => 'delete',
                 'item_data' => $category->toArray(),
             ]);
         }
     }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
