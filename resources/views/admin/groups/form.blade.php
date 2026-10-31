@extends('admin.layouts.form')

@section('content')
@php
    $editing = $group->exists;
    $isSuper = $editing && $group->id === (int) config('permissions.super_group');
    $actions = ['view', 'add', 'edit', 'delete'];
    $granted = old('permissions', $granted);
@endphp
@include('admin.partials.page-head', ['title' => trans('layout.groups'), 'parent' => ['admin/groups', trans('layout.groups')], 'current' => trans($editing ? 'layout.edit' : 'layout.add')])
<section class="content">
    <form action="{{ URL::to('admin/groups'.($editing ? '/'.$group->uuid : '')) }}" method="post">
        @csrf
        @if ($editing) @method('PUT') @endif
        <div class="box box-default">
            <div class="box-body">
                @include('admin.partials.field', ['name' => 'ar_name', 'label' => trans('layout.group_name_ar'), 'value_' => $group->ar_name])
                @include('admin.partials.field', ['name' => 'en_name', 'label' => trans('layout.group_name_en'), 'value_' => $group->en_name])
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header" style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap">
                <h3 class="box-title" style="margin:0">{{ trans('layout.permissions') }}</h3>
                @unless ($isSuper)
                    <label style="margin:0;cursor:pointer"><input type="checkbox" data-check-all> {{ trans('layout.select_all') }}</label>
                @endunless
            </div>
            <div class="box-body">
                @if ($isSuper)
                    <div class="alert alert-success">{{ trans('layout.super_group_note') }}</div>
                @endif
                <table class="table perm-matrix">
                    <thead>
                        <tr>
                            <th>{{ trans('layout.module') }}</th>
                            @foreach ($actions as $action)
                                <th class="text-center">{{ trans('layout.perm_'.$action) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    @foreach (config('permissions.sections') as $section)
                        <tbody>
                            <tr><td colspan="5" class="perm-section">{{ trans('layout.'.$section) }}</td></tr>
                            @foreach (collect(config('permissions.modules'))->where('section', $section) as $key => $module)
                                <tr data-row>
                                    <td><i class="fa {{ $module['icon'] }}" style="color:#b97a56;width:20px"></i> {{ trans('layout.'.$module['label']) }}</td>
                                    @foreach ($actions as $action)
                                        @php $perm = $action === 'view' ? $key : $key.'_'.$action; @endphp
                                        <td class="text-center">
                                            @if ($action === 'view' || in_array($action, $module['actions']))
                                                <input type="checkbox" name="permissions[]" value="{{ $perm }}" data-action="{{ $action }}"
                                                       @checked($isSuper || in_array($perm, $granted)) @disabled($isSuper)
                                                       style="width:18px;height:18px;accent-color:#b97a56">
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    @endforeach
                </table>
                @error('permissions.*')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg">{{ trans($editing ? 'layout.edit' : 'layout.add') }}</button>
                <a href="{{ URL::to('admin/groups') }}" class="btn btn-default btn-lg">{{ trans('layout.back') }}</a>
            </div>
        </div>
    </form>
</section>

<style>
    .perm-matrix .perm-section { background: #f6f3f0; font-weight: 700; color: #8c5536; }
    .perm-matrix td, .perm-matrix th { vertical-align: middle !important; }
</style>
<script>
    document.addEventListener('change', function (e) {
        var box = e.target;
        if (box.matches('[data-check-all]')) {
            document.querySelectorAll('.perm-matrix input[type=checkbox]:not(:disabled)').forEach(function (c) { c.checked = box.checked; });
            return;
        }
        if (!box.matches('.perm-matrix input[type=checkbox]')) return;
        var row = box.closest('[data-row]');
        var view = row.querySelector('[data-action=view]');
        // Any action needs "view"; removing "view" removes the actions too.
        if (box !== view && box.checked) view.checked = true;
        if (box === view && !box.checked) row.querySelectorAll('input').forEach(function (c) { c.checked = false; });
    });
</script>
@endsection
