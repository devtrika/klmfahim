<?php

namespace App\Http\Middleware;

use Closure;

/**
 * role:{module} — needs "{module}" to open the module, and the matching
 * action permission for writes: create/store → "{module}_add",
 * edit/update → "{module}_edit", destroy → "{module}_delete".
 */
class CheckRole
{
    private const ACTIONS = [
        'create' => 'add', 'store' => 'add',
        'edit' => 'edit', 'update' => 'edit',
        'destroy' => 'delete',
    ];

    public function handle($request, Closure $next, $role)
    {
        $group = getgroup();
        $method = $request->route()?->getActionMethod();
        $action = self::ACTIONS[$method] ?? null;

        if (! groupHasPermission($group, $role) || ($action && ! groupHasPermission($group, $role.'_'.$action))) {
            return redirect('trika/not_allow');
        }

        return $next($request);
    }
}
