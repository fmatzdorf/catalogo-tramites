<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
     public function viewAny(User $user): bool
     {
         return in_array($user->role, ['admin', 'institutional']);
     }

    /**
     * Determine whether the user can view the model.
     */
     public function view(User $user, User $model): bool
     {
         if ($user->role === 'admin') {
             return true;
         }

         if ($user->role === 'institutional') {
             // Institutional users can view users from their institution
             return $user->institution_id === $model->institution_id;
         }

         return false;
     }

    /**
     * Determine whether the user can create models.
     */
     public function create(User $user): bool
     {
         return in_array($user->role, ['admin', 'institutional']);
     }

    /**
     * Determine whether the user can update the model.
     */
     public function update(User $user, User $model): bool
     {
         if ($user->role === 'admin') {
             return true;
         }

         if ($user->role === 'institutional') {
             // Institutional users can only update users from their institution
             // but cannot change their own role or institution
             return $user->institution_id === $model->institution_id && $user->id !== $model->id;
         }

         return false;
     }

    /**
     * Determine whether the user can delete the model.
     */
     public function delete(User $user, User $model): bool
     {
         if ($user->role === 'admin') {
             // Admins cannot delete themselves
             return $user->id !== $model->id;
         }

         if ($user->role === 'institutional') {
             // Institutional users can delete users from their institution
             // but cannot delete themselves
             return $user->institution_id === $model->institution_id && $user->id !== $model->id;
         }

         return false;
     }

    /**
     * Determine whether the user can restore the model.
     */
     public function restore(User $user, User $model): bool
     {
         if ($user->role === 'admin') {
             return true;
         }

         if ($user->role === 'institutional') {
             return $user->institution_id === $model->institution_id;
         }

         return false;
     }

    /**
     * Determine whether the user can permanently delete the model.
     */
     public function forceDelete(User $user, User $model): bool
     {
         return $user->role === 'admin' && $user->id !== $model->id;
     }

     /**
      * Determine whether the user can manage roles.
      */
     public function manageRoles(User $user): bool
     {
         return $user->role === 'admin';
     }

     /**
      * Determine whether the user can assign institutions.
      */
     public function assignInstitutions(User $user): bool
     {
         return $user->role === 'admin';
     }     
}
