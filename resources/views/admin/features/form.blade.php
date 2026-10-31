@extends('admin.layouts.form')

@section('content')
@php $editing = $feature->exists; @endphp
@include('admin.partials.page-head', ['title' => trans('layout.features'), 'parent' => ['trika/features', trans('layout.features')], 'current' => trans($editing ? 'layout.edit' : 'layout.add')])
<section class="content">
    <div class="box box-default">
        <form action="{{ URL::to('trika/features'.($editing ? '/'.$feature->uuid : '')) }}" method="post">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="box-body">
                @include('admin.partials.field', ['name' => 'ar_title', 'label' => trans('layout.feature_title_ar'), 'value_' => $feature->ar_title])
                @include('admin.partials.field', ['name' => 'en_title', 'label' => trans('layout.feature_title_en'), 'value_' => $feature->en_title])
                @include('admin.partials.field', ['name' => 'sort', 'label' => trans('layout.sort'), 'type' => 'number', 'min' => 0, 'value_' => $feature->sort ?? 0])
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg">{{ trans($editing ? 'layout.edit' : 'layout.add') }}</button>
                <a href="{{ URL::to('trika/features') }}" class="btn btn-default btn-lg">{{ trans('layout.back') }}</a>
            </div>
        </form>
    </div>
</section>
@endsection
