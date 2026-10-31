@extends('admin.layouts.form')

@section('content')
@php
    $editing = $item->exists;
    $groups = collect(\App\Models\CalculatorItem::GROUPS)->mapWithKeys(fn ($g) => [$g => trans('layout.calc_group_'.$g)])->all();
@endphp
@include('admin.partials.page-head', ['title' => trans('layout.calculator_items'), 'parent' => ['admin/calculator', trans('layout.calculator_items')], 'current' => trans($editing ? 'layout.edit' : 'layout.add')])
<section class="content">
    <div class="box box-default">
        <form action="{{ URL::to('admin/calculator'.($editing ? '/'.$item->uuid : '')) }}" method="post">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="box-body">
                @include('admin.partials.field', ['name' => 'group', 'label' => trans('layout.calc_group'), 'type' => 'select', 'options' => $groups, 'value_' => $item->group])
                @include('admin.partials.field', ['name' => 'ar_title', 'label' => trans('layout.title_ar'), 'value_' => $item->ar_title])
                @include('admin.partials.field', ['name' => 'en_title', 'label' => trans('layout.title_en'), 'value_' => $item->en_title])
                @include('admin.partials.field', ['name' => 'ar_hint', 'label' => trans('layout.hint_ar').' ('.trans('layout.optional').')', 'value_' => $item->ar_hint])
                @include('admin.partials.field', ['name' => 'en_hint', 'label' => trans('layout.hint_en').' ('.trans('layout.optional').')', 'value_' => $item->en_hint])
                @include('admin.partials.field', ['name' => 'price', 'label' => trans('layout.price').' (AED)', 'type' => 'number', 'min' => 0, 'value_' => $item->price ?? 0])
                @include('admin.partials.field', ['name' => 'sort', 'label' => trans('layout.sort'), 'type' => 'number', 'min' => 0, 'value_' => $item->sort ?? 0])
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg">{{ trans($editing ? 'layout.edit' : 'layout.add') }}</button>
                <a href="{{ URL::to('admin/calculator') }}" class="btn btn-default btn-lg">{{ trans('layout.back') }}</a>
            </div>
        </form>
    </div>
</section>
@endsection
