<?php

namespace App\Policies;

use App\Models\BackendUser;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the BackendUser can view any models.
     */
    public function viewAny(BackendUser $BackendUser): bool
    {
        return true;
    }

    /**
     * Determine whether the BackendUser can view the model.
     */
    public function view(BackendUser $BackendUser, Role $role): bool
    {
        return true;
    }

    /**
     * Determine whether the BackendUser can create models.
     */
    public function create(BackendUser $BackendUser): bool
    {
        return true;
    }

    /**
     * Determine whether the BackendUser can update the model.
     */
    public function update(BackendUser $BackendUser, Role $role): bool
    {
        return true;
    }

    /**
     * Determine whether the BackendUser can delete the model.
     */
    public function delete(BackendUser $BackendUser, Role $role): bool
    {
        return true;
    }

    /**
     * Determine whether the BackendUser can bulk delete.
     */
    public function deleteAny(BackendUser $BackendUser): bool
    {
        return $BackendUser->can('delete_any_role');
    }

    /**
     * Determine whether the BackendUser can permanently delete.
     */
    public function forceDelete(BackendUser $BackendUser, Role $role): bool
    {
        return $BackendUser->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the BackendUser can permanently bulk delete.
     */
    public function forceDeleteAny(BackendUser $BackendUser): bool
    {
        return $BackendUser->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the BackendUser can restore.
     */
    public function restore(BackendUser $BackendUser, Role $role): bool
    {
        return $BackendUser->can('{{ Restore }}');
    }

    /**
     * Determine whether the BackendUser can bulk restore.
     */
    public function restoreAny(BackendUser $BackendUser): bool
    {
        return $BackendUser->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the BackendUser can replicate.
     */
    public function replicate(BackendUser $BackendUser, Role $role): bool
    {
        return $BackendUser->can('{{ Replicate }}');
    }

    /**
     * Determine whether the BackendUser can reorder.
     */
    public function reorder(BackendUser $BackendUser): bool
    {
        return $BackendUser->can('{{ Reorder }}');
    }
}
