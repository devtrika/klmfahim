@extends('admin.layouts.table')

@section('content')
@include('admin.partials.page-head', ['title' => trans('layout.groups')])
<section class="content">
    <div class="box">
        @perm('groups_add')
            <div class="box-header">
                <a href="{{ URL::to('admin/groups/create') }}" class="btn btn-lg bg-fuchsia"><i class="fa fa-plus"></i> {{ trans('layout.add') }}</a>
            </div>
        @endperm
        <div class="box-body">
            <table class="table table-hover">
                <thead><tr><th>{{ trans('layout.group_name_ar') }}</th><th>{{ trans('layout.group_name_en') }}</th><th>{{ trans('layout.admins') }}</th><th>{{ trans('layout.permissions') }}</th><th></th></tr></thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->ar_name }} @if ($group->id === (int) config('permissions.super_group'))<span class="label-ink">★</span>@endif</td>
                            <td>{{ $group->en_name }}</td>
                            <td>{{ $group->users_count }}</td>
                            <td><span class="label-copper">{{ $counts[$group->id] ?? 0 }} / {{ count(all_permissions()) }}</span></td>
                            <td class="text-nowrap">
                                @perm('groups_edit')
                                    <a href="{{ URL::to('admin/groups/'.$group->uuid.'/edit') }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> {{ trans('layout.edit') }}</a>
                                @endperm
                                @perm('groups_delete')
                                    @if ($group->id !== (int) config('permissions.super_group') && ! $group->users_count)
                                        <form action="{{ URL::to('admin/groups/'.$group->uuid) }}" method="post" style="display:inline" onsubmit="return confirm('?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> {{ trans('layout.delete') }}</button>
                                        </form>
                                    @endif
                                @endperm
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
