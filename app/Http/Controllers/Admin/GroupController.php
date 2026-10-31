<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    public function index()
    {
        return view('admin.groups.index', [
            'groups' => Group::withCount('users')->get(),
            'counts' => Permission::selectRaw('group_id, count(*) as total')->groupBy('group_id')->pluck('total', 'group_id'),
        ]);
    }

    public function create()
    {
        return view('admin.groups.form', ['group' => new Group, 'granted' => []]);
    }

    public function store(Request $request)
    {
        $group = new Group;
        $this->save($group, $request);

        return redirect('admin/groups')->with('message', trans('layout.add_suc'));
    }

    public function edit(Group $group)
    {
        return view('admin.groups.form', [
            'group' => $group,
            'granted' => Permission::where('group_id', $group->id)->pluck('permission')->all(),
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $this->save($group, $request);

        return redirect('admin/groups')->with('message', trans('layout.edit_suc'));
    }

    public function destroy(Group $group)
    {
        if ($group->id === (int) config('permissions.super_group') || User::where('group_id', $group->id)->exists()) {
            return back()->with('message', trans('layout.group_in_use'));
        }

        DB::transaction(function () use ($group) {
            Permission::where('group_id', $group->id)->delete();
            $group->delete();
        });

        return back()->with('message', trans('layout.delete_suc'));
    }

    private function save(Group $group, Request $request): void
    {
        $data = $request->validate([
            'ar_name' => ['required', 'string', 'max:255', Rule::unique('groups', 'ar_name')->ignore($group->id)],
            'en_name' => ['required', 'string', 'max:255', Rule::unique('groups', 'en_name')->ignore($group->id)],
            'permissions' => 'array',
            'permissions.*' => [Rule::in(all_permissions())],
        ]);

        // The top admin group always keeps every permission.
        $permissions = $group->id === (int) config('permissions.super_group')
            ? all_permissions()
            : array_values(array_unique($data['permissions'] ?? []));

        DB::transaction(function () use ($group, $data, $permissions) {
            $group->ar_name = $data['ar_name'];
            $group->en_name = $data['en_name'];
            $group->save();

            Permission::where('group_id', $group->id)->delete();
            Permission::insert(array_map(fn ($p) => [
                'group_id' => $group->id, 'permission' => $p, 'created_at' => now(), 'updated_at' => now(),
            ], $permissions));
        });
    }
}
