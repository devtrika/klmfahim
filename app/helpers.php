<?php

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

if (! function_exists('getgroup')) {
    /** The logged-in admin's group id (0 for guests). */
    function getgroup(): int
    {
        return Auth::check() ? (int) Auth::user()->group_id : 0;
    }
}

if (! function_exists('groupPermissions')) {
    /** All permission strings of a group, loaded once per request. */
    function groupPermissions(int $groupId): array
    {
        static $cache = [];

        return $cache[$groupId] ??= Permission::where('group_id', $groupId)->pluck('permission')->all();
    }
}

if (! function_exists('groupHasPermission')) {
    function groupHasPermission(int $groupId, string $permission): bool
    {
        return in_array($permission, groupPermissions($groupId), true);
    }
}

if (! function_exists('groupHasAnyoFPermission')) {
    function groupHasAnyoFPermission(int $groupId, array $permissions): bool
    {
        return (bool) array_intersect($permissions, groupPermissions($groupId));
    }
}

if (! function_exists('can_do')) {
    /** Shortcut for the current admin: can_do('services_add'). */
    function can_do(string $permission): bool
    {
        return groupHasPermission(getgroup(), $permission);
    }
}

if (! function_exists('all_permissions')) {
    /** Every permission string defined in config/permissions.php. */
    function all_permissions(): array
    {
        $all = [];
        foreach (config('permissions.modules') as $key => $module) {
            $all[] = $key;
            foreach ($module['actions'] as $action) {
                $all[] = $key.'_'.$action;
            }
        }

        return $all;
    }
}
