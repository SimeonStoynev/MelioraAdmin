<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdTemplate;

class AdTemplatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage_ad_templates');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AdTemplate $adTemplate): bool
    {
        return $user->hasPermissionTo('manage_ad_templates');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_ad_templates');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AdTemplate $adTemplate): bool
    {
        return $user->hasPermissionTo('manage_ad_templates');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AdTemplate $adTemplate): bool
    {
        return $user->hasPermissionTo('manage_ad_templates');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AdTemplate $adTemplate): bool
    {
        return $user->hasPermissionTo('manage_ad_templates');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AdTemplate $adTemplate): bool
    {
        return $user->hasPermissionTo('manage_ad_templates');
    }
}
